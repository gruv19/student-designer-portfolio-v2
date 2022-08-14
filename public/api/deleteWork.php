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
  $work_id = $mysqli->real_escape_string($_POST['id']);
  if ($work_id) {
    $sql = sprintf("DELETE FROM works WHERE works_id=%s;", $work_id);
    $res = $mysqli->query($sql);
    if (!$res) {
      $answer = array('status' => 'error', 'message' => 'Error delete data in the database!');
      echo json_encode($answer);
      die;
    }
  }
  $answer = array('status' => 'succes', 'data' => ['delete' => $id]);
  echo json_encode($answer);
?>