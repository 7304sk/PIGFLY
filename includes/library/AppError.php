<?php

class AppError {
    private static $err = [
        '<h1>ERROR 00</h1><p>You have no referer.</p>',
        '<h1>ERROR 01</h1><p>The referer is invalid.</p>',
        '<h1>ERROR 02</h1><p>The token is incorrect.</p>',
    ];

    private function __construct() {}

    public static function exit( $id ) {
        exit( self::$err[ $id ] );
    }
}
