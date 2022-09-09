<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $all = ($_GET['all'] === 'true') ? true : false;

  $sql = "SELECT * FROM contacts";

  if (!$all) {
    $sql = $sql . " WHERE contacts_show=1";
  }

  $res = $mysqli->query($sql);
  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error get data from the database!');
    die(json_encode($answer));
  }

  $response = array();
  $i = 0;
  while ($row = $res->fetch_assoc()) {
    $response[$i]['id'] = $row['contacts_id'];
    $response[$i]['title'] = $row['contacts_title'];
    $response[$i]['link'] = $row['contacts_link'];
    $response[$i]['show'] = $row['contacts_show'];
    $i++;
  }

  echo json_encode($response);
?>
