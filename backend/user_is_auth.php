<?php
  require_once('./config.php');
  require_once('./utils.php');
  
  header('Access-Control-Allow-Origin: ' . FRONTEND_HOST);
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $_POST = json_decode(file_get_contents("php://input"), true);

  $token = $mysqli->real_escape_string($_POST['token']);

  $answer = is_auth($mysqli, $token);

  echo json_encode($answer);
?>
