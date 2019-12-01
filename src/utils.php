<?php

require_once "../conf/config_options.php";

function get(&$var, $default=null) {
    return isset($var) ? $var : $default;
}

function epoch_to_date($epoch) {
    global $DATE_FORMAT;
    return epoch_to_timestamp($epoch, $fmt=$DATE_FORMAT);
}

function epoch_to_time($epoch) {
    global $TIME_FORMAT;
    return epoch_to_timestamp($epoch, $fmt=$TIME_FORMAT);
}

function epoch_to_timestamp($epoch, $fmt=null) {
    if (!isset($fmt)) {
        global $DATETIME_FORMAT;
        $fmt = $DATETIME_FORMAT;
    }
    return date($fmt, $epoch);
}

function dump() {
    $args = func_get_args();
    echo "<br>==========<br>";
    foreach ($args as $arg) {
        var_dump($arg);
        echo "<br>";
    }
    echo "==========<br>";
}
