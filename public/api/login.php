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
  if ($is_auth['data']['isAuth']) {
    $answer = array('status' => 'error', 'message' => 'Already logged');
    echo json_encode($answer);
    die;
  }

  $_POST = json_decode(file_get_contents("php://input"), true);
  $email = $mysqli->real_escape_string($_POST['email']);
  $password = $mysqli->real_escape_string($_POST['password']);
  $password = crypt(md5($password), SAULT);

  $sql = "SELECT users_id, users_email FROM users WHERE users_email='$email' AND users_password='$password';";
  $res = $mysqli->query($sql);

  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error request data from the database!');
    echo json_encode($answer);
    die;
  }

  $row = $res->fetch_assoc();

  if (!$row) {
    $answer = array('status' => 'error', 'message' => 'Invalid email or password');
    echo json_encode($answer);
    die;    
  }

  $id = $row['users_id'];
  $token = bin2hex(random_bytes(8));
  $time = time() + 3600 * 24 * 9;
  $token_expire_date = date('Y-m-d H:i:s', $time);
  $sql = "UPDATE users SET users_token='$token', users_token_expire_date='$token_expire_date' WHERE users_id=$id;";

  $res = $mysqli->query($sql);

  if (!$res) {
    $answer = array('status' => 'error', 'message' => 'Error update data in the database!');
    echo json_encode($answer);
    die;
  }

  $answer = array('status' => 'succes', 'data' => ['users_id' => $id, 'users_token' => $token, 'users_email' => $email, 'users_token_expire_date' => $token_expire_date]);
  setcookie('token', $token, $time);
  echo json_encode($answer);
?>