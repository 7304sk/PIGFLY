<?php

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
