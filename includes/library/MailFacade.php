<?php

class MailFacade {
    private $mf_user;
    private $mf_admin;

    /** メールファサードを取得 */
    public function __construct() {
        $this->mf_user = require_once APP_PATH . 'mail/to_user.php';
        $this->mf_admin = require_once APP_PATH . 'mail/to_admin.php';
    }

    public function to_user() {
        return $this->mf_user;
    }

    public function to_admin() {
        return $this->mf_admin;
    }
}