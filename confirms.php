<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php
	// /*---------------------------
	// * ★以下設定時の注意点
	// * ・変数、定数の変更をする際は自己責任で行ってください。
	// * ・変数、定数の値の変更をする際は自己責任で行ってください。
	// * ・後ろのセミコロン（;）削除しないください。
	// * ・先頭に「$」が付いた文字列は変更しないでください。
	// * ・英数字は必ず半角で記入してください。
	// * ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
	// * ・name属性の値に半角スペースは使用できません。
	// * 以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
	// /*---------------------------
?>
<?php
// PHP5.1.0以上の場合のみタイムゾーンを定義
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {
	// タイムゾーンの設定（日本以外の場合には適宜設定ください）
	date_default_timezone_set('Asia/Tokyo');
}


// --------------------------- 必須設定 必ず設定してください ---------------------------

// 現在のページのURL
$page_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

// サイトのトップページのURL

$site_top = "http://".$_SERVER['HTTP_HOST']."/";

// 管理者メールアドレス ※メールを受け取るメールアドレス
// 複数指定する場合は「,」で区切ってください (例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "testtest@xxx.co.jp";

//フォームのメールアドレス入力箇所のname属性の値（name="○○" の○○部分）
$Email = "メールアドレス";

/* ---------------------------
以下スパム防止のための設定 
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
--------------------------- */

// スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 1;

// リファラチェックを「する」場合のドメイン
// うまく動かない場合は直接ドメインを入力してください（例: xxxxxxxx.co.jp）
$Referer_check_domain = $_SERVER['HTTP_HOST'];

// --------------------------- 必須設定 ここまで ---------------------------


// --------------------------- 任意設定 以下は必要に応じて設定してください ---------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
// メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス
// 複数指定する場合は「,」で区切ってください (例 $to = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "【Propia】お問い合わせ";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）
$thanksPage = "./thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
// 入力画面の方でバリデーションをかけているため不要
$requireCheck = 0;

/* 必須入力項目 */
// 上記で1を選択した場合のみ有効
// 入力フォームで指定したname属性の値を指定してください。
// 値はシングルクォーテーションで囲み、最後をカンマで区切ってください。
// 配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$require = array(
						'件名',
						'お名前',
						'メールアドレス',
						'お問合わせ内容',
					);


// ---------------------------
//  自動返信メール設定(START)
// ---------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

// 自動返信メールの送信者欄に表示される名前 ※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "Propia（プロピア）";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "【Propia】お問い合わせありがとうございます";

// フォーム側の「名前」箇所のname属性の値 ※自動返信メールの「○○様」の表示で使用します。
// 指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

// 自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

この度はお問い合わせいただき、
誠にありがとうございます。
いただいた内容を確認のうえ
担当者より折り返しご連絡させていただきますので、
今しばらくお待ちください。

お問い合わせいただいた内容は以下の通りです。

TEXT;


// 自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 0;

// 上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

署名を入れる場所

FOOTER;

$mailOwnerSignature =  <<< FOOTER

署名を入れる場所

FOOTER;

// ---------------------------
//  自動返信メール設定(END)
// ---------------------------

// メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
// ※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

// 全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 0;

// 上記で1を選択した場合のみ有効
// 全角英数字→半角変換を行う項目のname属性の値を指定してください。
// 値はシングルクォーテーションで囲み、最後をカンマで区切ってください。
// 配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array(
									'電話番号',
								);


// --------------------------- 任意設定ここまで ---------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


// ---------------------------
//  関数実行、変数初期化
// ---------------------------
//このファイルの文字コード定義（変更不可）
$encode = "UTF-8";

// NULLバイト除去 //
if(isset($_GET)) $_GET = sanitize($_GET);

// NULLバイト除去 //
if(isset($_POST)) $_POST = sanitize($_POST);

// NULLバイト除去 //
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);

// Shift-JISの場合に誤変換文字の置換実行
if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);

