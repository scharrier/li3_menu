li3_menu : Lithium menu generator
=================================

Creating a menu in Lithium should be easy. This little helper does only one thing : it takes a menu, identifies the active link and render a ul/li menu.

Installation
------------

Just add in your config/bootstrap/libraries.php :

    Libraries::add('li3_menu') ;
    
And in your view :

    $this->menu->display(array(
      'Home' => '/',
      'My pictures' => '/pictures
    ));
