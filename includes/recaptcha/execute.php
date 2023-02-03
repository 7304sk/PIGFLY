<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../../config.php';

$script = <<< EOT
const recaptchaResponse = document.getElementById('recaptchaResponse');
const recaptchaForm = recaptchaResponse.closest('form');

recaptchaForm.addEventListener('submit', e => {
    e.preventDefault();
        grecaptcha.ready(function () {
            grecaptcha.execute('${recaptcha_site_key}', {action: 'submit'}).then(function(token) {
                recaptchaResponse.value = token;
                recaptchaForm.submit();
            });
        });
});
EOT;

header('Content-Type: application/x-javascript; charset=utf-8');
echo $script;