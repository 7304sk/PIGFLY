<?php
/** config.php の読み込み */
require_once APP_PATH . 'config.php';

$mode_spa = false; // 仮：v2.0.0 で SPA モードを実装する予定の為

/** 設定によるその他設定の定義・上書き */
if( empty( $app_url ) ) {
    $app_url = ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
    define( 'APP_URL', explode( 'index.php', $app_url )[0] );
} else {
    define( 'APP_URL', $app_url );
}
unset( $app_url );
array_push( $mandatory, $user_email );
if( $mode_email_retype && ! empty( $email_retype ) ) array_push( $mandatory, $email_retype );
if( $mode_test ) ini_set('display_errors', 1);
if( empty( $mail_sender ) ) $mail_sender = 'no-reply@' . $_SERVER[ 'HTTP_HOST' ];
if( empty( $page_thanks ) ) $page_thanks = ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ];

/** クラスローダーの実行 */
require APP_PATH . 'includes/library/ClassLoader.php';
$loader = new ClassLoader();
$loader->set( APP_PATH . 'includes/library' );
$loader->start();

/** その他ファイルの読み込み */
$replace_map = require_once APP_PATH . 'includes/replace.php';
require_once APP_PATH . 'includes/functions.php';
