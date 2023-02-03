<?php
require_once __DIR__ . '/../loader.php';

$script = <<< EOT
const recaptcha_script = document.createElement('script');
recaptcha_script.src = 'https://www.google.com/recaptcha/api.js?render=${recaptcha_site_key}';
document.body.appendChild(script);

window.addEventListener('DOMContentLoaded',() => {
    const PIGFLY_form = document.querySelector('#PIGFLY');
    PIGFLY_form.addEventLstener('submit', e => {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('${recaptcha_site_key}', {action: 'submit'}).then(function(token) {
                PIGFLY_form.submit();
            });
        });
    });
});
EOT;

header('Content-Type: application/x-javascript; charset=utf-8');
echo $script;