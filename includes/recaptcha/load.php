<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../../config.php';

if( empty( $app_url ) ) {
    $app_url = ( ( ( ! empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' ) ) ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
    $the_dir = explode( 'load.php', $app_url )[0];
} else {
    $the_dir = $app_url;
}

$script = <<< EOT
const script_recaptcha = document.createElement('script');
script_recaptcha.src = 'https://www.google.com/recaptcha/api.js?render=${recaptcha_site_key}';
document.body.appendChild(script_recaptcha);

const script_execute = document.createElement('script');
script_execute.src = '${the_dir}execute.php';
document.body.appendChild(script_execute);
EOT;

header('Content-Type: application/x-javascript; charset=utf-8');
echo $script;