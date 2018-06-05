<?php
  // protocol
  $protocol =  isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

  // サイトのトップページのURL
  define( '__site_top__', $protocol.$_SERVER['HTTP_HOST'].'/' );
  // 現在のページのURL
  define( '__page_url__', $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );



  /* ---------------------------
  以下スパム防止のための設定 
  ※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
  --------------------------- */

  // スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=true, しない=false)
  define( '__referer_check__', true );
  // リファラチェックを「する」場合のドメイン
  define( '__referer_domain__', $_SERVER['HTTP_HOST'] );
