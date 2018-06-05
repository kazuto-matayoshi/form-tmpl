<?php var_dump($_POST); ?>

<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <!-- ▼************ 送信内容表示部 ※編集は自己責任で ************ ▼-->
    <?php if ( $empty_flag == 1 ) : ?>
      <div align="center">
        <h4 class="errs_h4">入力にエラーがあります。<br>下記をご確認の上「前画面に戻る」ボタンより修正をお願い致します。</h4>
        <div class="errs"><?php echo $errm; ?></div>
        <p class="formBackBtn">
          <input type="button" value=" 前画面に戻る " onClick="history.back()">
        </p>
      </div>
    <?php else : ?>
      <form action="<?php echo esc_html($_SERVER['SCRIPT_NAME']); ?>" method="POST" class="mailForm">
        <ul class="submit">
          <li class="retry">
            <input type="button" class="button" value="修正する" onClick="history.back()">
          </li>
          <li class="send">
            <input type="hidden" name="mail_set" value="confirm_submit">
            <input type="hidden" name="httpReferer" value="<?php echo esc_html($_SERVER['HTTP_REFERER']);?>">
            <input class="button" type="submit" value="送信する">
          </li>
        </ul>
      </form>
      <ul class="listUl">
        <li class="text">※予約日時の確認は、必ず弊社よりご連絡申し上げます。弊社からの連絡をもって予約日が決まります。</li>
        <li class="text">※希望日時の前日までに、弊社より連絡がない場合は、お手数ではございますが、&lt;0120-000-000&gt; までご一報いただければと存じます。</li>
        <li class="text">※ご希望日時でお取り出来ない場合もございますので、あらかじめご了承ください。</li>
      </ul>
    <?php endif; ?>
  </body>
</html>
