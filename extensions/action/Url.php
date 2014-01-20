<?php
namespace li3_menu\extensions\action ;

use lithium\net\http\Router ;
use lithium\action\Request ;

/**
 * Uri tools.
 */
class Url extends \lithium\core\Object {

	/**
	 * Compare $url with $mask. Returns true if there is a match !
	 *
	 * @param  mixed $url   String, array or Request : url to test
	 * @param  array  $mask Mask, in a Request::$params form
	 * @return bool         Yep/nope ?
	 */
	public static function match($url, array $mask) {
		// Multiple $url types
		if ($url instanceof Request) {
			$test = Router::parse($url) ;
		} elseif (is_string($url)) {
			$request = new Request() ;
			$request->url = $url ;
			$test = Router::parse($request) ;
		} else {
			$test = $url ;
		}

		foreach($mask as $key => $value) {
			if (!isset($test[$key])) {
				return false ;
			}
			if (is_array($value) && !static::match($mask[$key], $test[$key])) {
				return false ;
			}
			if (strtolower($value) !== strtolower($test[$key])) {
				return false ;
			}
		}
		return true ;
	}
}
