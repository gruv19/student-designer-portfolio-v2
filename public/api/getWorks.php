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
  $from = (empty($_GET['from'])) ? 0 : $_GET['from'];
  $filter = (empty($_GET['filter'])) ? 'all' : $_GET['filter'];
  $count = (empty($_GET['count'])) ? 0 : $_GET['count'];
  $condition = '';

  if ($filter != 'all') {
    $condition = ' WHERE works_type="' . $filter . '"';
  }
  
  $sql = 'SELECT works_id, works_type, works_main_image, works_title, works_subtitle, works_task, works_link FROM works' . $condition . ' ORDER BY works_id DESC LIMIT ' . $from . ', ' . $count . ';';
  if ($count === 0) {
    $sql = 'SELECT works_id, works_type, works_main_image, works_title, works_subtitle, works_task, works_link FROM works ORDER BY works_id DESC';
  }

  $res = $mysqli->query($sql);
  if (!$res) {
    header("HTTP/1.0 403 Forbidden");
    die;
  }

  $response = array();
  $i = 0;
  while ($row = $res->fetch_assoc()) {
    $response[$i]['id'] = $row['works_id'];
    $response[$i]['type'] = $row['works_type'];
    $response[$i]['mainImage'] = $row['works_main_image'];
    $response[$i]['title'] = $row['works_title'];
    $response[$i]['subtitle'] = $row['works_subtitle'];
    $response[$i]['task'] = $row['works_task'];
    $response[$i]['link'] = $row['works_link'];
    $i++;
  }

  echo json_encode($response);
?>