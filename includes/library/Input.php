<?php

class Input {
    public $val;
    private $errmsg  = '';
    public $err = false;
    public $confirmed = false;
    public $file = array();

    public function __construct( $arr ) {
        $this->val = $arr;
    }

    /** チェック関数のカプセル */
    public function check() {
        $this->tokenCheck();
        $this->requireCheck();
        $this->mailCheck();
        $this->fileCheck();
    }

    /** トークンチェック */
    private function tokenCheck() {
        if( isset( $_SESSION[ 'mailform_token' ] ) && isset( $this->val[ 'mailform_token' ] ) ) {
            if( $_SESSION[ 'mailform_token' ] !== $this->val[ 'mailform_token' ] ) {
                AppError::exit( 2 );
            } else {
                $this->confirmed = true;
                unset( $_SESSION[ 'mailform_token' ] );
                unset( $this->val[ 'mailform_token' ] );
            }
        }
    }

    /** 入力必須項目のチェック */
    private function requireCheck() {
        global $mandatory;
        foreach( $mandatory as $mandatory_key ) {
            $exist_flag = False;
            foreach( $this->val as $key => $val ) {
                if( $key === $mandatory_key ) {
                    if( is_array( $val ) ) {
                        if( implodeVal( $val ) == '' ) {
                            $this->errmsg .= '<p><span class="errmsg">【 ' . Sanitize::hsc( $key ) . " 】</span>は必須項目です。</p>\n";
                            $this->err = true;
                        }
                    } elseif( $val === '' ) {
                        $this->errmsg .= '<p><span class="errmsg">【 ' . Sanitize::hsc( $key ) . " 】</span>は必須項目です。</p>\n";
                        $this->err = true;
                    }
                    $exist_flag = true;
                    break;
                }
            }
            if( ! empty( $_FILES ) ) {
                foreach( $_FILES as $key => $val ) {
                    if( $key === $mandatory_key ) {
                        if( empty( $val[ 'tmp_name' ] ) ) {
                            $this->errmsg .= '<p><span class="errmsg">【 ' . Sanitize::hsc( $key ) . " 】</span>は必須項目です。</p>\n";
                            $this->err = true;
                        }
                        $exist_flag = true;
                        break;
                    }
                }
            }
            if( ! $exist_flag ) {
                $this->errmsg .= '<p><span class="errmsg">【 ' . Sanitize::hsc( $mandatory_key ) . " 】</span>が選択されていません。</p>\n";
                $this->err = true;
            }
        }
    }

    /** メール形式のチェック */
    private function mailCheck() {
        global $mode_email_retype, $user_email, $email_retype;
        if( $mode_email_retype && ( $this->val[ $user_email ] !== '' ) && ( $this->val[ $email_retype ] !== '' ) && ( $this->val[ $user_email ] !== $this->val[ $email_retype ] ) ) {
            if( $this->val[ $user_email ] !== $this->val[ $email_retype ] ) {
                $this->errmsg .= '<p><span class="errmsg">【' . $user_email . '】</span>と<span class="errmsg">【 ' . $email_retype . " 】</span>の値が一致しません。</p>\n";
                $this->err = true;
                return;
            }
        }
        if( $this->val[ $user_email ] !== '' ) {
            $reg = ( preg_match( '/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-zA-Z]+(\.[!#%&\-_0-9a-zA-Z]+)+$/', $this->val[ $user_email ] ) && count( explode( '@', $this->val[ $user_email ] ) ) === 2 ) ? true : false;
            if( ! $reg ) {
                $this->errmsg .= '<p><span class="errmsg">' . Sanitize::hsc( $this->val[ $user_email ] ) . " </span>は正しいメールアドレスの形式ではありません。</p>\n";
                $this->err = true;
            }
        }
    }

