<?php

/**
 * Root path
 * ---------------------------
 * Defined once
 * ---------------------------
 */
const PATH = __DIR__."/";

function __autoload($class) {
    require str_replace("\\", "/", PATH.lcfirst($class).".php");
}

require_once "system/helpers.php";
require_once "system/routes.php";