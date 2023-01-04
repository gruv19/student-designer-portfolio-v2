<?php
  require_once('./config.php');
  require_once('./utils.php');

  header('Access-Control-Allow-Origin: ' . FRONTEND_HOST);
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Content-Type: application/json');

  $mysqli = db_connect(DBSERVER, DBUSER, DBPASSWORD, DBNAME);

  $_POST = json_decode(file_get_contents("php://input"), true);
  $email = $mysqli->real_escape_string($_POST['email']);
  $password = $mysqli->real_escape_string($_POST['password']);
  $password = crypt(md5($password), SAULT);

  $is_auth = is_auth($mysqli, $token);

  if ($is_auth['data']['isAuth']) {
    http_response_code(403);
    $answer = array('status' => 'error', 'message' => 'Already logged');
    die(json_encode($answer));
  }

  $sql = "SELECT users_id, users_email FROM users WHERE users_email='$email' AND users_password='$password';";
  $res = $mysqli->query($sql);

  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error request data from the database!');
    die(json_encode($answer));
  }

  $row = $res->fetch_assoc();

  if (!$row) {
    http_response_code(401);
    $answer = array('status' => 'error', 'message' => 'Invalid email or password');
    die(json_encode($answer));
  }

  $id = $row['users_id'];
  $token = bin2hex(random_bytes(8));
  $time = time() + 3600 * 24 * 9;
  $token_expire_date = date('Y-m-d H:i:s', $time);
  $sql = "UPDATE users SET users_token='$token', users_token_expire_date='$token_expire_date' WHERE users_id=$id;";

  $res = $mysqli->query($sql);

  if (!$res) {
    http_response_code(500);
    $answer = array('status' => 'error', 'message' => 'Error update data in the database!');
    die(json_encode($answer));
  }

  $answer = array('status' => 'succes', 'data' => ['users_id' => $id, 'users_token' => $token, 'users_email' => $email, 'users_token_expire_date' => $token_expire_date]);
  echo json_encode($answer);
?>
