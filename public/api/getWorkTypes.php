<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header("Access-Control-Allow-Headers: Content-Type");
  
  require_once('./config.php');
  
  $mysqli = new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
  if ($mysqli->connect_errno) {
      header("HTTP/1.0 403 Forbidden");
      die;
  }

  $sql = 'SELECT work_types_title, work_types_description FROM work_types;';
  $res = $mysqli->query($sql);
  if (!$res) {
    header("HTTP/1.0 403 Forbidden");
    die;
  }

  $response = array();
  $i = 0;
  while ($row = $res->fetch_assoc()) {
    $response[$i]['title'] = $row['work_types_title'];
    $response[$i]['description'] = $row['work_types_description'];
    $i++;
  }
  echo json_encode($response);
?>