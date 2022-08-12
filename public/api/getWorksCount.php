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

  $sql = 'SELECT works_type, COUNT(*) AS works_count FROM works GROUP BY works_type;';
  $res = $mysqli->query($sql);
  if (!$res) {
    header("HTTP/1.0 403 Forbidden");
    die;
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