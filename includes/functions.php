<?php
/** 簡易リファラチェック（CRSF対策） */
function refererCheck( $app_domain ) {
    $domains = array_merge( [ $_SERVER[ 'SERVER_NAME' ] ], $app_domain );
    if( empty( $_SERVER[ 'HTTP_REFERER' ] ) ) AppError::id( 1 );
    $url_arr = parse_url( $_SERVER[ 'HTTP_REFERER' ] );
    if ( ! in_array( $url_arr[ 'host' ], $domains, true ) ) AppError::id( 2 );
}

/** ヌルバイトインジェクション対策 */
function clearNull( $arr ) {
    return is_array( $arr ) ? array_map( 'clearNull', $arr ) : str_replace( "\0", '', $arr );
}

/** HTMLエスケープ */
function hsc( $str ) {
    return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8' );
}

/** 改行削除（メールヘッダインジェクション対策） */
function clearRN( $str ) {
    return str_replace(array("\r\n","\r","\n"), '', $str);
}

/** 機種依存文字の変換 */
function replaceDep( $str ) {
    global $replace_map;
    return strtr( $str, $replace_map );
}

/** 配列展開用関数 */
function implodeVal( $arr ) {
    $str = '';
    if( is_array( $arr ) ) {
        foreach( $arr as $key => $val ) {
            if( is_array( $val ) ) {
                foreach( $val as $kk => $vv ) {
                    if( $kk === 0 || $vv == '' ) $kk = '';
                    $str .= $vv . $kk . ' & ';
                }
            } else {
                $str .= $val.' & ';
            }
        }
        $str = rtrim($str,' & ');
    } else {
        $str = $arr;
    }
    return $str;
}

/** validations.php 用　エラー追加関数 */
function addError( $message ) {
    global $input;
    $input->addErrorMessage( $message );
}

/** preprocess.php 用 入力値のアップデート関数 */
function post_update( $name, $value ) {
    global $input;
    $input->post_update( $name, $value );
}