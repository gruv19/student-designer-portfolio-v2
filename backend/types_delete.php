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

  $title = $mysqli->real_escape_string($_POST['title']);
  $token = $mysqli->real_escape_string($_POST['token']);

  $is_auth = is_auth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    die(json_encode($answer));
  }

  if ($title) {
    $sql = sprintf("DELETE FROM work_types WHERE work_types_title='%s';", $title);
    $res = $mysqli->query($sql);
    if (!$res) {
      http_response_code(500);
      $answer = array('status' => 'error', 'message' => 'Error delete data in the database!');
      die(json_encode($answer));
    }
  }
  $answer = array('status' => 'succes', 'data' => ['delete' => $title]);
  echo json_encode($answer);
?>