// リファラチェック実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);

// 変数初期化
$sendmail   = 0;
$empty_flag = 0;
$post_mail  = '';
$errm       = '';
$header     = '';

if($requireCheck == 1) {
	// 必須チェック実行し返り値を受け取る
	$requireResArray = requireCheck($require);
	$errm            = $requireResArray['errm'];
	$empty_flag      = $requireResArray['empty_flag'];
}

// メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}

if ( ( $confirmDsp == 0 || $sendmail == 1 ) && $empty_flag != 1 ) {
	// 差出人に届くメールをセット
	if( $remail == 1 ) {
		$userBody   = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader   = userHeader($refrom_name,$to,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	// 管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailOwnerSignature,$encode,$confirmDsp);
	$header    = adminHeader($userMail,$post_mail,$BccMail,$to);
	$subject   = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";

	mail($to,$subject,$adminBody,$header);

	if( $remail == 1 && !empty($post_mail) ) mail($post_mail,$re_subject,$userBody,$reheader);
} else if ( $confirmDsp == 1 ) {
/* ▼▼▼送信確認画面のレイアウト※編集可 オリジナルのデザインも適用可能▼▼▼ */
?>
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
			<form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="POST" class="mailForm">
				<table class="comTable">
					<tr class="tr">
						<th class="th"><span class="text">ご氏名</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['name']; ?><input type="hidden" name="お名前" value="<?php echo $_POST['name']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">フリガナ</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['phonetic']; ?><input type="hidden" name="フリガナ" value="<?php echo $_POST['phonetic']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">電話番号</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['tel']; ?><input type="hidden" name="電話番号" value="<?php echo $_POST['tel']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">性別</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['sex']; ?><input type="hidden" name="性別" value="<?php echo $_POST['sex']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">年代</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['old']; ?><input type="hidden" name="年代" value="<?php echo $_POST['old']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">メールアドレス</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['mail']; ?><input type="hidden" name="メールアドレス" value="<?php echo $_POST['mail']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">ご希望サロン</span><span class="must">必須</span></th>
						<td class="td"><?php echo $_POST['hope']; ?><input type="hidden" name="ご希望サロン" value="<?php echo $_POST['hope']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">ご希望日時<br class="pc">
							（第一希望）</span><span class="must">必須</span></th>
						<td class="td tdStyle01"><?php echo $_POST['time_1']; ?> <?php echo $_POST['time_1_select']; ?><input type="hidden" name="ご希望日時 （第一希望）" value="<?php echo $_POST['time_1'].' '.$_POST['time_1_select']; ?>" /></td>
					</tr>
					<tr class="tr">
						<th class="th"><span class="text">ご希望日時<br class="pc">
							（第二希望）</span><span class="must">必須</span></th>
						<td class="td tdStyle01"><?php echo $_POST['time_2']; ?> <?php echo $_POST['time_2_select']; ?><input type="hidden" name="ご希望日時 （第二希望）" value="<?php echo $_POST['time_2'].' '.$_POST['time_2_select']; ?>" /></td>
					</tr>
					<?php if ($_POST['other']) : ?>
					<tr class="tr">
						<th class="th"><span class="text">その他</span></th>
						<td class="td"><?php echo $_POST['other']; ?><input type="hidden" name="その他" value="<?php echo $_POST['other']; ?>" /></td>
					</tr>
					<?php endif; ?>
					<tr class="tr">
						<th class="th"><span class="text">個人情報について</span><span class="must">必須</span></th>
						<td class="td">同意する</td>
					</tr>
				</table>
				<ul class="submit">
					<li class="retry">
						<input type="button" class="button" value="修正する" onClick="history.back()">
					</li>
					<li class="send">
						<input type="hidden" name="mail_set" value="confirm_submit">
						<input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']);?>">
						<input class="button" type="submit" value="送信する">
					</li>
				</ul>
			</form>
			<?php
				//入力内容を表示
				// echo confirmOutput($_POST);
			?>
			<ul class="listUl">
				<li class="text">※予約日時の確認は、必ず弊社よりご連絡申し上げます。弊社からの連絡をもって予約日が決まります。</li>
				<li class="text">※希望日時の前日までに、弊社より連絡がない場合は、お手数ではございますが、&lt;0120-300-969&gt; までご一報いただければと存じます。</li>
				<li class="text">※ご希望日時でお取り出来ない場合もございますので、あらかじめご了承ください。</li>
			</ul>
		<?php endif; ?>
		<!-- ▲ *********** 送信内容確認部 ※編集は自己責任で ************ ▲-->
		<script>
		if(((navigator.userAgent.indexOf('iPhone') > 0) || (navigator.userAgent.indexOf('Android') > 0) && (navigator.userAgent.indexOf('Mobile') > 0) && (navigator.userAgent.indexOf('SC-01C') == -1))){
		document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">');
		}
		</script>
	</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト ※オリジナルのデザインも適用可能▲▲▲ */
}

if ( ( $jumpPage == 0 && $sendmail == 1 ) || ( $jumpPage == 0 && ( $confirmDsp == 0 && $sendmail == 0 ) ) ) {

/* ▼▼▼送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼ */
?>
<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<div align="center">
			<?php if ( $empty_flag == 1 ) : ?>
				<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
				<div style="color:red"><?php echo $errm; ?></div>
				<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
			<?php else : ?>
				送信ありがとうございました。<br />
				送信は正常に完了しました。<br /><br />
				<a href="<?php echo $site_top ;?>">トップページへ戻る&raquo;</a>
			<?php endif; ?>
		</div>
	</body>
</html>
<?php 
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲ */
}

// 確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if ( ( $jumpPage == 1 && $sendmail == 1 ) || $confirmDsp == 0 ) {
	if ( $empty_flag == 1 ) { ?>
<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<div align="center">
			<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
			<div style="color:red"><?php echo $errm; ?></div>
				<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
			</div>
		</div>
	</body>
</html>
<?php 
	} else { header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

// ----------------------------------------------------------------------
//  関数定義(START)
// ----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
// Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}

// 送信メールにPOSTデータをセットする関数
function postToMail($arr){
	global $hankaku,$hankaku_array;
	$resArray = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){
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
						$resArray .= "【 ".h($key)." 】 ";
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
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){
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
		$key = h($key);

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
		foreach($hankaku_array as $hankaku_array_val){
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
	foreach($arr as $key => $val){
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
	$adminBody= $subject."からメールが届きました\n\n";
	$adminBody .="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$adminBody.= postToMail($arr);//POSTデータを関数からセット
	$adminBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
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
function requireCheck($require){
	$res['errm'] = '';
	$res['empty_flag'] = 0;
	foreach($require as $requireVal){
		$existsFalg = '';
		foreach($_POST as $key => $val) {
			if($key == $requireVal) {
				// 連結指定の項目（配列）のための必須チェック
				if(is_array($val)){
					$connectEmpty = 0;
					foreach($val as $kk => $vv){
						if(is_array($vv)){
							foreach($vv as $kk02 => $vv02){
								if($vv02 == ''){
									$connectEmpty++;
								}
							}
						}
					}
					if($connectEmpty > 0){
						$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
						$res['empty_flag'] = 1;
					}
				}
				// デフォルト必須チェック
				elseif($val == ''){
					$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
					$res['empty_flag'] = 1;
				}
				$existsFalg = 1;
				break;
			}
		}
		if($existsFalg != 1){
			$res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
			$res['empty_flag'] = 1;
		}
	}

	return $res;
}
// リファラチェック
function refererCheck($Referer_check,$Referer_check_domain){
	if($Referer_check == 1 && !empty($Referer_check_domain)){
		if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
			return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
// ----------------------------------------------------------------------
//  関数定義(END)
// ----------------------------------------------------------------------
?>