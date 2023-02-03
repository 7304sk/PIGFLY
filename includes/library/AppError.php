<?php

class AppError {
    private static $message = [
        1 => 'You have no referer.',
        2 => 'The referer is invalid.',
        3 => 'The token is incorrect.',
        4 => 'Function executed at incorrect time.',
        5 => 'Failed to create directory for log file output. Please create the directory manually.',
        6 => 'Failed to write log csv.',
        7 => 'Incorrect key specified.',
        8 => 'recaptchaResponse does not posted.',
        9 => 'reCAPTCHA authentication failed.'
    ];

    private function __construct() {}

    public static function id( $i ) {
        global $mode_spa;
        if( $mode_spa ) {
            self::json( $i );
        } else {
            self::page( $i );
        }
    }
    private static function page( $i ) {
        $mes = '<h1>ERROR ' . sprintf('%02d', $i) . "</h1>\n<p>" . self::$message[ $i ] . '</p>';
        exit( $mes );
    }
    private static function json( $i ) {
        $json = [
            'app_error',
            '<h1>ERROR ' . sprintf('%02d', $i) . '</h1>',
            '<p>' . self::$message[ $i ] . '</p>'
        ];
        echo json_encode( $json );
        exit();
    }
}