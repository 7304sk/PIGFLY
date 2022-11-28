<?php

class Input {
    private $val = array();
    private $error_message  = array();
    private $error = false;
    private $confirmed = false;
    private $file = array();
    private $checking = false;
    private $preprocessing = false;
    private $lang_jp = false;

    public function __construct( $arr, $mode_jp = true ) {
        $this->val = $arr;
        $this->lang_jp = $mode_jp;
    }

    /** lang_jp の getter */
    public function isJP() {
        return $this->lang_jp;
    }

    public function preprocess() {
        $this->preprocessing = true;
        $this->tokenCheck();
        if( ! $this->confirmed() ) {
            foreach( $this->val as $name => $value ) {
                require APP_PATH . 'preprocess.php';
            }
        }
        $this->preprocessing = false;
    }

    public function post_update( $name, $value ) {
        if ( $this->preprocessing ) {
            if( array_key_exists( $name, $this->val ) ) {
                $this->val[$name] = $value;
            } else {
                AppError::id( 7 );
            }
        } else {
            AppError::id( 4 );
        }
    }

    public function addErrorMessage( $str ) {
        if ( $this->checking() ) {
            $this->error_message[] = $str;
        } else {
            AppError::id( 4 );
        }
    }

    /** The capsule to execute all check functions. */
    public function check() {
        $this->checking = true;
        $this->requireCheck();
        $this->mailCheck();
        $this->fileCheck();
        $this->uniqueCheck();
        $this->checking = false;
        if( ! empty( $this->error_message ) ) $this->error = true;
    }
    
    /** checking の getter */
    public function checking() {
        return $this->checking;
    } 

    /** error の getter */
    public function error() {
        return $this->error;
    }

    /** confirmed の getter */
    public function confirmed() {
        return $this->confirmed;
    }

    /** file の getter */
    public function file() {
        return $this->file;
    } 

