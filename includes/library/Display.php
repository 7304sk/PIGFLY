<?php

class Display {
    private $css = array();
    private $js = array();
    private $favicon;
    public $title;

    function __construct( $title ) {
        $this->title = $title;
    }

    public function addCSS( $link ) {
        $this->css[] = APP_URL . 'view/' . $link;
    }

    public function addJS( $link ) {
        $this->js[] = APP_URL . 'view/' . $link;
    }

    public function setFavicon( $link ) {
        $this->favicon = APP_URL . 'view/' . $link;
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
