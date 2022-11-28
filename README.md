# PIGFLY
PHP を用いたファイル添付機能付き汎用メールフォームです。PHP に疎い方でも少しの設定で利用ができるように作成しています。

## Requirement
動作確認済み：PHP 5.6 ~

## できること
* Cc,Bcc の設定をはじめとした自由な書式設定
* 確認画面
* 送信テスト
* 日本語の設定によるメールフォーム送信
* 日本語モード・英語モードの切り替え
* ファイルの添付
* 送信内容を自動的に CSV ファイルへ集積

## Usage
サーバーに PIGFLY をディレクトリごと設置します（ 例：https://hogehoge.com/PIGFLY/, ディレクトリ名は任意 ）。  
PIGFLY ディレクトリに対して、任意の HTML から POST 送信することで動作します。  
セキュリティ上デフォルトでは PIGFLY が設置されているのと同一のドメインからの送信のみ受け付けます（config で追加可能）。  
フォームで送信されたものをすべて送信します。name 属性の値は日本語で設定可能です。  
ファイル添付を行う場合、HTML フォームに enctype="multipart/form-data" 属性を設定してください。  
入力内容に独自に制限を設けたい場合、validations.php を利用できます（処理は php で記述する必要があります。） 
入力内容の値をフォーム側で独自に加工する必要がある場合（input\[type="date"]で入力した値の書式を変更したい等）、preprocess.php を利用することで値を上書きすることができます。

## Setting
config.php で全体設定を行えます。  

メールの書式の設定については、mail ディレクトリ内の to_admin.php（管理者へのメール）, to_user.php（ユーザへのメール） で編集を行えます。  
cc, bccに複数設定したい場合はカンマ区切りで記入してください。  
subject はメールのタイトルです。  
prefix はメールの冒頭部分です。  
suffix はメールの末尾部分です。

確認画面やエラー画面の表示については、view ディレクトリ内のファイルで編集ができます。  
（PHPに触れる必要がある場所があるため、取扱には注意してください。）  
$page->setFavicon() でファビコンを設定できます（必要かは知りませんが...）  
$page->addCSS() で読み込む css ファイルの追加、$page->addJS() で読み込む js ファイルの追加ができます。

## Note
config.php の $mail_sender は可能な限り設置サーバー自身が持つメールアドレスを設定して下さい。  
Gmailなどのフリーメールや他サーバーのアドレス等でも送信が行えますが、高確率で迷惑メールとして判定されます（最悪の場合サーバーが他からブロックされてしまいます）。  
特に理由がなければデフォルトで設定される no-reply アドレスを利用することをオススメします（このアドレスが実在する必要はありません）。

チェックボックスを利用する場合、name属性の値を配列として扱えるようにする必要があります。  
そのため、チェックボックスには name="選択肢[]" のように末尾に [] をつけてください。

ログ出力をする場合、CSVファイルの設置場所に注意してください。  
web公開領域に設置する場合、必要な設定をしないとブラウザからアクセスするだけで誰でもダウンロード可能になってしまっている場合があります。  
Apache や Nginx といったミドルウェアでアクセス不可とする設定を必ずしてください。  
（よくわからない場合はデフォルトの設定である PIGFLY ディレクトリ内の log ディレクトリ以下への出力のままにしてください。）

## Demo
準備中

## License
"PIGFLY" is under [MIT license](https://github.com/7304sk/PIGFLY/blob/main/LICENSE).

## Author
* Shoalwave
* Website: [shoalwave.net](https://shoalwave.net)
* E-mail: shoalwave.dev@gmail.com
