<?php
use Cake\Routing\Router;

Router::plugin('Imap', function ($routes) {
    $routes->fallbacks();
});
