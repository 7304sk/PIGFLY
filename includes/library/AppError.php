<?php

class AppError {
    private static $message = [
        1 => 'You have no referer.',
        2 => 'The referer is invalid.',
        3 => 'The token is incorrect.',
        4 => 'There are function references from invalid locations.',
        5 => 'Failed to create directory for log file output. Please create the directory manually.',
        6 => 'Failed to write log csv.',
    ];

    private function __construct() {}

    public static function id( $i ) {
        $mes = '<h1>ERROR ' . sprintf('%02d', $i) . "</h1>\n<p>" . self::$message[ $i ] . '</p>';
        exit( $mes );
    }
}