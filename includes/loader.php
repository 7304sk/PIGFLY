<?php
/** クラスローダー */
class ClassLoader {
    protected $dirs;

    public function set( $dir ) {
        $this->dirs[] = $dir;
    }

    public function start() {
        spl_autoload_register( array( $this, 'loadClass' ) );
    }

    public function loadClass( $class ) {
        foreach( $this->dirs as $dir ) {
            $file = $dir. '/' . $class . '.php';
            if( is_readable( $file ) ) {
                require $file;
                return;
            }
        }
    }
}

/** その他ファイルの読み込み */
$replace_map = require_once APP_PATH . 'includes/replace.php';
require_once APP_PATH . 'includes/functions.php';