<html>
	<head>
		<script src="js/jquery.js"></script>
		<style>
			#content {
				margin: 0 auto;
			}
			table{
				border: 1px solid #e4e4e4;
			}
			th {
				border: 1px solid #e4e4e4;
				padding: 4px 8px;
				background: #f5f7f9;
				color: #444;
				font-size: 12px;
			}
			td {
				border: 1px solid #e4e4e4;
				padding: 4px 8px;
				color: #444;
				font-size: 12px;
			}
		</style>
	</head>	
	<body>
	    
      <p class="wgtStr">回答結果</p>
      <table class="tblSide">
        <thead>
          <tr class="font12">
            <th class="tl bgWht02 cb4 wgtStr">興味を持ったきっかけ</th>
            <th class="tl bgWht02 cb4 wgtStr">一番欲しい仮想通貨</th>
            <th class="tl bgWht02 cb4 wgtStr">今後の興味</th>
            <th class="tl bgWht02 cb4 wgtStr">何か一言</th>
            <th class="tl bgWht02 cb4 wgtStr">姓</th>
            <th class="tl bgWht02 cb4 wgtStr">名</th>
            <th class="tl bgWht02 cb4 wgtStr">セイ</th>
            <th class="tl bgWht02 cb4 wgtStr">メイ</th>
            <th class="tl bgWht02 cb4 wgtStr">年代</th>
            <th class="tl bgWht02 cb4 wgtStr">都道府県</th>
            <th class="tl bgWht02 cb4 wgtStr">市区町村</th>
            <th class="tl bgWht02 cb4 wgtStr">番地以降</th>
            <th class="tl bgWht02 cb4 wgtStr">電話番号</th>
            <th class="tl bgWht02 cb4 wgtStr">メールアドレス</th>
            
          </tr>
        </thead>
        <tbody class="tbdy">
	
		<?php
			//変数linesにdata.csvの内容を格納　格納される値は配列　→　ex)$lines[0]は一人分のデータ
			$lines = file('data/data.csv');
      
			//全ての行を処理するためにforeachを使う $lineは一人分
			foreach($lines as $line){
              echo '<tr class="font12 w100">';
				//$lineの内容をあとで加工するためにカンマで分割
				$data = explode(',',$line);
				foreach($data AS $k => $v){
                  echo '<td class="tl">'.$v.'</td>';    
                }
                echo '</tr>';
			}
		?>
		
        </tbody>
      </table>
		
	</body>
</html>