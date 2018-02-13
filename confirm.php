<?php
  session_start();

  //関数定義ファイル読込
  include_once("includes/functions.php");

  //POSTされたワンタイムチケットを取得
  $ticket = isset($_POST['ticket']) ? $_POST['ticket'] : '';

  // セッション変数に保存されたワンタイムチケットを取得
  $save = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';


  $form_data['interest']  = isset($_POST["interest"]) ? $_POST["interest"] : "";
  $form_data['want']      = isset($_POST["want"]) ? $_POST["want"] : "";
  $form_data['continue']  = isset($_POST["continue"]) ? $_POST["continue"] : "";
	$form_data['reference'] = isset($_POST["reference"]) ? $_POST["reference"] : "";
  $form_data['lname']	  = isset($_POST["lname"]) ? $_POST["lname"] : "";
  $form_data['fname']	  = isset($_POST["fname"]) ? $_POST["fname"] : "";
  $form_data['lkname']	  = isset($_POST["lkname"]) ? $_POST["lkname"] : "";
  $form_data['fkname']	  = isset($_POST["fkname"]) ? $_POST["fkname"] : "";
  $form_data['age']		  = isset($_POST["age"]) ? $_POST["age"] : "";
  //$form_data['post_no'] = isset($_POST["post_no"]) ? $_POST["post_no"] : "";
  $form_data['pref']	  = isset($_POST["pref"]) ? $_POST["pref"] : "";
  $form_data['addr01']    = isset($_POST["addr01"]) ? $_POST["addr01"] : "";
  $form_data['addr02']	  = isset($_POST["addr02"]) ? $_POST["addr02"] : "";
  $form_data['tel']		  = isset($_POST["tel"]) ? $_POST["tel"] : "";
  $form_data['email']     = isset($_POST["email"]) ? $_POST["email"] : "";
  $form_data['agree']	  = isset($_POST["agree"]) ? $_POST["agree"] : "";

  //年齢リスト
  $age_list = array(
    "19" => "～20歳未満",
    "20" => "20代",
    "30" => "30代",
    "40" => "40代",
    "50" => "50代",
    "60" => "60代",
    "70" => "70～74歳",
    "75" => "75歳以上"
  );

  //都道府県リスト
  $pref_list = array(
    'hokkaido'  => '北海道',
    'aomori'    => '青森県',
    'iwate'     => '岩手県',
    'miyagi'    => '宮城県',
    'akita'     => '秋田県',
    'yamagata'  => '山形県',
    'fukushima' => '福島県',
    'ibaraki'   => '茨城県',
    'tochigi'   => '栃木県',
    'gunma'     => '群馬県',
    'saitama'   => '埼玉県',
    'chiba'     => '千葉県',
    'tokyo'     => '東京都',
    'kanagawa'  => '神奈川県',
    'niigata'   => '新潟県',
    'toyama'    => '富山県',
    'ishikawa'  => '石川県',
    'fukui'     => '福井県',
    'yamanashi' => '山梨県',
    'nagano'    => '長野県',
    'gifu'      => '岐阜県',
    'shizuoka'  => '静岡県',
    'aichi'     => '愛知県',
    'mie'       => '三重県',
    'shiga'     => '滋賀県',
    'kyoto'     => '京都府',
    'osaka'     => '大阪府',
    'hyogo'     => '兵庫県',
    'nara'      => '奈良県',
    'wakayama'  => '和歌山県',
    'tottori'   => '鳥取県',
    'shimane'   => '島根県',
    'okayama'   => '岡山県',
    'hiroshima' => '広島県',
    'yamaguchi' => '山口県',
    'tokushima' => '徳島県',
    'kagawa'    => '香川県',
    'ehime'     => '愛媛県',
    'kochi'     => '高知県',
    'fukuoka'   => '福岡県',
    'saga'      => '佐賀県',
    'nagasaki'  => '長崎県',
    'kumamoto'  => '熊本県',
    'oita'      => '大分県',
    'miyazaki'  => '宮崎県',
    'kagoshima' => '鹿児島県',
    'okinawa'   => '沖縄県'
  );

  // 不正遷移対策
  if ($ticket == '' || $ticket != $save){

    // 不正遷移の場合、error.phpへ遷移
    header("Location: error.php");
    session_destroy();
    exit;

  }

  //不正遷移ではない場合以下に進む
  else{

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
    <style>
			.next_button{
				border-radius: 50px;
				width: 260px;
				background: #910611;
				border-radius: 50px;
				padding: 20px;
				color: #ffffff;
				font-weight: bold;
				font-size: 120%;
				border: 0;
				float: right;
				margin-top: 20px;
				position: relative;
				right: -140px;
				margin-bottom:60px;
			}
			.prev_button{
				width: 260px;
				padding: 20px;
				border: 1px solid #D8D8D8;
				border-radius: 50px;
				background: #FFF none repeat scroll 0% 0%;
				color: #a6a6a6;
				text-decoration: none;
				font-size: 120%;
				font-weight: bold;
				float: right;
				margin-top: 20px;
				margin-right: 20px;
				margin-bottom:60px;
			}
		</style>
  </head>
  <body>
    <div id="container">

      <div id="midashi_h1">
        <h1>アンケートに答えてね♪</h1>
      </div>

      <!-- コンテンツ -->
      <div id="content">
        <p>入力内容をご確認ください。</p>
        <table class="check_area">
            <tr>
              <th>仮想通貨に興味を持ったきっかけを教えてください。</th>
              <td><?php echo $form_data['interest']; ?></td>
            </tr>
            <tr>
              <th>一番欲しい仮想通貨は何ですか。</th>
              <td><?php echo $form_data['want']; ?></td>
            </tr>
            <tr>
              <th>先日仮想通貨が大暴落しましたが、まだ仮想通貨に興味はありますか。</th>
              <td><?php echo $form_data['continue']; ?></td>
            </tr>
            <tr>
              <th>（今後の参考に）何かあれば一言お願いいたします。</th>
              <td><?php echo $form_data["reference"]; ?></td>
            </tr>
            <tr>
              <th>姓：</th>
              <td><?php echo $form_data['lname']; ?></td>
            </tr>
            <tr>
              <th>名：</th>
              <td><?php echo $form_data['fname']; ?></td>
            </tr>
            <tr>
              <th>フリガナ(姓)：</th>
              <td><?php echo $form_data['lkname']; ?></td>
            </tr>
            <tr>
              <th>フリガナ(名)：</th>
              <td><?php echo $form_data['fkname']; ?></td>
            </tr>
            <tr>
              <th>年代：</th>
              <td><?php echo $form_data['age']; ?></td>
            </tr>
            <?php /*
            <tr>
              <th>郵便番号</th>
              <td><?php echo substr($form_data['post_no'], 0, 3).'-'.substr($form_data['post_no'], 3, strlen($form_data['post_no'])); ?></td>
            </tr>
            */ ?>
            <tr>
              <th>都道府県</th>
              <td><?php echo $form_data['pref']	 ?></td>
            </tr>
            <tr>
              <th>市区町村</th>
              <td><?php echo $form_data["addr01"]; ?></td>
            </tr>
            <tr>
              <th>番地以降</th>
              <td><?php echo $form_data["addr02"]; ?></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td><?php echo $form_data['tel'] ?></td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td><?php echo $form_data["email"]; ?></td>
            </tr>
            <tr>
                <th>「個人情報保護方針」<br />「勧誘方針」の同意</th>
                <td><?php if ($form_data['agree']) { echo "同意しました"; } ?></td>
            </tr>
        </table>

        <script>
          function submit1() {
              document.frm1.submit();
          }
          function submit2() {
              document.frm2.submit();
          }
        </script>

        <div id="next_or_prev">
          <form name="frm1" method="post" action="thanks.php">
            <div class="next_button_area">
                <?php foreach($form_data AS $k => $v){?>
                <?php if(is_array($v)){?>
                <?php foreach($v AS $k2 => $v2){?>
                <input type="hidden" name="<?php echo $k;?>[]" value="<?php echo $v2;?>">
                <?php }?>
                <?php }else{?>
                <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>">
                <?php }?>
                <?php }?>
                <input type="hidden" name="ticket" value="<?php echo $ticket ?>">
                <input type="button" onclick="submit1();" value="確定する" class="next_button">
            </div>
          </form>
          <form name="frm2" method="post" action="input_data.php">
            <div class="prev_button_area">
                <?php foreach($form_data AS $k => $v){?>
                <?php if(is_array($v)){?>
                <?php foreach($v AS $k2 => $v2){?>
                <input type="hidden" name="<?php echo $k;?>[]" value="<?php echo $v2;?>">
                <?php }?>
                <?php }else{?>
                <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>">
                <?php }?>
                <?php }?>
                <input type="hidden" name="ticket" value="<?php echo $ticket ?>">
                <input type="hidden" name="prev_page" value="pushed">
                <input type="button" onclick="submit2();" value="内容を修正する" class="prev_button">
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>

