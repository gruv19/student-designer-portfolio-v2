<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header("Access-Control-Allow-Headers: Content-Type");
  header('Content-Type: application/json');

  require_once('./config.php');
  
  $mysqli = new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
  if ($mysqli->connect_errno) {
    $answer = array('status' => 'error', 'message' => 'No access to the database!');
    echo json_encode($answer);
    die;
  }
  $id = $mysqli->real_escape_string($_GET['id']);

  $sql = "SELECT * FROM works WHERE works_id = '$id'";

  $res = $mysqli->query($sql);
  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error select data in the database!');
    echo json_encode($answer);
    die;
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