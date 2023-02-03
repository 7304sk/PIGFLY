<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../../config.php';

$script = <<< EOT
grecaptcha.ready(function () {
    grecaptcha.execute('${recaptcha_site_key}', {action: 'submit'}).then(function(token) {
        const recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
    });
});
EOT;

header('Content-Type: application/x-javascript; charset=utf-8');
echo $script;