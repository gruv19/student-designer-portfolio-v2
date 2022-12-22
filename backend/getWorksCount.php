<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $sql = "SELECT works_type, COUNT(*) AS works_count FROM works GROUP BY works_type;";
  $res = @$mysqli->query($sql);
  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error get data from the database!');
    die(json_encode($answer));
  }

  $response = array();
  $i = 0;
  while ($row = $res->fetch_assoc()) {
    $response[$i]['type'] = $row['works_type'];
    $response[$i]['count'] = $row['works_count'];
    $i++;
}

  echo json_encode($response);
?>
