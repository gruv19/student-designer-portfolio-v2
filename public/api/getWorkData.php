<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header("Access-Control-Allow-Headers: X-Requested-With");
  
  require_once('./config.php');
  
  $mysqli = new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
  if ($mysqli->connect_errno) {
      header("HTTP/1.0 403 Forbidden");
      die;
  }
  $work_id = $_GET['work_id'];

  $sql = 'SELECT works_images FROM works WHERE works_id = "' . $work_id . '";';
  $res = $mysqli->query($sql);
  if (!$res) {
    header("HTTP/1.0 403 Forbidden");
    die;
  }

  $row = $res->fetch_assoc();

  $response = array();
  $response['images'] = $row['works_images'];

  echo json_encode($response);
?>