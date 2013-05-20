<?php
namespace li3_menu\extensions\helper ;

use lithium\net\http\Router ;
use lithium\action\Request ;
use lithium\util\String ;

/**
 * A helper class to facilitate generating, a menu, with automatic active classes.
 *
 * You just gives a label and an url and the Menu helper do the job :
 * {{{
 * // In view code:
 * <?=$this->menu->display(array(
 * 'Home' => '/',
 * 'My pictures' => '/pictures/mine'
 * )) ; ?>
 * }}}
 */
class Menu extends \lithium\template\Helper {

	/**
	 * Default properties.
	 *
	 * @var array
	 */
	static $defaults = array(
		'open' => '<ul class="menu {:class}">',
		'content' => '<li class="menu-item {:active}"><a href="{:link}">{:label}</a></li>',
		'close' => '</ul>',
		'class' => ''
	) ;

	/**
	 * Current request.
	 *
	 * @var \lithium\action\Request
	 */
	public $request ;

	/**
	 * Initialisation : remember the current request.
	 */
	public function _init() {
		parent::_init() ;
		$this->request = $this->_context ? $this->_context->request() : null;
	}

	/**
	 * Main method
	 * @param  array  $menu    The menu description.
	 * @param  array  $options Options.
	 * @return string          The HTML buffer.
	 */
	public function display(array $menu, array $options = array()) {
		$options += static::$defaults ;
		$menu  = $this->_prepare($menu, $options) ;
		$out = String::insert($options['open'], $options) ;
		foreach($menu as $item) {
			$out .= String::insert($options['content'], $item) ;
		}
		$out .= $options['close'] ;

		return $out ;
	}

	/**
	 * Prepare data to display and calculate the current node.
	 * @param  array  $menu    The menu description.
	 * @param  array  $options Options.
	 * @return array           Calulated menu.
	 */
	protected function _prepare(array $menu, array $options = array()) {
		$return = array() ;
		$active = '' ;
		$current = array_filter($this->request->params) ;

		foreach($menu as $label => $mask) {
			$active = $active ? '' : 'active' ;
			if (!is_array($mask)) {
				$request = new Request();
    			$request->url = $mask ;
    			$mask = Router::parse($request)->params ;
    		}
    		$active = $this->_matches($mask, $current) ? 'active' : '' ;

    		// Cleaning
    		$mask = array_filter($mask) ;

    		$return[] = array('label' => $label, 'link' => Router::match($mask), 'active' => $active) + $options ;
		}

		return $return ;
	}

	/**
	 * Check if a mask matches the current url.
	 * @param  array $mask    	Mask to test
	 * @param  array $current 	Current URL
	 * @return bool          	Yep ? Nope ?
	 */
	protected function _matches(&$mask, &$current) {
		foreach($mask as $key => $value) {
			if (!isset($current[$key])) {
				return false ;
			}
			if (is_array($value) && !$this->_matches($mask[$key], $current[$key])) {
				return false ;
			}
			if ($value !== strtolower($current[$key])) {
				return false ;
			}
		}
		return true ;
	}
}
