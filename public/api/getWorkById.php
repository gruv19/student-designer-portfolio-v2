<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $id = $mysqli->real_escape_string($_GET['id']);

  $sql = "SELECT * FROM works WHERE works_id = '$id'";

  $res = $mysqli->query($sql);
  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error get data from the database!');
    die(json_encode($answer));
  }

  $response = array();
  while ($row = $res->fetch_assoc()) {
    $response['id'] = $row['works_id'];
    $response['type'] = $row['works_type'];
    $response['mainImage'] = $row['works_main_image'];
    $response['images'] = json_decode($row['works_images']);
    $response['title'] = $row['works_title'];
    $response['subtitle'] = $row['works_subtitle'];
    $response['task'] = $row['works_task'];
    $response['link'] = $row['works_link'];
    $i++;
  }

  echo json_encode($response);
?>
