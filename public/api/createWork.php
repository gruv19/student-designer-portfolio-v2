<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  
  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
  if ($mysqli->connect_errno) {
    $answer = array('status' => 'error', 'message' => 'No access to the database!');
    echo json_encode($answer);
    die;
  }

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    echo json_encode($answer);
    die;
  }
  
  $title = $mysqli->real_escape_string($_POST['title']);
  $type = $mysqli->real_escape_string($_POST['type']);
  $subtitle = $mysqli->real_escape_string($_POST['subtitle']);
  $task = $mysqli->real_escape_string($_POST['task']);
  $link = $mysqli->real_escape_string($_POST['link']);

  if (!$title || !$subtitle || !$type || !$task) {
    $answer = array('status' => 'error', 'message' => 'Not enough data!');
    echo json_encode($answer);
    die;
  }
  
  if (!count($_FILES['mainImage']) || !count($_FILES['images'])) {
    $answer = array('status' => 'error', 'message' => 'Not enough files!');
    echo json_encode($answer);
    die;
  }
  // Upload mainImage

  $img_check = check_image($_FILES['mainImage']['name'], $_FILES['mainImage']['tmp_name'], $title);

  if ($img_check['status'] !== 'success') {
    echo json_encode($img_check);
    die;
  }

  $upload_file_status = upload_image($_FILES['mainImage']['name'], $_FILES['mainImage']['tmp_name'], $img_check['data']['real_target_file']);

  if ($upload_file_status['status'] !== 'success') {
    echo json_encode($upload_file_status);
    die;
  }

  $main_image_file = $img_check['data']['target_file'];
  $images_array = array();

  for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
    $img_check = check_image($_FILES['images']['name'][$i], $_FILES['images']['tmp_name'][$i], $title, $i + 1);

    if ($img_check['status'] !== 'success') {
      echo json_encode($img_check);
      die;
    }

    $upload_file_status = upload_image($_FILES['images']['name'][$i], $_FILES['images']['tmp_name'][$i], $img_check['data']['real_target_file']);

    if ($upload_file_status['status'] !== 'success') {
      echo json_encode($upload_file_status);
      die;
    }
    array_push($images_array, $img_check['data']['target_file']);
  }

  $sql = sprintf("INSERT INTO works (works_type, works_main_image, works_title, works_subtitle, works_task, works_images, works_link) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');", $type, $main_image_file, $title, $subtitle, $task, json_encode($images_array), $link);
  $res = $mysqli->query($sql);
  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error insert data in the database!');
    echo json_encode($answer);
    die;
  }

  $answer = array('status' => 'success', 'data' => ['insert_id' => $mysqli->insert_id]);
  echo json_encode($answer);
?>