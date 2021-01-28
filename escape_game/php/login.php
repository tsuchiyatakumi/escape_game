<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if($_POST) {
    $result = $user->login($_POST);
    if($_POST){
      if(empty($_POST['user'] && $_POST['pass'])) {
        $message = '未入力な項目があります。';
      } else {
        if(!empty($result)) {
          $_SESSION['User'] = $result;
          if($_SESSION['User']['user_status'] == 0) {
            header('Location: home.php');
            exit;
          }else{
            $_SESSION = array();
            $message = 'アカウントがロックされています。';
          }
        } else {
          $message = '該当するアカウントがありません。';
        }
      }
    }
  }
}catch (PDOException $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP自作</title>
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link rel="stylesheet" type="text/css" href="../css/login.css">
<body>
<div id="wrapper">
<div id="login">
  <p id="login-p">ユーザー名、パスワードを入力してください</p>
  <form action="" method="POST">
    <dl>
     <dt class="user">ユーザー名:
     <input id="user" type="text" name="user" value=""></dt>
     <dt class="pass">パスワード:
     <input id="pass" type="password" name="pass" value=""></dt>
   </dl>
  <div class="error">
    <?php if(isset($message)) echo "<p class='error'>".$message ?>

  </div>
  <input id="btn" type ="submit" name ="log-btn" value="ログイン">

  </form>
  <a href="signup.php">新規登録はこちら</a>


<?php
  require ("../model/footer.php");
?>
</div>
</div>
</body>
</head>
</html>