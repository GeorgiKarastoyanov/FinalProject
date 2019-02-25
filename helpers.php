<?php
function dd() {
    echo '<pre>';
    array_map(function ($a) {
        var_dump($a);
    }, func_get_args());
    echo '</pre>';
    die;
}