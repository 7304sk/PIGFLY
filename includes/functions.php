<?php

function console_log( $var ) {
    echo '<script>console.log('. json_encode( $var ) .')</script>';
}

function var_pre( $var ) {
    echo '<pre>';
    echo Sanitize::hsc( var_export( $var, true ) );
    echo '</pre>';
}

/** Check HTTP referer */
function refererCheck( $app_domain ) {
    $domains = array_merge( [ $_SERVER[ 'SERVER_NAME' ] ], $app_domain );
    if( empty( $_SERVER[ 'HTTP_REFERER' ] ) ) AppError::exit( 0 );
    $url_arr = parse_url( $_SERVER[ 'HTTP_REFERER' ] );
    if ( ! in_array( $url_arr[ 'host' ], $domains, true ) ) AppError::exit( 1 );
}

/** Expansion posts array */
function implodeVal( $arr ) {
    $str = '';
    if( is_array( $arr ) ) {
        foreach( $arr as $key => $val ) {
            if( is_array( $val ) ) {
                foreach( $val as $kk => $vv ) {
                    if( $kk === 0 || $vv == '' ) $kk = '';
                    $str .= $vv . $kk . ', ';
                }
            } else {
                $str .= $val.', ';
            }
        }
        $str = rtrim($str,', ');
    } else {
        $str = $arr;
    }
    return $str;
}