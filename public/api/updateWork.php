<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = @new mysqli(DBSERVER, DBUSER, DBPASSWORD, DBNAME);
  if ($mysqli->connect_errno) {
    http_response_code(503);
    $answer = array('status' => 'error', 'message' => 'No access to the database!');
    die(json_encode($answer));
  }

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    echo json_encode($answer);
    die;
  }

  $id = $mysqli->real_escape_string($_POST['id']);
  $title = $mysqli->real_escape_string($_POST['title']);
  $type = $mysqli->real_escape_string($_POST['type']);
  $subtitle = $mysqli->real_escape_string($_POST['subtitle']);
  $task = $mysqli->real_escape_string($_POST['task']);
  $link = $mysqli->real_escape_string($_POST['link']);

  if (!$id || !$title || !$subtitle || !$type || !$task) {
    $answer = array('status' => 'error', 'message' => 'Not enough data!');
    die(json_encode($answer));
  }

  if (count($_FILES['mainImage'])) {
    remove_main_image($mysqli, $id);

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
  }

  if (count($_FILES['images'])) {
    remove_work_images($mysqli, $id);

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

  }

  $sql = "UPDATE works SET works_type='$type', works_title='$title', works_subtitle='$subtitle', works_task='$task'";

  if (isset($main_image_file)) {
    $sql = $sql . ", works_main_image='$main_image_file'";
  }

  if (isset($images_array)) {
    $sql = $sql . ", works_images='" . json_encode($images_array) . "'";
  }

  $sql = $sql . " WHERE works_id=$id";

  $res = $mysqli->query($sql);
  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error insert data in the database!');
    echo json_encode($answer);
    die;
  }

  $answer = array('status' => 'success', 'data' => ['updated_work_id' => $id]);
  echo json_encode($answer);

?>
