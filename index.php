<?php
/** APP_PATH, APP_URL の定義  */
define( 'APP_PATH', __DIR__ . '/' );
define( 'APP_URL', ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] );

/** config.php の読み込み */
require_once APP_PATH . 'config.php';
array_push( $mandatory, $user_email );
if( $mode_email_retype && ! empty( $email_retype ) ) array_push( $mandatory, $email_retype );
if( $mode_test ) ini_set('display_errors', 1);
if( empty( $mail_sender ) ) $mail_sender = 'no-reply@' . $_SERVER[ 'HTTP_HOST' ];
if( empty( $page_thanks ) ) $page_thanks = ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ];

/** ローダーの読み込み、実行 */
require APP_PATH . 'includes/loader.php';
$loader = new ClassLoader();
$loader->set( APP_PATH . 'includes/library' );
$loader->start();

/** リファラチェック実行 */
refererCheck( $app_domain );

/**
 * Main process
 */
if( $mode_confirm ) {
    session_name( 'PIGFLY' );
    session_start();
}
$_POST = isset( $_POST ) ? clearNull( $_POST ) : array();
$input = new Input( $_POST );
$input->check();
if( $input->error() ) {
    /** エラー画面出力 */
    Display::view( APP_PATH . 'view/error.php' );
} else {
    if( $mode_confirm && ! $input->confirmed() ) {
        /** 確認画面出力 */
        $_SESSION[ 'file' ] = $input->file();
        Display::view( APP_PATH . 'view/confirm.php' );
    } else {
        /** 送信メール設定 */
        mb_language( 'Japanese' );
        mb_internal_encoding( 'UTF-8' );
        $mail_facade = new MailFacade;
        $send_file = ( ! empty( $_SESSION[ 'file' ] ) ) ? $_SESSION[ 'file' ] : ( ( ! empty( $input->file() ) ) ? $input->file() : array() );
        $to_user = new Mail( $admin_email, $input->value( $user_email ), $input->value(), $mail_facade->to_user() );
        $to_admin = new Mail( $input->value( $user_email ), $admin_email, $input->value(), $mail_facade->to_admin(), $send_file );
        if( session_status() === PHP_SESSION_ACTIVE ) {
            $_SESSION = array();
            session_destroy();
        }
        /** ログファイル出力 */
        if( $mode_log ) {
            $log_file = new LogFile( $log_output_file );
            $log_file->write( $log_output_items, $input->value() );
        }
        /** メール送信、画面遷移 */
        if( $mode_test ) {
            Display::view( APP_PATH . 'view/result.php' );
        } else {
            $to_user->send();
            $to_admin->send();
            header( "location: " . $page_thanks, true, 301 );
            exit;
        }
    }
}