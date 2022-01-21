<?php
/**
 * 入力項目内容のチェックを独自に設定できるファイル
 * 
 * (input)
 * $name に入力項目の name 属性値、$value にその値が入力されています。
 * 
 * (output)
 * add_error( 'エラーメッセージ' ) 関数を実行することで、入力エラーを発生させます。
 */

/* 例：【内容】を500文字以内に制限する場合
if ( $name == '内容' ) {
    $limit = 500;
    if ( mb_strlen( $value ) > $limit ) {
        $message = '【' . $name . '】は文字数制限（' . $limit . '字）を超過しています（' . mb_strlen( $value ) . '字）。';
        addError( $message );
    }
}
*/