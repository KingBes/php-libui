# php-libui

⭐ PHP-FFI bindings for libui, enabling cross-platform GUI development.

`libui` is a powerful, lightweight, and portable GUI library.

Documentation will be updated continuously. Contributions (stars, issues, PRs) are welcome!

## [中文](./README.md)

## Dependencies

- PHP 8.2+
- PHP-FFI extension enabled

## Supported Platforms

- Windows Vista SP2 or later (x86_64)
- macOS OS X 10.8 or later (x86_64)
- Linux GTK+ 3.10 or later (x86_64)

## Installation

```bash
composer require kingbes/libui
```

## Example

```php
<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App; // Application
use Kingbes\Libui\Window; // Window
use Kingbes\Libui\Control; // Control
use Kingbes\Libui\Box; // Container
use Kingbes\Libui\Button; // Button

// Initialize application
App::init();
// Create main window
$window = Window::create("Demo Window", 640, 480, 0);
// Set window margin
Window::setMargined($window, true);
// Window close event
Window::onClosing($window, function ($window) {
    echo "Exit application\n";
    // Exit application
    App::quit();
    // Return 1: Success, Return 0: Failed
    return 1;
});

// Create vertical container
$box = Box::newVerticalBox();
Box::setPadded($box, true); // Set padding
Window::setChild($window, $box); // Set window child
// Create button
$btn01 = Button::create("Click Me!");
// Append button to container
Box::append($box, $btn01, false);
// Button click event
Button::onClicked($btn01, function ($btn01) use ($window) {
    echo "Button clicked!\n";
    // Show message box
    Window::msgBox($window, "Info", "PHP - The best language in the world!");
});

// Show control
Control::show($window);
// Main loop
App::main();

```

![Example](./test/demo.png)
