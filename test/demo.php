<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;

App::init();
$window = Window::create("窗口", 640, 480, 0);
$control = new Control();
Window::setMargined($window, true);
Window::onClosing($window, function ($window, $cData) {
    echo "窗口关闭";
    App::quit();
    return 1;
});
Control::show($window);
App::main();

