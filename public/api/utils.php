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
?>