<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    die(json_encode($answer));
  }

  $_POST = json_decode(file_get_contents("php://input"), true);
  $title = $mysqli->real_escape_string($_POST['title']);
  $description = $mysqli->real_escape_string($_POST['description']);
  $condition = $mysqli->real_escape_string($_POST['condition']);
  if ($title && $description) {
    $sql = sprintf("UPDATE work_types SET work_types_title='%s',work_types_description='%s' WHERE work_types_title='%s';", $title, $description, $condition);
    $res = $mysqli->query($sql);
    if (!$res) {
      http_response_code(500);
      $answer = array('status' => 'error', 'message' => 'Error update data in the database!');
      die(json_encode($answer));
    }
  }
  $answer = array('status' => 'succes', 'data' => ['work_types_title' => $title, 'work_types_description' => $description]);
  echo json_encode($answer);
?>
