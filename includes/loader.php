<?php
/** config.php の読み込み */
require_once APP_PATH . 'config.php';

/** 設定によるその他設定の定義・上書き */
define( 'APP_URL', ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] );
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
