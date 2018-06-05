<?php
  // PHP5.1.0以上の場合のみタイムゾーンを定義
  if ( version_compare( PHP_VERSION, '5.1.0', '>=' ) ) {
    // タイムゾーンの設定（日本以外の場合には適宜設定ください）
    date_default_timezone_set('Asia/Tokyo');
  }

$start_time=microtime(true);



// エラー表示用
ini_set("display_errors", On);
error_reporting(E_ALL);
// エラー表示用

require_once dirname( __FILE__ ).'/settings.php';
require_once dirname( __FILE__ ).'/lib/defines.php';
require_once dirname( __FILE__ ).'/lib/functions.php';





// ---------------------------
//  関数実行、変数初期化
// ---------------------------
//このファイルの文字コード定義（変更不可）
$encode = 'UTF-8';


// NULLバイト攻撃対策
$_GET    = isset( $_GET )    ? delete_null( $_GET )    : $_GET;
$_POST   = isset( $_POST )   ? delete_null( $_POST )   : $_POST;
$_COOKIE = isset( $_COOKIE ) ? delete_null( $_COOKIE ) : $_COOKIE;

// Shift-JISの場合に誤変換文字の置換実行
$_POST = $encode === 'SJIS' ? sjis_replace( $_POST, $encode ) : $_POST;

// リファラチェック実行
$funcRefererCheck = refererCheck( __referer_check__, __referer_domain__ );

// 変数初期化
$send_mail  = false;
$empty_flag = false;
$post_mail  = '';
$errm       = '';
$header     = '';

if ( $require_check === true && isset( $require_arr ) ) {
  // 必須チェック実行し返り値を受け取る
  $require_res_array = requireCheck( $require_arr );
  $errm              = $require_res_array['errm'];
  $empty_flag        = $require_res_array['empty_flag'];
}


// メールアドレスチェック
if ( empty( $errm ) ) {
  foreach( $_POST as $key => $val ) {
    // dirname( __FILE__ ).'/lib/view_confirm.php'内の'hidden'属性で渡される
    if ( $val === 'confirm_submit' ) {
      // $val === 'confirm_submit'の時のみだけなので三項演算子が使えない
      $send_mail = true;
    }
    if ( $key === $to ) {
      // $val === $toの時のみだけなので三項演算子が使えない
      $post_mail = esc_html( $val );
    }

    if ( $key === $to && $mail_check === true && !empty( $val ) ) {
      if ( !checkMail( $val ) ) {
        $errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
        $empty_flag = true;
      }
    }
  }
}

// 確認画面への遷移分岐
if ( ( $confirm_display === false || $send_mail === true ) && $empty_flag !== true ) {
  require_once dirname( __FILE__ ).'/lib/send_mail.php';
}
else if ( $confirm_display === true ) {
  require_once dirname( __FILE__ ).'/lib/view_confirm.php';
}


/**
 * 完了画面
 */


// 確認、完了画面がいらない場合。
if (
  $jump_page === false
  && $confirm_display === false
  && $send_mail === true
) {
  header( 'Location: '.__site_top__ );
}

// 確認画面は必要だが、完了画面に特別指定がない場合
else if (
  $jump_page === false
  && $send_mail === true
) {
  echo '/lib/thanks.php';
  // require_once dirname( __FILE__ ).'/lib/thanks.php';
}

// 確認画面は要らないが、指定のページに移動する設定の場合。
else if (
  $jump_page === true
  && $send_mail === true
) {
  header( 'Location: '.$thanks_page );
}


$end_time=microtime(true);
// echo "終了時間： ".date('Y-m-d H:i:s',(int)$end_time)."<br>";
$syori_zikan=$end_time - $start_time;
echo "<br>処理時間：".sprintf('%0.5f',$syori_zikan)."秒<br>";
exit();