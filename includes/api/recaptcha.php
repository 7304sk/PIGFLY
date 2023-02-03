<?php
require_once __DIR__ . '/../loader.php';

$script = <<< EOT
const recaptcha_script = document.createElement('script');
recaptcha_script.src = 'https://www.google.com/recaptcha/api.js?render=${recaptcha_site_key}';
document.body.appendChild(script);

window.addEventListener('DOMContentLoaded',() => {
    grecaptcha.ready(function () {
        grecaptcha.execute('${recaptcha_site_key}', {action: 'submit'}).then(function(token) {
            const recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
});
EOT;

header('Content-Type: application/x-javascript; charset=utf-8');
echo $script;