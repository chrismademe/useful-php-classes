<?php

/**
 * Dev:
 * Useful Developer functions to aid
 * and speed up development/debugging
 *
 * Work in progress!
 */

namespace Dev;

class Dev {

    /**
     * Dump
     * Like system print_r function but
     * output is wrapped in <pre> tags
     * for easier reading
     *
     * Accepts an array or object
     */
    public static function dump( $array, $function = 'print_r' ) {
        echo '<pre>';
            $function($array);
        echo '</pre>';
    }

}

/********************************
 ** Examples                    *
 ********************************/

// Setup an array
$array = [
    'hello_world' => 'Hello World!',
    'goodbye_world' => 'Goodbye World!'
];

// Dump array to the screen with print_r (default)
Dev::dump($array);

// Dump array to the screen with var_dump (default)
Dev::dump($array, 'var_dump');
