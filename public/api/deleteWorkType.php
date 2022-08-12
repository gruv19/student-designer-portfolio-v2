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

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    echo json_encode($answer);
    die;
  }

  $_POST = json_decode(file_get_contents("php://input"), true);
  $title = $mysqli->real_escape_string($_POST['title']);
  if ($title) {
    $sql = sprintf("DELETE FROM work_types WHERE work_types_title='%s';", $title);
    $res = $mysqli->query($sql);
    if (!$res) {
      $answer = array('status' => 'error', 'message' => 'Error delete data in the database!');
      echo json_encode($answer);
      die;
    }
  }
  $answer = array('status' => 'succes', 'data' => ['delete' => $title]);
  echo json_encode($answer);
?>