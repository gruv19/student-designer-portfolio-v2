<?php
function is_auth($mysqli, $token) {
  $sql = "SELECT users_id FROM users WHERE users_token='$token' AND users_token_expire_date > NOW();";
  $res = $mysqli->query($sql);

  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error request data from the database!');
    return $answer;
  }

  $row = $res->fetch_assoc();

  if (!$row) {
    $answer = array('status' => 'fail', 'data' => ['isAuth' => false]);
    return $answer;
  }

  $answer = array('status' => 'success', 'data' => ['isAuth' => true]);
  return $answer;
}

function check_image($img_name, $img_tmp_name, $work_title, $catalog = 0) {
  $target_dir = '/' . 'work_images';
  $real_target_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . 'work_images';
  $image_title = md5($work_title);
  if ($catalog > 0) {
    $target_dir = $target_dir . '/' . $image_title;
    $real_target_dir = $real_target_dir . '/' . $image_title;
    if (!is_dir($real_target_dir)) {
      mkdir($real_target_dir, 0777);
    }
  }
  $image_file_type = strtolower(pathinfo($target_dir . '/' . basename($img_name), PATHINFO_EXTENSION));
  $target_file = $target_dir . '/' . $image_title . '.' . $image_file_type;
  $real_target_file = $real_target_dir . '/' . $image_title . '.' . $image_file_type;
  if ($catalog > 0) {
    $target_file = $target_dir . '/' . $image_title . $catalog . '.' . $image_file_type;
    $real_target_file = $real_target_dir . '/' . $image_title . $catalog . '.' . $image_file_type;
  }
  $check = getimagesize($img_tmp_name);
  if(!$check) {
    $answer = array('status' => 'error', 'message' => 'File is not image!');
    return $answer;
  }
  if ($_FILES['mainImage']['size'] > 500000) {
    $answer = array('status' => 'error', 'message' => 'File is too large!');
    return $answer;
  }
  if ($image_file_type !== 'jpg' && $image_file_type != 'jpeg') {
    $answer = array('status' => 'error', 'message' => 'Only JPG, JPEG images are allowed!');
    return $answer;
  }
  $answer = array(
    'status' => 'success',
    'data' => [
      'image_title' => $image_title,
      'image_file_type' => $image_file_type,
      'target_file' => $target_file,
      'real_target_file' => $real_target_file
    ]);
  return $answer;
}

function upload_image($img_name, $img_tmp_name, $target_file) {
  if (move_uploaded_file($img_tmp_name, $target_file)) {
    $answer = array('status' => 'success', 'data' => ['message' => 'The file ' . $img_name . ' has been uploaded.']);
    return $answer;
  } else {
    $answer = array('status' => 'error', 'message' => 'There was an error uploading your file ' . $img_name);
    return $answer;
  }
}

function remove_file($file) {
  $answer = array('status' => 'error', 'message' => 'Problem with deleting file - ' . $file);
  if (file_exists($file)) {
    $res = unlink($file);
    if ($res) {
      $answer = array('status' => 'success', 'data' => ['message' => 'The file ' . $file . ' has been deleted.']);
    }
  }
  return $answer;
}

function remove_main_image($mysqli, $id) {
  $sql = "SELECT works_main_image FROM works WHERE works_id = $id;";
  $res = $mysqli->query($sql);
  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error request data from the database!');
    return $answer;
  }
  $row = $res->fetch_assoc();
  $file = $_SERVER['DOCUMENT_ROOT'] . str_replace(BACKEND_HOST, "", $row['works_main_image']);
  return remove_file($file);
}

function remove_work_images($mysqli, $id) {
  $sql = "SELECT works_images FROM works WHERE works_id = $id;";
  $res = $mysqli->query($sql);
  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error request data from the database!');
    return $answer;
  }
  $row = $res->fetch_assoc();
  $images = json_decode($row['works_images']);
  $results = array();
  for ($i = 0; $i < count($images); $i++) {
    // $file = $_SERVER['DOCUMENT_ROOT'] . $images[$i];
    $file = $_SERVER['DOCUMENT_ROOT'] . str_replace(BACKEND_HOST, "", $images[$i]);
    remove_file($file);
  }
  $answer = array('status' => 'success', 'data' => ['message' => 'The files have been deleted.']);
  return $answer;
}

function db_connect($db_server, $db_user, $db_password, $db_name) {
  $mysqli = @new mysqli($db_server, $db_user, $db_password, $db_name);
  if ($mysqli->connect_errno) {
    http_response_code(503);
    $answer = array('status' => 'error', 'message' => 'No access to the database!');
    die(json_encode($answer));
  }
  return $mysqli;
}
?>
