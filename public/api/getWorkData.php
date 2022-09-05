<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $work_id = $_GET['work_id'];

  $sql = "SELECT works_images FROM works WHERE works_id = '$work_id';";
  $res = $mysqli->query($sql);
  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error get data from the database!');
    die(json_encode($answer));
  }

  $row = $res->fetch_assoc();

  $response = array();
  $response['images'] = $row['works_images'];

  echo json_encode($response);
?>
