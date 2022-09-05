<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  require_once('./config.php');
  require_once('./utils.php');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $token = $_COOKIE['token'];
  $is_auth = isAuth($mysqli, $token);
  if (!$is_auth['data']['isAuth']) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Access is denied!');
    die(json_encode($answer));
  }

  $id = $mysqli->real_escape_string($_POST['id']);
  $title = $mysqli->real_escape_string($_POST['title']);
  $type = $mysqli->real_escape_string($_POST['type']);
  $subtitle = $mysqli->real_escape_string($_POST['subtitle']);
  $task = $mysqli->real_escape_string($_POST['task']);
  $link = $mysqli->real_escape_string($_POST['link']);

  if (!$id || !$title || !$subtitle || !$type || !$task) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Not enough data!');
    die(json_encode($answer));
  }

  if (count($_FILES['mainImage'])) {
    remove_main_image($mysqli, $id);

    $img_check = check_image($_FILES['mainImage']['name'], $_FILES['mainImage']['tmp_name'], $title);

    if ($img_check['status'] !== 'success') {
      http_response_code(415);
      die(json_encode($img_check));
    }

    $upload_file_status = upload_image($_FILES['mainImage']['name'], $_FILES['mainImage']['tmp_name'], $img_check['data']['real_target_file']);

    if ($upload_file_status['status'] !== 'success') {
      http_response_code(500);
      die(json_encode($upload_file_status));
    }

    $main_image_file = $img_check['data']['target_file'];
  }

  if (count($_FILES['images'])) {
    remove_work_images($mysqli, $id);

    $images_array = array();
    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
      $img_check = check_image($_FILES['images']['name'][$i], $_FILES['images']['tmp_name'][$i], $title, $i + 1);

      if ($img_check['status'] !== 'success') {
        http_response_code(415);
        die(json_encode($img_check));
      }

      $upload_file_status = upload_image($_FILES['images']['name'][$i], $_FILES['images']['tmp_name'][$i], $img_check['data']['real_target_file']);

      if ($upload_file_status['status'] !== 'success') {
        http_response_code(500);
        die(json_encode($upload_file_status));
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
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error insert data in the database!');
    die(json_encode($answer));
  }

  $answer = array('status' => 'success', 'data' => ['updated_work_id' => $id]);
  echo json_encode($answer);
?>
