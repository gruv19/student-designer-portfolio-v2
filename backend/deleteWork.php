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
  $work_id = $mysqli->real_escape_string($_POST['id']);
  if ($work_id) {
    remove_main_image($mysqli, $work_id);
    remove_work_images($mysqli, $work_id);
    $sql = sprintf("DELETE FROM works WHERE works_id=%s;", $work_id);
    $res = $mysqli->query($sql);
    if (!$res) {
      http_response_code(500);
      $answer = array('status' => 'error', 'message' => 'Error delete data in the database!');
      die(json_encode($answer));
    }
  }

  $answer = array('status' => 'succes', 'data' => ['delete' => $id]);
  echo json_encode($answer);
?>
