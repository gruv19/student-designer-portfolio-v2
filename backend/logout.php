<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $token = $mysqli->real_escape_string($_COOKIE['token']);
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Not loggeed!');
    die(json_encode($answer));
  }

  $sql = "UPDATE users SET users_token='', users_token_expire_date=NULL WHERE users_token='$token';";
  $res = $mysqli->query($sql);

  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error update data in the database!');
    die(json_encode($answer));
  }

  $answer = array('status' => 'succes', 'data' => ['logout' => true]);
  setcookie('token', '', time() - 3600);
  echo json_encode($answer);
?>
