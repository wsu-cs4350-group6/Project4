<?php

$bootstrap = realpath(
    __DIR__
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . 'src'
    . DIRECTORY_SEPARATOR . 'Config'
    . DIRECTORY_SEPARATOR . 'bootstrap.php'
);

require $bootstrap;