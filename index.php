<?php
/** Define APP_PATH as this file's directory */
define( 'APP_PATH', __DIR__ . '/' );
define( 'APP_URL', ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] );

/** Load initial settings */
require_once APP_PATH . 'config.php';
array_push( $mandatory, $user_email );
if( $mode_email_retype && ! empty( $email_retype ) ) array_push( $mandatory, $email_retype );
if( $mode_test ) ini_set('display_errors', 1);

/** Include class loader */
require APP_PATH . 'includes/loader.php';
$loader = new ClassLoader();
$loader->set( APP_PATH . 'includes/library' );
$loader->start();

/** Include static functions */
require_once APP_PATH . 'includes/functions.php';

/** Check the referer */
refererCheck( $app_domain );

/**
 * Start main process
 */
if( $mode_confirm ) {
    session_name( 'PIGFLY' );
    session_start();
}
$_POST = isset( $_POST ) ? Sanitize::clearNull( $_POST ) : array();
$input = new Input( $_POST );
$input->check();
if( $input->err ) {
    Display::view( APP_PATH . 'page/error.php' );
} else {
    if( $mode_confirm && ! $input->confirmed ) {
        $_SESSION[ 'file' ] = $input->file;
        Display::view( APP_PATH . 'page/confirm.php' );
    } else {
        /** send mail */
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        $mail_facade = new MailFacade;
        $send_file = ( ! empty( $_SESSION[ 'file' ] ) ) ? $_SESSION[ 'file' ] : ( ( ! empty( $input->file ) ) ? $input->file : array() );
        $to_user = new Mail( $admin_email, $input->val[ $user_email ], $input->val, $mail_facade->to_user );
        $to_admin = new Mail( $input->val[ $user_email ], $admin_email, $input->val, $mail_facade->to_admin, $send_file );
        if( session_status() == PHP_SESSION_ACTIVE ) {
            $_SESSION = array();
            session_destroy();
        }
        /** Finish */
        if( $mode_test ) {
            Display::view( APP_PATH . 'page/result.php' );
        } else {
            $to_user->send();
            $to_admin->send();
            header("location: ".$page_thanks, true, 301);
            exit;
        }
    }
}