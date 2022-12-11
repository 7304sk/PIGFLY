<?php
/**
 * 入力項目内容を独自に加工できるファイル
 * 入力値にプレフィックスやサフィックスをつけたりできます。
 *
 * (input)
 * $name に入力項目の name 属性値、$value にその値が入力されています。
 *
 * (output)
 * post_update( 'キー', '値' ) 
 * 関数を実行することで入力内容を上書きされます。
 */


/* 例：input[type="date"] で入力されている【日付】を日本語書式に直したい場合
if ( $name == '日付' && ! empty( $value ) ) {
    $dt = strtotime( $value );
    post_update( $name, date( 'Y年n月j日', $dt ) );
}
*/
