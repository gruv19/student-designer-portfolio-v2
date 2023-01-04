<?php
  require_once('./config.php');
  require_once('./utils.php');

  header('Access-Control-Allow-Origin: ' . FRONTEND_HOST);
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return "ok";
  }

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $_POST = json_decode(file_get_contents("php://input"), true);

  $token = $mysqli->real_escape_string($_POST['token']);

  $is_auth = is_auth($mysqli, $token);

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
  echo json_encode($answer);
?>
