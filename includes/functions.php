<?php

  ##################################################
  # 全角/半角 系
  ##################################################

  #全角チェック関数
  function chk_full_char($str_checkString)
  {

      mb_regex_encoding("UTF-8");//全角文字を許可する
      if (preg_match("/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #半角英数チェック関数
  function chk_half_char($str_checkString)
  {

      if (preg_match("/^[a-zA-Z0-9]+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  ##################################################
  # 文字 系
  ##################################################

  #カタカナチェック関数
  function chk_katakana($str_checkString)
  {

      if (preg_match("/^[ァ-ヾ]+$/u", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #半角英チェック関数
  function chk_half_alpha_char($str_checkString)
  {

      if (preg_match("/^[a-zA-Z]+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #空白チェック関数
  #(半角スペース/全角スペース/タブのいずれかだけから成る文字列は可)
  function chk_space($str_checkString)
  {

      if (preg_match("/^(\s|　)+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #禁則文字を置換する関数
  function banned_replace($str_checkString)
  {
      $str_checkString = str_replace('<', '＜', $str_checkString);
      $str_checkString = str_replace('>', '＞', $str_checkString);
      $str_checkString = str_replace('\'', '', $str_checkString);
      $str_checkString = str_replace("\"", '', $str_checkString);
      $str_checkString = str_replace("&",  '＆', $str_checkString);
      $str_checkString = str_replace(":",  '：', $str_checkString);
      $str_checkString = str_replace(";",  '；', $str_checkString);

      return $str_checkString;
  }

  ##################################################
  # 数字 系
  ##################################################

  #電話番号チェック関数
  function chk_tel_num($str_checkString)
  {

      if (preg_match("/^0\d{9,11}$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #半角数字チェック関数(整数のみ可)
  function chk_integer($str_checkString)
  {

      if (preg_match("/^[0-9]+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #半角数字7桁チェック関数(ハイフンなしのみ可)
  #(cf.123-4567は不可、1234567は可)
  function chk_seven_digit($str_checkString)
  {

      if (preg_match("/^[0-9]{7}+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  #郵便番号チェック関数(ハイフンありでもなしでも可)
  #(cf.123-4567でも1234567でも可)
  function chk_zip_code($str_checkString)
  {

      if (preg_match("/^([0-9]{3}-[0-9]{4})?$|^[0-9]{7}+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  ##################################################
  # 日付 系
  ##################################################

  #日付チェック関数(日付の妥当性チェック)
  #(cf.2016年02月29日はうるう年なので可/2017年02月29日は不可、というチェック)
  #もともとあるcheckdate()と同じ(なので要らないかも)
  function chk_date($month ,$day ,$year)
  {

      if (checkdate($month ,$day ,$year))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

  ##################################################
  # メールアドレス 系
  ##################################################

  #メールアドレスチェック関数
  function chk_mail_addr($str_checkString)
  {

      if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str_checkString))
      {
          return true;
      }
      else
      {
          return false;
      }

  }

?>
