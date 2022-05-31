<?php

class LogFile {
    private $output;
    public $to_admin;

    public function __construct( $output ) {
        $output_ = '';
        if ( mb_substr($output, 0, 1) === '/' ) {
            $output_ = $output;
        } elseif ( mb_substr($output, 0, 2) === './' ) {
            $output_ = APP_PATH . mb_substr($output, 2);
        } else {
            $output_ = APP_PATH . $output;
        }
        $this->output = $output_;

        /** ディレクトリの存在確認、なければ作成 */
        $output_dir = dirname($output_);
        if ( !file_exists($output_dir) ) {
            try {
                mkdir( $output_dir, 0644 );
                chmod( $output_dir, 0644 );
            } catch( Exception $e ) {
                AppError::id( 5 );
            }
        }
    }

    public function write( $log_output_items, $values ) {
        $open_mode = file_exists( $this->output ) ? 'a' : 'w';
        try {
            $res = fopen( $this->output, $open_mode );
            $csv_header = array_merge( ['meta_datetime'], $log_output_items );
            mb_convert_variables( 'SJIS', 'UTF-8', $csv_header );
            if ( $open_mode === 'w' ) {
                fputcsv( $res, $csv_header );
            }
            $write_values = ['__datetime__' => date("Y-m-d H:i:s")];
            foreach( $log_output_items as $item ) {
                $item_flg = false;
                foreach ( $values as $key => $value ) {
                    if ( $key === $item ) {
                        $str = mb_convert_encoding( $value, 'SJIS', 'UTF-8' );
                        $write_values = array_merge( $write_values, [$key => $str] );
                        $item_flg = true;
                        break;
                    }
                }
                if ( !$item_flg ) $write_values = array_merge( $write_values, [$item => ''] );
            }
            fputcsv( $res, $write_values );
            fclose( $res );
        } catch( Exception $e ) {
                AppError::id( 6 );
        }
    }
}