<?php
  session_start();

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  // POSTされたワンタイムチケットを取得
  $ticket = isset($_POST['ticket']) ? $_POST['ticket'] : '';

  //セッション変数に保存されたワンタイムチケットを取得
  $save = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';

  // 不正遷移対策
  if ($ticket == '' || $ticket != $save){

    // 不正遷移の場合、error.phpへ遷移
    header("Location: error.php");
    session_destroy();
    // チケットをunsetする
    unset($_SESSION["ticket"]);
    exit;

  // 不正遷移ではない場合以下に進む
  } 
  else{

    /******* 書式系定数 *******/
    $csvtime = date("ym");
    $ub = "_";
    $daicomma = "，";
    /******* SESSION変数の受け取り *******/

    // 日付とIPアドレスを結合
    $skb_pre = date('Y_m_d H:i:s');
    $skb_pre = str_replace("/", "", $skb_pre);
    $skb_pre = str_replace(":", "", $skb_pre);
    $skb_ip = str_replace(".", "", getenv("REMOTE_ADDR"));

    $skb = "$skb_pre$ub$skb_ip";

    // 現在時刻
    $request_time = date('Y/m/d H:i:s');

    $form_data['interest']  = isset($_POST["interest"]) ? $_POST["interest"] : "";
    $form_data['want']      = isset($_POST["want"]) ? $_POST["want"] : "";
    $form_data['continue']  = isset($_POST["continue"]) ? $_POST["continue"] : "";
    $form_data['reference'] = isset($_POST["continue"]) ? $_POST["continue"] : "";
    $form_data['lname']		= isset($_POST["lname"]) ? $_POST["lname"] : "";
    $form_data['fname']		= isset($_POST["fname"]) ? $_POST["fname"] : "";
    $form_data['lkname']	= isset($_POST["lkname"]) ? $_POST["lkname"] : "";
    $form_data['fkname']	= isset($_POST["fkname"]) ? $_POST["fkname"] : "";
    $form_data['age']		= isset($_POST["age"]) ? $_POST["age"] : "";
    //$form_data['post_no'] = isset($_POST["post_no"]) ? $_POST["post_no"] : "";
    $form_data['pref']		= isset($_POST["pref"]) ? $_POST["pref"] : "";
    $form_data['addr01']	= isset($_POST["addr01"]) ? $_POST["addr01"] : "";
    $form_data['addr02']	= isset($_POST["addr02"]) ? $_POST["addr02"] : "";
    $form_data['tel']	    = isset($_POST["tel"]) ? $_POST["tel"] : "";
    $form_data['email']		= isset($_POST["email"]) ? $_POST["email"] : "";

    //お名前：姓
    $lastName = str_replace(",", $daicomma,$form_data['lname']);

    //お名前：名
    $firstName = str_replace(",", $daicomma,$form_data['fname']);

    //お名前(姓・名)
    $name = $lastName.'　'.$firstName;

    //フリガナ：セイ
    $lastName_kana = str_replace(",", $daicomma, $form_data['lkname']);

    //フリガナ：メイ
    $firstName_kana = str_replace(",", $daicomma, $form_data['fkname']);

    // フリガナ(セイ・メイ)
    $kana_name = $lastName_kana.'　'.$firstName_kana;

    //郵便番号;
    //$post_number = substr($form_data['post_no'], 0, 3).'-'.substr($form_data['post_no'], 3, 4);

    //住所 都道府県
    $prefecture = $form_data['pref'];

    //住所 市区町村
    $addr01 = str_replace(",", $daicomma, $form_data['addr01']);

    //住所 丁目・番地
    $addr02 = str_replace(",", $daicomma, $form_data['addr02']);

    //電話番号
    $tel = $form_data['tel'];

    //メールアドレス
    $email = $form_data['email'];

    //個人情報の同意
    $personal = '個人情報保護方針について確認し理解したので同意します';

    //関数ファイルの読込
    include_once("includes/functions.php");

    /* ----------------------------------------
    CSVにデータをはきだす
    ---------------------------------------- */
    //data.csvファイルを開く
    $fp = fopen('data/data.csv', 'a');
    //一人分のデータ$dataを文字列として連結させて、変数$lineに格納
    $line = implode(',' , $form_data);
    //data.csvにデータを書き込む　CSVは一行１データなので「\n」で改行
    fwrite($fp, $line . "\n");
    //data.csvを閉じる
    fclose($fp);

    // セッション変数を全て解除する
    $_SESSION = array();
    // セッションを破棄する
    session_destroy();
  }
?>



<!doctype html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>仮想通貨に関するアンケート | 仮想通貨ならBit Emotion</title>

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="css/style.css"/>

    <!-- favicon -->
    <link rel="shortcut icon" href="image/favicon.ico">

    <script type="text/javascript" src="js/ajaxzip3.js"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  </head>
  <body>
    <div id="container">
      <div id="midashi_h1">
          <h1>アンケートに答えちゃおぅ♪</h1>
      </div>

      <!-- コンテンツ -->
      <div id="content">
        <div class="wrapper">
          <div class="contentsinner_thx">
            <div class="inner-center" style="text-align:center;">
              <img src="image/maru_clear.png" style="width:30%; height:auto; margin-bottom:30px;">
              <p>
                アンケートにご協力頂き、ありがとうございました。♪<br />
              </p>
            </div>
            <div class="contents-text">
              <p align="center"></p>
            </div>
          </div>
        </div>

				<div class="next_button_area" style="text-align:center;">
          <input type="button" class="next_button" value="トップページへ" onclick="location.href='input_data.php'">
        </div>
      </div>
    </div>
  </body>
</html>