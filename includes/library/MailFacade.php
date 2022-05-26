<?php

class MailFacade {
    public $to_user;
    public $to_admin;

    /** メールファサードを取得 */
    public function __construct() {
        $this->to_user = require_once APP_PATH . 'mail/to_user.php';
        $this->to_admin = require_once APP_PATH . 'mail/to_admin.php';
    }
}