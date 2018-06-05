<?php
// お問い合わせ者宛のメール文をセット
if ( $remail === true ) {
  $re_email_header  = userHeader( $refrom_name, $from, $encode );
  $re_email_subject = '=?iso-2022-jp?B?'.base64_encode(
                        mb_convert_encoding(
                          $re_subject,
                          'JIS',
                          $encode
                        )
                      ).'?=';
  $re_email_body    = mailToUser(
                        $_POST,
                        $dsp_name,
                        $remail_text,
                        $mailFooterDsp,
                        $signature,
                        $encode
                      );

  // お問い合わせ者宛にメールをDone
  if ( !empty( $post_mail ) ) {
    mail( $post_mail, $re_email_subject, $re_email_body, $re_email_header );
  }
}


// 管理者宛のメール文をセット
$admin_header  = adminHeader( $userMail, $post_mail, $bcc_mail, $from );
$admin_subject = "=?iso-2022-jp?B?".base64_encode(
                   mb_convert_encoding(
                     $subject,
                     'JIS',
                     $encode
                   )
                 )."?=";
$admin_body    = mailToAdmin(
                   $_POST,
                   $subject,
                   $mailFooterDsp,
                   $signature,
                   $encode,
                   $confirm_display
                 );

// 管理者宛にメールをDone
mail( $from, $admin_subject, $admin_body, $admin_header );