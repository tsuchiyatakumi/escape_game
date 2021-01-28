<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    // if(!isset($_SESSION['User'])) {
    //   header('location: login.php');
    //   exit;
    // } else {
      if($_POST){
        $message = $user->varidate($_POST);
        if(empty($message['user']) && empty($message['name']) && empty($message['mail']) && empty($message['pass']) && empty($message['address'])){
          $user->add($_POST);
          header('location: login.php');
        }
      }
    // }
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/base.css">
  </head>
  <body>
  <div id="wrapper">
  <div id="login">
    <p id="login-p">新規登録画面</p>
    <form action="" method="POST">
      <dl>
       <dt class="user">ユーザー名:
       <input id="user" type="text" name="user" value=""></dt>
       <dt class="name">ニックネーム:
       <input id="name" type="text" name="name" value=""></dt>
       <dt class="mail">メールアドレス:
       <input id="mail" type="text" name="mail" value=""></dt>
       <dt class="pass">パスワード:
       <input id="pass" type="password" name="pass" value=""></dt>
       <dt class="address">所在地:
       <?php
       require ("../model/address.php");
       ?>
       </dt>
     </dl>
     <div class="error">
     <?php if(isset($message['user'])) echo "<p class='error'>".$message['user'] ?>
     <?php if(isset($message['name'])) echo "<p class='error'>".$message['name']?>
     <?php if(isset($message['mail'])) echo "<p class='error'>".$message['mail'] ?>
     <?php if(isset($message['pass'])) echo "<p class='error'>".$message['pass'] ?>
     <?php if(isset($message['address'])) echo "<p class='error'>".$message['address'] ?>
     </div>
     <input id="btn" type ="submit" name ="t-btn" value="登録">
    </form>
  <?php
  require ("../model/footer.php");
  ?>
  </div>
  </div>
  </body>
</html>
