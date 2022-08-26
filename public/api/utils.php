<?php 
function isAuth($mysqli, $token) {
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
?>