    /** 添付ファイルのチェック */
    private function fileCheck() {
        global $file_extensions, $file_max, $mode_confirm;
        if( ! empty( $_FILES ) ) {
            foreach( $_FILES as $key => $val ) {
                $fileData = array();
                /** phpiniの設定によるUPLOAD_ERRのチェック */
                if( $val[ 'error' ] != UPLOAD_ERR_OK && $val[ 'error' ] !== 4 ) {
                    if ( $val[ 'error' ] === 1 ) {
                        $this->errmsg .= "ファイルの容量が大きすぎます。\n";
                        $this->err = true;
                    } else {
                        $this->errmsg .= "原因不明のエラーです。\n";
                        $this->err = true;
                    }
                }
                /** config.php によるチェック */
                if( ! empty( $val[ 'tmp_name' ] ) ) {
                    $fileData[ 'tmp' ] = $val[ 'tmp_name' ];
                    $fileData[ 'name' ] = $val[ 'name' ];
                    $fileData[ 'size' ] = $val[ 'size' ];
                    $fileData[ 'extension' ] = explode( '.', $fileData[ 'name' ] )[ count( explode( '.', $fileData[ 'name' ] ) ) - 1];

                    /** 拡張子制限 */
                    $ext_allow = array();
                    foreach ( $file_extensions as $ext ) {
                        $ext_allow[] = strtolower( $ext );
                        $ext_allow[] = strtoupper( $ext );
                    }
                    if ( ! @in_array( $fileData[ 'extension' ], $ext_allow ) ) {
                        $this->errmsg .= "<p><span class=\"errmsg\">【 " . $fileData[ 'name' ] . " 】</span>は添付を許可されていません。<br>添付可能なファイルの種類（拡張子）は <span class=\"bpld\">[" . implode( ', ', $file_extensions ) . "] </span>です。</p>\n";
                        $this->err = true;
                    }
                    /** アップロード容量制限 */
                    $size = filesize( $val[ 'tmp_name' ] );
                    if ( ($size / 1024) > $file_max ) {
                        $this->errmsg .= "<p><span class=\"errmsg\">【 " . $fileData[ 'name' ] . " 】</span>はファイルの容量が大きすぎます。（上限" . $file_max . "KB）</p>\n";
                    }

                    $fp = fopen( $fileData[ 'tmp' ], 'r' );
                    $contents = fread( $fp, filesize( $fileData[ 'tmp' ] ) );
                    fclose($fp);
                    $this->file[$key] = [
                        'name'      => $fileData[ 'name' ],
                        'tmp'       => $fileData[ 'tmp' ],
                        'extension' => $fileData[ 'extension' ],
                        'data'      => chunk_split( base64_encode( $contents ) )
                    ];

                    $this->val[ $key ] = $fileData[ 'name' ];
                }
            }
        }
    }

    /** エラー画面の出力 */
    public function error() {
        echo $this->errmsg;
    }

    /** 確認画面用のHTML出力 */
    public function confirm( $text_submit = '送信', $text_back = '戻る' ) {
        global $email_retype, $replaceStr, $mode_confirm, $mode_email_retype, $replace_str;
        $html = '<form action="' . APP_URL . "\" method=\"POST\">\n<dl class=\"confirm-arr\">\n";
        foreach( $this->val as $key => $val ) {
            if( ! empty( $val ) ) {
                $out = '';
                if( $mode_email_retype && $key == $email_retype ) {
                    $html .= '<input type="hidden" name="' . Sanitize::hsc( $key ) . '" value="' . str_replace( array( '<br />', '<br>' ), '', Sanitize::hsc( $val ) ) . "\" />\n";
                } else {
                    $out .= implodeVal( $val );
                    $out = nl2br( Sanitize::hsc( $out ) );
                    $out = str_replace($replace_str['before'], $replace_str['after'], $out);
                    $html .= '<dt>' . Sanitize::hsc( $key ) . '</dt><dd>' . $out;
                    $html .= '<input type="hidden" name="' . Sanitize::hsc( $key ) . '" value="' . str_replace( array( '<br />', '<br>' ), '', $out ) . "\" /></dd>\n";
                }
            }
        }
        if( $mode_confirm ) {
            $token = uniqid( bin2hex( random_bytes( 1 ) ) );
            $_SESSION['mailform_token'] = $token;
            $html .= '<input type="hidden" name="mailform_token" value="' . $token . "\" />\n";
        }
        $html .= "</dl>\n<div class=\"box-center\">\n";
        $html .= "<input class=\"button back\" type=\"button\" value=\"" . $text_back . "\" onClick=\"history.back()\">\n<input class=\"button submit\" type=\"submit\" value=\"". $text_submit ."\">\n";
        $html .= "</div>\n</form>";
        echo $html;
    }

}