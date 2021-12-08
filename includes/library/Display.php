<?php

class Display {
    private $css = array();
    private $js = array();
    public $title;

    public function __construct( $title ) {
        $this->title = $title;
    }

    public function setCSS( $link ) {
        $this->css[] = APP_URL . $link;
    }

    public function setJS( $link ) {
        $this->js[] = APP_URL . $link;
    }

    public function getHeader() {
        $page_title = $this->title;
        $css_links = $this->css;
        $js_links = $this->js;
        require_once APP_PATH . 'includes/template-parts/header.php';
    }

    public function getFooter() {
        $page_title = $this->title;
        $css_links = $this->css;
        $js_links = $this->js;
        require_once APP_PATH . 'includes/template-parts/footer.php';
    }

    public static function view( $view ) {
        extract( $GLOBALS );
        ob_start();
        require_once $view;
        echo ob_get_clean();
        exit;
    }
}