    /** トークンチェック */
    private function tokenCheck() {
        if( isset( $_SESSION[ 'mailform_token' ] ) && isset( $this->val[ 'mailform_token' ] ) ) {
            if( $_SESSION[ 'mailform_token' ] !== $this->val[ 'mailform_token' ] ) {
                AppError::id( 3 );
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
                            if ( $this->isJP() ) {
                                $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $key ) . ' 】</span>は必須項目です。' );
                            } else {
                                $this->addErrorMessage( '<span class="errmsg">[' . hsc( $key ) . ']</span> is required field.' );
                            }
                        }
                    } elseif( $val === '' ) {
                        if ( $this->isJP() ) {
                            $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $key ) . ' 】</span>は必須項目です。' );
                        } else {
                            $this->addErrorMessage( '<span class="errmsg">[' . hsc( $key ) . ']</span> is required field.' );
                        }
                    }
                    $exist_flag = true;
                    break;
                }
            }
            if( ! empty( $_FILES ) ) {
                foreach( $_FILES as $key => $val ) {
                    if( $key === $mandatory_key ) {
                        if( empty( $val[ 'tmp_name' ] ) ) {
                            if ( $this->isJP() ) {
                                $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $key ) . ' 】</span>は必須項目です。' );
                            } else {
                                $this->addErrorMessage( '<span class="errmsg">[' . hsc( $key ) . ']</span> is required field.' );
                            }
                        }
                        $exist_flag = true;
                        break;
                    }
                }
            }
            if( ! $exist_flag ) {
                if ( $this->isJP() ) {
                    $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $mandatory_key ) . ' 】</span>が入力されていません。' );
                } else {
                    $this->addErrorMessage( '<span class="errmsg">[' . hsc( $key ) . ']</span> is not entered.' );
                }
            }
        }
    }

    /** メール形式のチェック */
    private function mailCheck() {
        global $mode_email_retype, $user_email, $email_retype;
        if( $mode_email_retype && ( $this->val[ $user_email ] !== '' ) && ( $this->val[ $email_retype ] !== '' ) && ( $this->val[ $user_email ] !== $this->val[ $email_retype ] ) ) {
            if( $this->val[ $user_email ] !== $this->val[ $email_retype ] ) {
                if ( $this->isJP() ) {
                    $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $user_email ) . ' 】</span>と<span class="errmsg">【 ' . hsc( $email_retype ) . ' 】</span>の値が一致しません。' );
                } else {
                    $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $user_email ) . ' 】</span> and <span class="errmsg">【 ' . hsc( $email_retype ) . ' 】</span> values do not match.' );
                }
            }
        }
        if( $this->val[ $user_email ] !== '' ) {
            $reg = ( preg_match( '/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-zA-Z]+(\.[!#%&\-_0-9a-zA-Z]+)+$/', $this->val[ $user_email ] ) && count( explode( '@', $this->val[ $user_email ] ) ) === 2 ) ? true : false;
            if( ! $reg ) {
                if ( $this->isJP() ) {
                    $this->addErrorMessage( '<span class="errmsg">' . hsc( $this->val[ $user_email ] ) . '</span> は正しいメールアドレスの形式ではありません。' );
                } else {
                    $this->addErrorMessage( '<span class="errmsg">' . hsc( $this->val[ $user_email ] ) . '</span> is not the correct form of e-mail address.' );
                }
            }
        }
    }

    /** 添付ファイルのチェック */
    private function fileCheck() {
        global $file_extensions, $file_max, $mode_confirm, $mode_upload_file;
        if( ! empty( $_FILES ) ) {
            if ( ! $mode_upload_file ) {
                if ( $this->isJP() ) {
                    $this->addErrorMessage( 'このフォームでファイルのアップロードは許可されていません。' );
                } else {
                    $this->addErrorMessage( 'Uploading files is not allowed on this form.' );
                }
                return;
            }
            foreach( $_FILES as $key => $val ) {
                $fileData = array();
                /** phpiniの設定によるUPLOAD_ERRのチェック */
                if( $val[ 'error' ] != UPLOAD_ERR_OK && $val[ 'error' ] !== 4 ) {
                    if ( $val[ 'error' ] === 1 || $val[ 'error' ] === 2 ) {
                        if ( $this->isJP() ) {
                            $this->addErrorMessage( $val[ 'name' ] . 'はファイルの容量が大きすぎます。' );
                        } else {
                            $this->addErrorMessage( $val[ 'name' ] . ' is too large file.' );
                        }
                    } else if ( $val[ 'error' ] === 3 ) {
                        if ( $this->isJP() ) {
                            $this->addErrorMessage( $val[ 'name' ] . 'は一部しかアップロードされていません。' );
                        } else {
                            $this->addErrorMessage( $val[ 'name' ] . ' is only partially uploaded.' );
                        }
                    } else {
                        if ( $this->isJP() ) {
                            $this->addErrorMessage( $val[ 'name' ] . ' - 原因不明のエラーです。' );
                        } else {
                            $this->addErrorMessage( $val[ 'name' ] . ' - Unknown error.' );
                        }
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
                        if ( $this->isJP() ) {
                            $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $fileData[ 'name' ] ) . ' 】</span>は添付を許可されていません。<br>添付可能なファイルの種類（拡張子）は <span class="bold">[' . implode( ', ', $file_extensions ) . ']</span> です。' );
                        } else {
                            $this->addErrorMessage( '<span class="errmsg">[' . hsc( $fileData[ 'name' ] ) . ']</span> is not allowed to attach.<br>Attachment allowed file type (extension) is <span class="bold">[' . implode( ', ', $file_extensions ) . ']</span>.' );
                        }
                    }
                    /** アップロード容量制限 */
                    $size = filesize( $val[ 'tmp_name' ] );
                    if ( ($size / 1024) > $file_max ) {
                        if ( $this->isJP() ) {
                            $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $fileData[ 'name' ] ) . ' 】</span>はファイルの容量が大きすぎます。（上限'. $file_max . 'KB）' );
                        } else {
                            $this->addErrorMessage( '<span class="errmsg">【 ' . hsc( $fileData[ 'name' ] ) . ' 】</span> is too large file. (MAX: '. $file_max . 'KB)' );
                        }
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

    /** validations.php の実行 */
    private function uniqueCheck() {
        foreach( $this->val as $name => $value ) {
            require APP_PATH . 'validations.php';
        }
    }

    /** エラー画面の出力 */
    public function getError( $text_back = '戻る' ) {
        $html = "<ul class=\"error-arr\">\n";
        foreach ( $this->error_message as $key => $val ) {
            $html .= '<li>'. $val . "</li>\n";
        }
        $html .= "</ul><div class=\"toggle-box\">\n";
        $html .= "<input class=\"button back\" type=\"button\" value=\"" . $text_back . "\" onClick=\"history.back()\">\n";
        $html .= "</div>";
        echo $html;
    }

    /** 確認画面用のHTML出力 */
    public function getConfirm( $text_submit = '送信', $text_back = '戻る' ) {
        global $email_retype, $replaceStr, $mode_confirm, $mode_email_retype, $replace_str;
        $html = '<form action="' . APP_URL . "\" method=\"POST\">\n<dl class=\"confirm-arr\">\n";
        foreach( $this->val as $key => $val ) {
            if( ! empty( $val ) ) {
                $out = '';
                if( $mode_email_retype && $key == $email_retype ) {
                    $html .= '<input type="hidden" name="' . hsc( $key ) . '" value="' . str_replace( array( '<br />', '<br>' ), '', hsc( $val ) ) . "\" />\n";
                } else {
                    $out .= implodeVal( $val );
                    $out = nl2br( hsc( $out ) );
                    $out = replaceDep( implodeVal( $out ) );
                    $html .= '<dt>' . hsc( $key ) . '</dt><dd>' . $out;
                    $html .= '<input type="hidden" name="' . hsc( $key ) . '" value="' . str_replace( array( '<br />', '<br>' ), '', $out ) . "\" /></dd>\n";
                }
            }
        }
        if( $mode_confirm ) {
            $token = uniqid( bin2hex( md5( uniqid() ) ) );
            $_SESSION['mailform_token'] = $token;
            $html .= '<input type="hidden" name="mailform_token" value="' . $token . "\" />\n";
        }
        $html .= "</dl>\n<div class=\"toggle-box\">\n";
        $html .= "<input class=\"button back\" type=\"button\" value=\"" . $text_back . "\" onClick=\"history.back()\">\n<input class=\"button submit\" type=\"submit\" value=\"". $text_submit ."\">\n";
        $html .= "</div>\n</form>";
        echo $html;
    }

    /** val の getter */
    public function value( $key = null ) {
        if ( $key == null ) {
            return $this->val;
        } else {
            return $this->val[ $key ];
        }
    }
}