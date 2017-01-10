formのcss作成手順書、他
調整方法の共有をいたします。



【html編】

日付の入力のサポートをしてくれる『jquery.ui.datepicker.js』,
リアルタイムバリデーションサポートをしてくれる『jquery.validationEngine.js』が入っています。

datepickerを対応させる場合は
対応させたいinputに『class="datepicker"』と入れてください。

datepickerを対応させる場合は
対応させたいinputに『class="validate[required]"』と入れてください。
validationEngineのカスタマイズや、表示テキスト、ポジションなどは
こちら（ http://studio-key.com/1139.html ）を参考にしてください。

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
type="week" ※SP未対応？
type="time"
type="datetime-local"
type="number"
type="range"
type="color" ※SP未対応？
type="file"
type="image"
type="submit"
type="reset"
type="button"

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

もし、それでも不明点などがあれば
声かけていただけると改修いたしますので
声掛けのほどよろしくお願いします。

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
  box-shadow: none;
}

form input.inText,
form select.inText,
form textarea.inText {
  background: #FFF;
}

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

