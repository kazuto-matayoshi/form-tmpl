formのcss作成手順書、他
調整方法の共有をいたします。


【html編】

日付の入力のサポートをしてくれる『jquery.ui.datepicker.js』,
リアルタイムバリデーションサポートをしてくれる『jquery.validationEngine.js』が入っています。

datepickerを対応させる場合は
対応させたいinputに『class="datepicker"』と入れてください。

datepickerを対応させる場合は
対応させたいinputに『class="validate[required]"』と入れてください。
validationEngineのカスタマイズや、表示テキスト、エラー文の位置などは
こちら（ http://studio-key.com/1139.html ）を参考にしてください。

また、htmlファイル内にも直接コメントが残ってますので
確認お願いします。


-------------------------------------------------------------

【scss編】

_setting.scssを編集し、form.cssを作成します。

各変数の設定を変更することによって
自動的にform.cssが作成されます。

各設定においては
コメントを残しておりますので
そちらを確認お願いします。

また、【対応】の欄にないinput等は
form.cssでの一括変更適応外です。
確認お願いします。

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

~~ 対応 ~~

■ textarea
■ select
■ button
■ input
type="text"
type="search"
type="tel"
type="url"
type="email"
type="password"
type="checkbox"
type="radio"

~~ 未完全対応 ~~

■ input
type="datetime"
type="date"
type="month"
type="week"
type="time"
type="datetime-local"
type="number"
type="range"
type="color"
type="file"
type="image"
type="submit"
type="reset"
type="button"

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

-------------------------------------------------------------

@mixinについて。

各、細かい設定ができるように

・input_add($type)
・radio_add()
・check_add()
・textarea_add()
・select_add()

を用意しております。

settingでカバーしきれない独自のCSSを追加するときに
{}内に追加してください。

-------------------------------------------------------------

【css編】
初期で吐き出されるcssは下記のとおりです。

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

form *,
form *:before,
form *:after {
  box-sizing: border-box;
}

form input,
form select,
form textarea {
  border: 1px solid #a9a9a9;
  background: #d6d6d6;
  box-shadow: none;
}

form input.inText,
form select.inText,
form textarea.inText {
  background: #FFF;
}

form button {
  border: 1px solid #a9a9a9;
  background: #d6d6d6;
  box-shadow: none;
}

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

【js編】
-- 入力補助（背景色）について --

SCSSの$backgroundで設定した色が背景色の初期値になりますが、
もし、入力後の背景色を変更したい場合は
from.jsの『valCheckTarget』の値を変更してください。
テキスト入力後、ラジオ選択後に『.inText』のクラスが追加され背景色が白くなります。
セレクタの指定方法はcssと同じか書き方で問題ありません。


-- カレンダーについて --

何かカスタマイズを行う場合には
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	$( '.datepicker' ).datepicker({
		// 日付の有効範囲
		minDate: '0',
	});

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
とあるので『minDate: '0',』のように記入してください。

-- バリデーションについて --

何かカスタマイズを行う場合には
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	$(function(){
		$("form").validationEngine( 'attach', {
			autoPositionUpdate: true,
			promptPosition: "centerRight",
		});
	});

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
とあるので『autoPositionUpdate: true,』等のように記入してください。
