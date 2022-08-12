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

  $_POST = json_decode(file_get_contents("php://input"), true);
  $title = $mysqli->real_escape_string($_POST['title']);
  $description = $mysqli->real_escape_string($_POST['description']);

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    echo json_encode($answer);
    die;
  }

  if ($title && $description) {
    $sql = sprintf("INSERT INTO work_types (work_types_title, work_types_description) VALUES ('%s', '%s');", $title, $description);
    $res = $mysqli->query($sql);
    if (!$res) {
      $answer = array('status' => 'error', 'message' => 'Error insert data in the database!');
      echo json_encode($answer);
      die;
    }
  }
  $answer = array('status' => 'succes', 'data' => ['insert_id' => $mysqli->insert_id]);
  echo json_encode($answer);
?>