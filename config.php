<?php
/************************************

    PIGFLY
    - Version : 1.5.0

    Copyright 2021 shoalwave
    https://github.com/7304sk/PIGFLY/blob/main/LICENSE

************************************/

/* >>>>>>>>>> Mode switches >>>>>>>>>> */
/** 確認画面の有無 */
$mode_confirm = true;

/** メールアドレス確認欄の有無 */
$mode_email_retype = true;

/** ファイルアップロードの許可 */
$mode_upload_file = false;

/** ログファイルの出力 */
$mode_log = false;

/** 日本語モード(オフにするとエラーメッセージなどの出力が英語になる) */
$mode_jp = true;

/** テストモード（メンテナンス用） */
$mode_test = false;
/* <<<<<<<<<< Mode switches <<<<<<<<<< */

/* >>>>>>>>>> Unique variables >>>>>>>>>> */
/** メールフォームの名前 */
$form_name = 'PIGFLY メールフォーム';

/** 管理者のメールアドレス（受信先） */
$admin_email = 'you@your.adress';

/**
 * サーバのメールアドレス（メールの送信元）
 * 管理者の受信用の他に、管理者宛・利用者の内容確認の両方のメールの送信元となるアドレスが必要。
 * 空欄の場合、 no-reply@{あなたのドメイン} というアドレスが送信元となる。これで問題がなければこのまま。
 */
$mail_sender = '';

/** Email入力欄のname値 */
$user_email = 'Email';

/** Email確認欄のname値（確認欄を作成する場合。ない場合は空白にする。） */
$email_retype = 'Email（確認用）';

/** 必須項目にするinputのname値（$Email, $Email_retype のものは書かない） */
$mandatory = ['氏名', '件名', '内容'];

/** 送信成功時のthanksページURL（空白の場合ドメイントップにリダイレクトする） */
$page_thanks = '';

/** リファラチェック用、フォームを設置しているドメインがこのアプリと違うドメインにある場合に追加する */
$app_domain = [];

/** 出力するログファイル */
$log_output_file = './log/log.csv';

/** ログファイルに出力するinput項目 */
$log_output_items = ['Email', '氏名', '件名', '内容'];

/** アップロードを許可する拡張子 */
$file_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif'];

/** アップロードファイルのサイズ上限（KB） */
$file_max = 3000;
/* <<<<<<<<<< Unique variables <<<<<<<<<< */