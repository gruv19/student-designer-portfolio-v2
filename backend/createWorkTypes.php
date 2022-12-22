<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $_POST = json_decode(file_get_contents("php://input"), true);
  $title = $mysqli->real_escape_string($_POST['title']);
  $description = $mysqli->real_escape_string($_POST['description']);

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    die(json_encode($answer));
  }

  if ($title && $description) {
    $sql = sprintf("INSERT INTO work_types (work_types_title, work_types_description) VALUES ('%s', '%s');", $title, $description);
    $res = $mysqli->query($sql);
    if (!$res) {
      http_response_code(500);
      $answer = array('status' => 'error', 'message' => 'Error insert data in the database!');
      die(json_encode($answer));
    }
  }
  $answer = array('status' => 'succes', 'data' => ['insert_id' => $mysqli->insert_id]);
  echo json_encode($answer);
?>
