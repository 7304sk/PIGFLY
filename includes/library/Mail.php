<?php

class Mail {
    private $from;
    private $to;
    private $val;
    private $facade;
    private $file;
    private $boundary;
    public $mail;

    function __construct( $from, $to, $arr, $facade, $file = array() ) {
        $this->boundary = md5( uniqid( rand() ) );
        $this->from = $from;
        $this->to = $to;
        $this->val = $arr;
        $this->facade = $facade;
        $this->file = $file;
        $this->mail =  (object) [
            'to'      => $this->to(),
            'header'  => $this->header(),
            'subject' => $this->subject(),
            'body'    => $this->body()
        ];
    }

    /** 送信関数のカプセル */
    public function send() {
        mail( $this->encode_mime( $this->mail->to ), $this->encode_mime( $this->mail->subject ), $this->encode_body( $this->mail->body ), $this->mail->header );
    }

    /** エンコード */
    private function encode_mime( $str ) {
        return mb_encode_mimeheader( $str, 'ISO-2022-JP-MS', 'UTF-8' );
    }

    /** エンコード */
    private function encode_body( $str ) {
        return mb_convert_encoding( $str, 'ISO-2022-JP-MS', 'UTF-8' );
    }

    /** To の設定 */
    private function to() {
        return Sanitize::trim( $this->to );
    }

    /** タイトルの設定 */
    private function subject() {
        return Sanitize::trim( $this->facade->subject );
    }

    /** 本文の設定 */
    private function body() {
        global $mode_email_retype, $email_retype;
        $str = '';
        if ( ! empty( $this->file ) ) {
            $str .= "--{$this->boundary}\n";
            $str .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
            $str .= "Content-Transfer-Encoding: 7bit\n\n";
        }
        $str .= $this->facade->prefix;
        $str .= "\n──────────────────────\n";
        foreach( $this->val as $key => $val ) {
            if( ! empty( $val ) ) {
                if( ! ( $mode_email_retype && $key === $email_retype ) ) {
                    $str .= '【 ' . $key . ' 】 ' . Sanitize::replaceDep( implodeVal( $val ) ) . "\n";
                }
            }
        }
        $str .= "──────────────────────\n";
        $str .= $this->facade->suffix;
        if ( ! empty( $this->file ) ) {
            foreach ( $this->file as $key => $val ) {
                    $name = $val[ 'name' ];
                    $data = $val[ 'data' ];
                    $str .= "\n";
                    $str .= "--{$this->boundary}\n";
                    $str .= "Content-Type: application/octet-stream; ";
                    $str .= "charset=\"ISO-2022-JP\" ";
                    $str .= "name=\"" . mb_encode_mimeheader( $name, "ISO-2022-JP-MS", "UTF-8" ) . "\"\n";
                    $str .= "Content-Transfer-Encoding: base64\n";
                    $str .= "Content-Disposition: attachment; ";
                    $str .= "filename=\"" . mb_encode_mimeheader( $name, "ISO-2022-JP-MS", "UTF-8" ) . "\"\n\n";
                    $str .= "{$data}\n";
            }
            $str .= "--{$this->boundary}--\n";
        }
        return $str;
    }

    /** メールヘッダの設定 */
    private function header() {
        global $form_name, $mail_sender;
        $str = '';
        $str .= 'From: ' . mb_encode_mimeheader( Sanitize::trim( $form_name ), 'ISO-2022-JP-MS', 'UTF-8' ) . ' <' . mb_encode_mimeheader( Sanitize::trim( $mail_sender ), 'ISO-2022-JP-MS', 'UTF-8' ) . ">\n";
        if( ! empty( $this->facade->cc ) ) $str .= "Cc: " . mb_encode_mimeheader( Sanitize::trim( $this->facade->cc ), 'ISO-2022-JP-MS', 'UTF-8' ) . "\n";
        if( ! empty( $this->facade->bcc ) ) $str .= "Bcc: " . mb_encode_mimeheader( Sanitize::trim( $this->facade->bcc ), 'ISO-2022-JP-MS', 'UTF-8' ) . "\n";
        $str .= "Reply-To: " . mb_encode_mimeheader( Sanitize::trim( $this->from ), 'ISO-2022-JP-MS', 'UTF-8' ) . "\n";
        $str .= "X-Mailer: PHP/" . phpversion() . "\n";
        $str .= "Content-Transfer-Encoding: 7bit\n";
        if ( ! empty( $this->file ) ) {
            $str .= "Content-type: multipart/mixed; boundary=\"{$this->boundary}\"";
        } else {
            $str .= "Content-Type:text/plain; charset=iso-2022-jp";
        }
        return $str;
    }
}
