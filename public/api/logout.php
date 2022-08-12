<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  
  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  if ($mysqli->connect_errno) {
    $answer = array('status' => 'error', 'message' => 'No access to the database!');
    echo json_encode($answer);
    die;  
  }

  $token = $mysqli->real_escape_string($_COOKIE['token']);
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    $answer = array('status' => 'error', 'message' => 'Not loggeed!');
    echo json_encode($answer);
    die;
  }
  
  $sql = "UPDATE users SET users_token='', users_token_expire_date=NULL WHERE users_token='$token';";
  $res = $mysqli->query($sql);

  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error update data in the database!');
    echo json_encode($answer);
    die;
  }

  $answer = array('status' => 'succes', 'data' => ['logout' => true]);
  setcookie('token', '', time() - 3600);
  echo json_encode($answer);
?>