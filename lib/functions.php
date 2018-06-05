<?php
// メールアドレスチェック
function checkMail( $str ) {
  $mailaddress_array = explode('@',$str);
  if ( preg_match( "/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str" ) && count( $mailaddress_array ) == 2) {
    return true;
  }
  else {
    return false;
  }
}

// 記号などのサニタイズ
function esc_html( $string ) {
  global $encode;
  return htmlspecialchars( $string, ENT_QUOTES, $encode );
}



// NULLバイト攻撃への対策 -> https://goo.gl/ZH18D2
function delete_null( $arr ) {
  if ( is_array( $arr ) ) {
    return array_map( 'delete_null', $arr );
  }
  return str_replace( "\0", '', $arr );
}

// Shift-JISの場合に誤変換文字の置換関数
function sjis_replace( $arr, $encode ) {
  foreach (  $arr as $key => $val ) {
    $key = str_replace( '＼', 'ー', $key );
    $resArray[$key] = $val;
  }
  return $resArray;
}



// ここまで解析








// 送信メールにPOSTデータをセットする関数
function postToMail($arr){
  global $hankaku,$hankaku_array;
  $resArray = '';
  foreach ( $arr as $key => $val) {
    $out = '';
    if(is_array($val)){
      foreach ( $val as $key02 => $item){
        //連結項目の処理
        if(is_array($item)){
          $out .= connect2val($item). ' ';
        }else{
          $out .= $item . ', ';
        }
      }
      $out = rtrim($out,', ');

    }else{ $out = $val; }//チェックボックス（配列）追記ここまで
    if(get_magic_quotes_gpc()) { $out = stripslashes($out); }

    // 全角→半角変換
    if($hankaku == 1){
      $out = zenkaku2hankaku($key,$out,$hankaku_array);
    }
    if($out != "confirm_submit" && $key != "httpReferer") {
            $resArray .= "【 ".esc_html( $key )." 】 ";
            if($key == 'お名前' || $key == 'お名前（カナ）'){
                $resArray .= h($out)." 様\n";
            }elseif($key == 'お問い合わせ内容') {
                $resArray .= "\n".h($out)."\n";
            }else {
                $resArray .= h($out)."\n";
            }
    }
  }
  return $resArray;
}
// 確認画面の入力内容出力用関数
function confirmOutput($arr){
  global $hankaku,$hankaku_array;
  $html = '';
  foreach ( $arr as $key => $val) {
    $out = '';
    if(is_array($val)){
      foreach ( $val as $key02 => $item){
        // 連結項目の処理
        if(is_array($item)){
          $out .= connect2val($item). ' ';
        }else{
          $out .= $item . ', ';
        }
      }
      $out = rtrim($out,', ');
    }else{ $out = $val; }// チェックボックス（配列）追記ここまで
    if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
    $out = nl2br(h($out));// ※追記 改行コードを<br>タグに変換
    $key = esc_html( $key );

    // 全角→半角変換
    if($hankaku == 1){
      $out = zenkaku2hankaku($key,$out,$hankaku_array);
    }

    $html .= "<tr><th>".$key."</th>";
    if($key == 'お名前' || $key == 'お名前（カナ）'){
      $html .= "<td>".$out.' 様';
    }else{
      $html .= "<td>".$out;
    }
    $html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" />';
    $html .= "</td></tr>\n";
  }
  return $html;
}

// 全角→半角変換
function zenkaku2hankaku($key,$out,$hankaku_array){
  global $encode;
  if(is_array($hankaku_array) && function_exists('mb_convert_kana')){
    foreach ( $hankaku_array as $hankaku_array_val){
      if($key == $hankaku_array_val){
        $out = mb_convert_kana($out,'a',$encode);
      }
    }
  }
  return $out;
}

// 配列連結の処理
function connect2val($arr){
  $out = '';
  foreach ( $arr as $key => $val){
    if($key === 0 || $val == ''){//配列が未記入（0）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
      $key = '';
    }elseif(strpos($key,"円") !== false && $val != '' && preg_match("/^[0-9]+$/",$val)){
      $val = number_format($val);//金額の場合には3桁ごとにカンマを追加
    }
    $out .= $val . $key;
  }
  return $out;
}

