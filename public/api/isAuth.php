<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header("Access-Control-Allow-Headers: Content-Type");
  
  require_once('./config.php');
  require_once('./utils.php');
  
  $mysqli = new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  if ($mysqli->connect_errno) {
    $answer = array('status' => 'error', 'message' => 'No access to the database!');
    echo json_encode($answer);
    die;
  }

  $_POST = json_decode(file_get_contents("php://input"), true);
  $token = $mysqli->real_escape_string($_POST['token']);
  if ($token === '') {
    $token = $_COOKIE['token'];
  }

  $answer = isAuth($mysqli, $token);
  echo json_encode($answer);
?>