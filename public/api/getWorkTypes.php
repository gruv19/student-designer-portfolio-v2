<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $sql = 'SELECT work_types_title, work_types_description FROM work_types;';
  $res = $mysqli->query($sql);
  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error get data from the database!');
    die(json_encode($answer));
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