// 機種依存文字の変換


// 管理者宛送信メールヘッダ
function adminHeader($userMail,$post_mail,$BccMail,$to){
  $header = '';
  if($userMail == 1 && !empty($post_mail)) {
    $header="From: $post_mail\n";
    if($BccMail != '') {
      $header.="Bcc: $BccMail\n";
    }
    $header.="Reply-To: ".$post_mail."\n";
  } else {
    if($BccMail != '') {
      $header="Bcc: $BccMail\n";
    }
    $header.="Reply-To: ".$to."\n";
  }

  $header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
  return $header;
}

// 管理者宛送信メールボディ
function mailToAdmin($arr,$subject,$mailFooterDsp,$mailOwnerSignature,$encode,$confirmDsp){
  // $adminBody= $subject."からメールが届きました\n\n";
  $adminBody  = $subject."からメールが届きました\n\n";
  $adminBody .= "＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
  $adminBody .= postToMail($arr);//POSTデータを関数からセット
  $adminBody .= "\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
  // $adminBody.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
  // $adminBody.="送信者のIPアドレス：".@$_SERVER["REMOTE_ADDR"]."\n";
  // $adminBody.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
  if($confirmDsp != 1){
    $adminBody.="問い合わせのページURL：".@$_SERVER['HTTP_REFERER']."\n";
  }else{
    $adminBody.="問い合わせのページURL：".@$arr['httpReferer']."\n";
  }
  if($mailFooterDsp == 1) $adminBody.= $mailOwnerSignature;
  return mb_convert_encoding($adminBody,"ISO-2022-JP-MS",$encode);
}

// ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode){
  $reheader = "From: ";
  if(!empty($refrom_name)){
    $default_internal_encode = mb_internal_encoding();
    if($default_internal_encode != $encode){
      mb_internal_encoding($encode);
    }
    $reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
  }else{
    $reheader .= "$to\nReply-To: ".$to;
  }

  $reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
  return $reheader;
}

// ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode){
  $userBody = '';
  if(isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
  $userBody.= $remail_text;
  $userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
  $userBody.= postToMail($arr);//POSTデータを関数からセット
  $userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
  // $userBody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
  if($mailFooterDsp == 1) $userBody.= $mailSignature;
  return mb_convert_encoding($userBody,"ISO-2022-JP-MS",$encode);
}






// 必須チェック関数
function requireCheck( $require ) {
  $res['errm']       = '';
  $res['empty_flag'] = false;

  foreach ( $require as $requireVal ) {
    $existsFalg = '';
    foreach ( $_POST as $key => $val ) {
      if ( $key == $requireVal ) {
        // 連結指定の項目（配列）のための必須チェック
        if ( is_array( $val ) ) {
          $connectEmpty = 0;
          foreach ( $val as $kk => $vv ) {
            if ( is_array( $vv ) ) {
              foreach ( $vv as $kk02 => $vv02 ) {
                if ( $vv02 == '' ) {
                  ++$connectEmpty;
                }
              }
            }
          }
          if ( $connectEmpty > 0 ) {
            $res['errm'] .= "<p class=\"error_messe\">【".esc_html( $key )."】は必須項目です。</p>\n";
            $res['empty_flag'] = true;
          }
        }
        // デフォルト必須チェック
        elseif( $val == '' ) {
          $res['errm'] .= "<p class=\"error_messe\">【".esc_html( $key )."】は必須項目です。</p>\n";
          $res['empty_flag'] = true;
        }
        $existsFalg = 1;
        break;
      }
    }
    if ( $existsFalg != 1 ) {
      $res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
      $res['empty_flag'] = true;
    }
  }

  return $res;
}

// リファラチェック
function refererCheck( $Referer_check, $Referer_check_domain ) {
  if ( $Referer_check == 1 && !empty( $Referer_check_domain ) ) {
    if( strpos( $_SERVER['HTTP_REFERER'], $Referer_check_domain) === false ) {
      return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
    }
  }
}
// ----------------------------------------------------------------------
//  関数定義(END)
// ----------------------------------------------------------------------
