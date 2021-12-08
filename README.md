# PIGFLY
PHP を用いたファイル添付機能付き汎用メールフォームです。PHP に疎い方でも少しの設定で利用ができるように作成しています。

## Requirement
PHP 7.2.x ~  
サーバーでメール送信がサポートされている（Postfixが動作している）必要があります。

## Usage
サーバーに PIGFLY をディレクトリ毎設置します（ 例：https://hogehoge.com/PIGFLY/ ）。  
PIGFLY ディレクトリに対して、任意のHTMLからPOST送信することで動作します。  
セキュリティ上デフォルトでは PIGFLYが設置されているのと同一のドメインからの送信のみ受け付けます（configで追加可能）。

フォームで送信されたものをすべて送信します。name属性の値は日本語で設定可能です。

ファイル添付を行う場合、HTMLフォームに enctype="multipart/form-data" 属性を設定してください。

## Setting
config.php で全体設定を行えます。  

メールの書式の設定については、mail ディレクトリ内の to_admin.php（管理者へのメール）, to_user.php（ユーザへのメール） で編集を行えます。  
cc, bccに複数設定したい場合はカンマ区切りで記入してください。  
subject はメールのタイトルです。  
prefix はメールの冒頭部分です。  
suffix はメールの末尾部分です。

確認画面やエラー画面の表示については、page ディレクトリ内のファイルで編集ができます。  
（PHPに触れる必要がある場所があるため、取扱には注意してください。）  
$page->setCSS() で読み込む css ファイルの追加、$page->setJS() で読み込む js ファイルの追加ができます。

## Note
config.php の $mail_sender は可能な限り設置サーバー自身が持つメールアドレスを設定して下さい。  
Gmailなどのフリーメールや他サーバーのアドレス等でも送信が行えますが、高確率で迷惑メールとして判定されます（最悪の場合サーバーが他からブロックされてしまいます）。  

チェックボックスを利用する場合、name属性の値を配列として扱えるようにする必要があります。  
そのため、チェックボックスには name="選択肢[]" のように末尾に [] をつけてください。

## Demo
準備中

## License
"PIGFLY" is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).

## Author
* 徒浪
* E-mail: wave.ysk730@gmail.com