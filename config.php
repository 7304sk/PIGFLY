<?php
/* ------------------initial settings------------------ */
/** メールフォームの名前 */
$form_name = 'PIGFLY メールフォーム';

/** サーバのメールアドレス（メールの送信元） */
$mail_sender = 'sender@your.domain';

/** 管理者のメールアドレス（受信先） */
$admin_email = 'you@your.adress';

/** Email入力欄のname値 */
$user_email = 'Email';

/** Email確認欄のname値（確認欄を作成する場合。ない場合は空白にする。） */
$email_retype = 'Email（確認用）';

/** 必須項目にするinputのname値（$Email, $Email_retype のものは書かない） */
$mandatory = ['氏名', '件名', '内容'];

/** 送信成功時のthanksページURL */
$page_thanks = 'https://www.google.com/';

/** リファラチェック用、フォームを設置しているドメインがこのアプリと違うドメインにある場合に追加する */
$app_domain = [];

/** アップロードを許可する拡張子 */
$file_extensions = [ 'pdf','doc','docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif' ];

/** アップロードファイルのサイズ上限（KB） */
$file_max = 3000;
/* ----------------initial settings END---------------- */

/* --------------------mode switchs-------------------- */
/** 確認画面の有無 */
$mode_confirm = true;

/** メールアドレス確認欄の有無 */
$mode_email_retype = true;

/** テストモード（メンテナンス用） */
$mode_test = false;
/* ------------------mode switchs END------------------ */