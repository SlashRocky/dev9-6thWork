<?php
  session_start();

  //関数定義ファイル読込
  include_once("includes/functions.php");

  // チケット処理：ワンタイムチケットの生成
  $ticket = md5(uniqid(rand(), true));

  // 生成したチケットをセッション変数へ保存
  $_SESSION['ticket'] = $ticket;

  //エラー変数
  $input_err_check = false;

  //エラーメッセージ用変数
  $err_lname_msg  = "";
  $err_fname_msg  = "";
  $err_lkname_msg = "";
  $err_fkname_msg = "";
  $err_age_msg    = "";
  $err_pref_msg	  = "";
  $err_addr01_msg = "";
  $err_addr02_msg = "";
  $err_tel_msg	  = "";
  $err_agree_msg  = "";

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
	
  //アンケートの回答を配列で受け取って、変数$form_dataに格納
  $form_data = array();

  //POSTで渡された値をそのままチェック変数で受け取る
  $chk_interest       = isset($_POST["interest"]) ? $_POST["interest"] : "";
  $chk_want           = isset($_POST["want"]) ? $_POST["want"] : "";
  $chk_continue       = isset($_POST["continue"]) ? $_POST["continue"] : "";
  $chk_reference      = isset($_POST["reference"]) ? $_POST["reference"] : "";
  $chk_lastName		    = isset($_POST["lname"]) ? $_POST["lname"] : "";
  $chk_firstName	    = isset($_POST["fname"]) ? $_POST["fname"] : "";
  $chk_kana_lastName  = isset($_POST["lkname"]) ? $_POST["lkname"] : "";
  $chk_kana_firstName = isset($_POST["fkname"]) ? $_POST["fkname"] : "";
  $chk_age			      = isset($_POST["age"]) ? $_POST["age"] : "";
  //$chk_post_no      = isset($_POST["post_no"]) ? $_POST["post_no"] : "";
  $chk_prefecture	    = isset($_POST["pref"]) ? $_POST["pref"] : "";
  $chk_addr01		      = isset($_POST["addr01"]) ? $_POST["addr01"] : "";
  $chk_addr02		      = isset($_POST["addr02"]) ? $_POST["addr02"] : "";
  $chk_tel		        = isset($_POST["tel"]) ? $_POST["tel"] : "";
  $chk_email	        = isset($_POST["email"]) ? $_POST["email"] : "";
  $chk_agree		      = isset($_POST["agree"]) ? $_POST["agree"] : "";
	
  //禁止文字を置換
  $form_data['interest']  = banned_replace($chk_interest);
  $form_data['want']      = banned_replace($chk_want);
  $form_data['continue']  = banned_replace($chk_continue);
  $form_data['reference'] = banned_replace($chk_reference);
  $form_data['lname']	    = banned_replace($chk_lastName);
  $form_data['fname']	    = banned_replace($chk_firstName);
  $form_data['lkname']	  = banned_replace($chk_kana_lastName);
  $form_data['fkname']	  = banned_replace($chk_kana_firstName);
  $form_data['age']		    = banned_replace($chk_age);
  //$form_data['post_no'] = banned_replace($chk_post_no);
  $form_data['pref']	    = banned_replace($chk_prefecture);
  $form_data['addr01']	  = banned_replace($chk_addr01);
  $form_data['addr02']	  = banned_replace($chk_addr02);
  $form_data['tel']		    = banned_replace($chk_tel);
  $form_data['email']	    = banned_replace($chk_email);
  $form_data['agree']     = banned_replace($chk_agree);
	

  /* ----------------------------------------
  入力チェック
  ---------------------------------------- */
  // [確認画面へ進む]がクリックされた場合
  if (isset($_POST["next_page"])) {

    //エラー変数
    $input_err_check = true;

    //エラーメッセージ用変数
    $err_lname_msg	= "";
    $err_fname_msg	= "";
    $err_lkname_msg	= "";
    $err_fkname_msg	= "";
    $err_age_msg    = "";
    $err_pref_msg	  = "";
    $err_addr01_msg = "";
    $err_addr02_msg = "";
    $err_tel_msg	  = "";
    $err_agree_msg  = "";

    //姓の入力
    if (!$form_data['lname']) {
      $err_lname_msg = "姓を入力してください。";
      $input_err_check = false;
    }

    //名の入力
    if (!$form_data['fname']) {
      $err_fname_msg = "名を入力してください。";
      $input_err_check = false;
    }

    //セイの入力
    if (!$form_data['lkname']) {
      $err_lkname_msg = "セイを入力してください。";
      $input_err_check = false;
    }

    //メイの入力
    if (!$form_data['fkname']) {
      $err_fkname_msg = "メイを入力してください。";
      $input_err_check = false;
    }

    //メイの入力
    if (!$form_data['fkname']) {
      $err_fkname_msg = "メイを入力してください。";
      $input_err_check = false;
    }

    //年齢の入力
    if (!$form_data['age']) {
      $err_age_msg = "年齢を入力してください。";
      $input_err_check = false;
    }

    //都道府県の入力
    if (!$form_data['pref']) {
      $err_pref_msg = "都道府県を入力してください。";
      $input_err_check = false;
    }

    //市区町村の入力
    if (!$form_data['addr01']) {
      $err_addr01_msg = "市区町村を入力してください。";
      $input_err_check = false;
    }

    //番地以降の入力
    if (!$form_data['addr02']) {
      $err_addr02_msg = "番地以降を入力してください。";
      $input_err_check = false;
    }

    //電話番号の入力
    if (!$form_data['tel']) {
      $err_tel_msg = "電話番号を入力してください。";
      $input_err_check = false;
    }

    //「個人情報保護方針」「勧誘方針」の同意
    if (!$form_data['agree']) {
      $err_agree_msg = "「個人情報保護方針」「勧誘方針」の同意が必要です";
      $input_err_check = false;
    }

  }

  //全項目にチェックされエラーが無く、かつ確認画面から遷移でない場合、次画面へ遷移
  if ( $input_err_check == true && empty($_POST["prev_page"]) ) {
?>
  <form name="chk_frm" method="post" action="confirm.php">
    <input type="hidden" name="ticket" value="<?php echo $ticket ?>">
    <?php foreach($form_data AS $k => $v){?>
    <?php if(is_array($v)){?>
    <?php foreach($v AS $k2 => $v2){?>
    <input type="hidden" name="<?php echo $k;?>[]" value="<?php echo $v2;?>">
    <?php }?>
    <?php }else{?>
    <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>">
    <?php }?>
    <?php }?>
    <script type="text/javascript">document.chk_frm.submit();</script>
  </form>
<?php
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
        <h1>アンケートに答えてね♪<br></h1>
      </div>

      <!-- コンテンツ -->
      <div id="content">
       
        <p>仮想通貨に興味を持っていただき、誠にありがとうございます。<br>今後の運営の参考にさせて頂きますので、ご感想をお聞かせください。</p>
        
        <form id="inputForm" name="chk_input" method="post" action="input_data.php">
          <div class="innerwrap">
            <div class="inner-contents">

              <h3 class="chapter1">◆仮想通貨についてお聞かせください。</h3>
              <div class="inner-chapter1">

                <h5 class="title-line"><span class="names">仮想通貨に興味を持ったきっかけを教えてください。</span></h5>
                <div class="form-group-inline">
                  <ul class="booth">
                    <li>
                      <input type="radio" id="news" name="interest" value="ニュースで見て" onclick="boothChange();" <?php if(isset($form_data['interest']) && $form_data['interest'] == "ニュースで見て"){?> checked <?php }?> />
                      <label for="news">ニュースで見て</label>
                    </li>
                    <li>
                      <input type="radio" id="friend" name="interest" value="友人や知人から話を聞いて" onclick="boothChange();" <?php if(isset($form_data['interest']) && $form_data['interest'] == "友人や知人から話を聞いて"){?> checked <?php }?> />
                      <label for="friend">友人や知人から話を聞いて</label>
                    </li>
                    <li>
                      <input type="radio" id="sns" name="interest" value="SNSで盛り上がっているのを見て" onclick="boothChange();" <?php if(isset($form_data['interest']) && $form_data['interest'] == "SNSで盛り上がっているのを見て"){?> checked <?php }?> />
                      <label for="sns">SNSで盛り上がっているのを見て</label>
                    </li>
                    <li>
                      <input type="radio" id="happened" name="interest" value="なんとなく" onclick="boothChange();" <?php if(isset($form_data['interest']) && $form_data['interest'] == "なんとなく"){?> checked <?php }?> />
                      <label for="happened">なんとなく</label>
                    </li>
                  </ul>
                </div>

                <h5 class="title-line"><span class="names">一番欲しい仮想通貨は何ですか。</span></h5>
                <div class="form-group-inline">
                  <ul class="lottery">
                    <li>
                      <input type="radio" id="btc" name="want" value="ビットコイン" onclick="lotteryChange();" <?php if(isset($form_data['want']) && $form_data['want'] == "ビットコイン"){?> checked <?php }?> />
                      <label for="btc">ビットコイン</label>
                    </li>
                    <li>
                      <input type="radio" id="eth" name="want" value="イーサリアム" onclick="lotteryChange();" <?php if(isset($form_data['want']) && $form_data['want'] == "イーサリアム"){?> checked <?php }?> /> 
                      <label for="eth">イーサリアム</label>
                    </li>
                    <li>
                      <input type="radio" id="xrp" name="want" value="リップル" onclick="lotteryChange();"　<?php if(isset($form_data['want']) && $form_data['want'] == "リップル"){?> checked <?php }?>　/>
                      <label for="xrp">リップル</label>
                    </li>
                    <li>
                      <input type="radio" id="jpy" name="want" value="日本円" onclick="lotteryChange();" <?php if(isset($form_data['want']) && $form_data['want'] == "日本円"){?> checked <?php }?> />
                      <label for="jpy">日本円</label>
                    </li>
                  </ul>
                </div>

                <h5 class="title-line"><span class="names">先日仮想通貨が大暴落しましたが、まだ仮想通貨に興味はありますか。</span></h5>
                <div class="form-group-inline">
                  <ul class="event">
                    <li>
                      <input type="radio" id="continueYes" name="continue" value="はい" onclick="eventChange();"　<?php if(isset($form_data['continue']) && $form_data['continue'] == "はい"){?> checked <?php }?>　/>
                      <label for="continueYes">はい</label>
                    </li>
                    <li>
                      <input type="radio" id="continueNo" name="continue" value="いいえ" onclick="eventChange();" <?php if(isset($form_data['continue']) && $form_data['continue'] == "いいえ"){?> checked <?php }?> />
                      <label for="continueNo">いいえ</label>
                    </li>
                  </ul>
                </div>

                <h3 class="chapter4">◆（今後の参考に）何かあれば一言お願いいたします。</h3>
                <div class="form-group-line">
                  <textarea id="txt_contents" name="reference" rows="8" maxlength="400" nowrap placeholder=""  class="form-control01"><?php if(isset($form_data['reference'])){ echo $form_data["reference"]; }?></textarea>
                    <div id="err_msg" style="color:#F25555;"></div>
                </div>

              </div>


              <h3 class="chapter2">◆ お客様情報</h3>
              <p>　 ※ 正確にご記入ください。</p>
              <div class="inner-chapter2">

                <h5 class="title-survey title-line"><span class="names">【 １ 】お名前</span><span class="necessary">必須</span></h5>
                <div class="right_form">

                  <div class="form-group-line lastName">
                    <!-- 姓入力フィールド -->
                    <label>姓：</label>
                    <input placeholder="例)　仮想" value="<?php echo $form_data['lname']; ?>" type="text" id="lnamae" class="form-control01" name="lname" ng-model="lname" onkeypress="return handleEnter(this, event)">
                    <!-- エラーメッセージ -->
                    <div id="lname" class="err_mess" <?php if($err_lname_msg){?> style="display:block;" <?php }?>><?php echo $err_lname_msg;?></div>
                  </div>

                  <div class="form-group-line firstName">
                    <!-- 名入力フィールド -->
                    <label>名：</label>
                    <input placeholder="例)　太郎" value="<?php echo $form_data['fname']; ?>" type="text" id="fnamae" class="form-control01" name="fname" ng-model="fname" onkeypress="return handleEnter(this, event)">
                    <!-- エラーメッセージ -->
                    <div id="err_fname" class="err_mess" <?php if($err_fname_msg){?> style="display:block;" <?php }?>><?php echo $err_fname_msg;?></div>
                  </div>

                  <div class="clr"></div>

                  <div class="form-group-line lastName_kana">
                    <!-- セイ入力フィールド -->
                    <label>セイ：</label>
                    <input placeholder="例)　カソウ" value="<?php echo $form_data['lkname']; ?>" type="text" id="lnamae" class="form-control01" name="lkname" ng-model="lname" onkeypress="return handleEnter(this, event)">
                    <!-- エラーメッセージ -->
                    <div id="err_lkname" class="err_mess" <?php if($err_lkname_msg){?> style="display:block;" <?php }?>><?php echo $err_lkname_msg;?></div>
                  </div>

                  <div class="form-group-line firstName_kana">
                    <!-- メイ入力フィールド -->
                    <label>メイ：</label>
                    <input placeholder="例)　タロウ" value="<?php echo $form_data['fkname']; ?>" type="text" id="fnamae" class="form-control01" name="fkname" ng-model="fname" onkeypress="return handleEnter(this, event)">
                    <!-- エラーメッセージ -->
                    <div id="err_fkname" class="err_mess" <?php if($err_fkname_msg){?> style="display:block;" <?php }?>><?php echo $err_fkname_msg;?></div>
                  </div>

                  <div class="clr"></div>

                </div>

                <h5 class="title-survey title-line question2_2"><span class="names">【 2 】年代</span><span class="necessary">必須</span></h5>
                <div class="form-group-survey address">
                  <!-- ▼年齢入力フィールド -->
                  <select id="age" class="inner-address1" name="age" ng-model="age">
                    <option value="">選択してください</option>
                    <?php foreach($age_list AS $k => $v){?>
                    <option value="<?php echo $k;?>" <?php if($k == $form_data['age']){?> selected <?php }?>><?php echo $v;?></option>
                    <?php }?>
                  </select>
                  <!-- エラーメッセージ -->
                  <div id="err_age" class="err_mess" <?php if($err_age_msg){?> style="display:block;" <?php }?>><?php echo $err_age_msg;?></div>
                </div>

                <h5 class="title-survey title-line question2_2"><span class="names">【 3 】住所</span><span class="necessary">必須</span></h5>
                <div class="form-group-survey address">
                  <!-- ▼郵便番号入力フィールド(7桁) -->
                  <?php 
                    /*
                    郵便番号：<input placeholder="例)　214032（ハイフンなし）" type="text" name="post_no" size="46" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref','addr01');" class="inner-address1" value="<?php echo $form_data['post_no'];?>"><br />
                    */ 
                  ?>
                  <!-- ▼都道府県入力フィールド -->
                  <span class="title_prefectures">都道府県：</span>
                  <select class="selectpicker pref" name="pref">
                    <option class="text_prefectures" value="">都道府県をお選びください</option>
                    <?php foreach($pref_list AS $k => $v){?>
                    <option value="<?php echo $k;?>" <?php if($k == $form_data['pref']){?> selected <?php }?>><?php echo $v;?></option>
                    <?php }?>
                  </select><br />
                  <!-- エラーメッセージ -->
                  <div id="err_pref" class="err_mess" <?php if($err_pref_msg){?> style="display:block;" <?php }?>><?php echo $err_pref_msg;?></div>

                  <!-- ▼都道府県以降の住所入力フィールド -->
                  <div class="detail_address">
                    <span class="title_city">市区町村：</span>
                    <input placeholder="例)　川崎市多摩区枡形" type="text" name="addr01" size="46" class="inner-address4" value="<?php echo $form_data['addr01'];?>"><br />
                    <!-- エラーメッセージ -->
                    <div id="err_addr01" class = "err_mess" <?php if($err_addr01_msg){?> style="display:block;" <?php }?>><?php echo $err_addr01_msg;?></div>

                    <div class="detail_address_2">
                      <span class="title_city2">番地以降：</span>
                      <input placeholder="例)　1-2-3" type="text" name="addr02" size="46" class="inner-address5" value="<?php echo $form_data['addr02'];?>"><br />
                      <!-- エラーメッセージ -->
                      <div id="err_addr02" class = "err_mess" <?php if($err_addr02_msg){?> style="display:block;" <?php }?>><?php echo $err_addr02_msg;?></div>
                    </div>
                  </div>
                </div>

                <h5 class="title-survey title-line question2_3"><span class="names">【 4 】電話番号（繋がりやすい番号をご記入ください。）</span><span class="necessary">必須</span></h5>
                <div class="form-group-line">
                    <!-- ▼電話番号入力フィールド -->
                    <input placeholder="例)　09012345678（ハイフンなし）" value = "<?php echo $form_data['tel']; ?>" type="tel" id="calladdress" name="tel"  class="form-control01">
                    <p style="color:#555555;">※ 本人確認等でお電話をおかけすることがございます。</p>
                    <!-- エラーメッセージ -->
                    <div id="$err_tel" class="err_mess" <?php if($err_tel_msg){?> style="display:block;" <?php }?>><?php echo $err_tel_msg;?></div>
                </div>

                <h5 class="title-line question2_4"><span class="names">【 5 】メールアドレス（お持ちでしたらご記入ください。）</span></h5>
                <div class="form-group-line">
                    <input placeholder="例)　info@togo-sec.co.jp" type="text" id="str_mail_address" name="email" value="<?php echo $form_data['email']; ?>" <?php if (!empty($err_mail_address_msg)) {?> style="<?php echo $str_err_border ?>" <?php } ?> class="form-control01"/>
                    <p>※ メールアドレスは半角英数字で入力してください。</p>
                </div>
                
              </div>

              <div class="innerwrap m-btm50 privacy">
                  <h4>個人情報取扱いについて</h4>
                  <div class="inner-contents p30">
                      <p> 下記の「個人情報保護方針」「個人情報の利用目的」「勧誘方針」をご一読していただき、内容に同意いただける場合は「同意する」にチェックをつけてください。 </p>
                      <div class="box_srcollbar">
                        <h6>個人情報保護方針</h6>
                        <p>Bit Emotion株式会社は、お客さまの個人情報及び個人番号(以下「個人情報等」という。)に対する取組み方針として、次の通り個人情報保護方針を策定し、公表いたします。</p>
                        <h6>個人情報保護の基本方針</h6>
                        <p>Bit Emotion株式会社及びその役員・従業員等は、個人情報等の保護に関する関係諸法令、監督当局のガイドライン及び認定個人情報保護団体の指針等を遵守いたします。</p>
                        <ul class="listNumber listNumber_1">
                          <li>個人情報等は、法令に則って取得し、その内容は、正確・最新となるよう努めます。</li>
                          <li>個人情報の利用は、利用目的の範囲を超えては行いません。また、第三者への個人情報の開示・提供は、法令に基づきその開示が義務づけられるなどの正当な理由がない限り、本人の承諾なしに行いません。個人番号については、法令で定められた範囲内でのみ取扱います。</li>
                          <li>個人情報等の流出、不正利用などを防止するために、役員・従業員等への教育を徹底します。また、管理・点検の責任者を任命し、適正な管理体制を整備します。</li>
                          <li>個人情報等を外部委託先に取扱わせる場合には、その委託先においても個人情報保護が図られているかについて、責任をもって監督します。</li>
                          <li>個人情報については、本人の求めにより、開示・訂正・利用停止などを法令に則り行います。この場合、所定の費用を頂戴することがあります。なお、個人番号の保有の有無について開示のお申出があった場合には、個人番号の保有の有無について回答いたします。</li>
                        </ul>
                      </div>
                      <div class="centerBtn">
                          <div id="agree">
                              <label>
                                  <input type="checkbox" id="agree" class="form-control" name="agree" value="1" onkeypress="return handleEnter(this, event)" />同意します
                              </label>
                          </div>
                          <!-- エラーメッセージ -->
                          <div id="err_agree" class="err_mess" <?php if($err_agree_msg){?> style="display:block;" <?php }?>><?php echo $err_agree_msg?></div>
                      </div>
                  </div>
              </div>

            </div>
            <p class="thanks">ご協力頂きましてありがとうございました。</p>
          </div>

          <div class="next_button_area">
              <button type="submit" name="next_page" value="pushed" class="next_button">確認画面へ進む</button>
              <?php
                // 生成したワンタイムチケットをPOSTする
                echo '<form name="inputfrm" method="post" action="confirm.php">';
                echo '<input type="hidden" name="ticket" value="'.$ticket.'">';
                echo '<script type="text/javascript">document.inputfrm.submit();</script>';
                echo '</form>';
              ?>
          </div>

        </form>
      </div>
	</div>
  </body>
</html>