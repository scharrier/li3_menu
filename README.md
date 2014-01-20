li3_menu : Lithium menu generator
=================================

Creating a menu in Lithium should be easy. This little helper does only one thing : it takes a menu, identifies the active link and render a ul/li menu.

Installation
------------

Just add in your config/bootstrap/libraries.php :

```php
	Libraries::add('li3_menu') ;
```

And in your view :

```php
    $this->menu->display(array(
      'Home' => '/',
      'My pictures' => '/pictures'
    ));
```

Advanced usage
--------------

You can specify more params into your links by defining them as arrays :
- url : destination (can be an array or a string)
- mask : if you wan't to specify a more specific mask. By default, the mask is the destination url.
- active : if you want to force an active item, set this to (bool) true.
- class : if you want to add a css class to your item

```php
    $this->menu->display(array(
      'Home' => ['url' => '/', 'mask' => ['controller' => 'home']] // Will be active for all the Home controller actions
      'My pictures' => ['url' => ['controller' => 'pictures', 'action' => my], 'class' => 'my-pictures']
    ));
```

