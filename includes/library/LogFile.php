<?php

class LogFile {
    private $output;
    public $to_admin;

    public function __construct( $output ) {
        $this->output = $output;
        if ( !file_exists( dirname( $output ) ) ) AppError::id( 5 );
    }

    public function write( $log_output_items, $values ) {
        $open_mode = file_exists( $this->output ) ? 'a' : 'w';
        try {
            $res = fopen( $this->output, $open_mode );
            $csv_header = array_merge( ['__datetime__'], $log_output_items );
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