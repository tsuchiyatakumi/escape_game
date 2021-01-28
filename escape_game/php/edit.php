<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

if(!isset($_SESSION['User'])) {
  header('location: login.php');
  exit;
}

try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();


  if(isset($_GET['edit'])){
    $result['User'] = $user->findById($_GET['edit']);
    if($_POST){
      $message = $user->varidate($_POST);
      if(empty($message['user']) && empty($message['name']) && empty($message['mail']) && empty($message['pass']) && empty($message['address'])){
        $user->edit($_POST);
        header('location: mypage.php');
      }
    }

  }

  $db = null;
  $sth = null;
} catch (PDOException $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PHP自作</title>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../css/base.css">
</head>
<body class="home">
<header>
  <?php if($_SESSION['User']['role'] == 1) { ?>
  <div class="header_btn" id="header_2">
    <a href="manage.php">管理ページ</a>
  </div>
  <?php } ?>
  <div class="header_btn" id="header_1">
    <a href="mypage.php">マイページへ</a>
  </div>
  <div class="header_btn" id="header_2">
      <a href="home.php">ホームへ</a>
  </div>
</header>
<div id="wrapper">
  <div class="text">
    <div class="main">
      <img id="join_logo" src="../img/join.png" alt="脱出ロゴ">
      <p><?php print(htmlspecialchars($_SESSION['User']['name'],ENT_QUOTES)) ?>　さんの</p>
    </div>
    <p id="edit_text">登録内容編集</p>
  </div>
    <div id="user_area">
      <div id="edit_area">
       <form action="" method="POST">
        <dl>
         <dt class="user">ユーザー名:
         <input id="user" type="text" name="user" value="<?php if(isset($result['User'])) echo $result['User']['user'] ?>"></dt>
         <dt class="name">ニックネーム:
         <input id="name" type="text" name="name" value="<?php if(isset($result['User'])) echo $result['User']['name'] ?>"></dt>
         <dt class="mail">メールアドレス:
         <input id="mail" type="text" name="mail" value="<?php if(isset($result['User'])) echo $result['User']['mail'] ?>"></dt>
         <dt class="pass">パスワード:
         <input id="pass" type="text" name="pass" value="<?php if(isset($result['User'])) echo $result['User']['pass'] ?>"></dt>
         <dt class="address">所在地:
         <?php
         require ("../model/address.php");
         ?>
         </dt>
         <input type="hidden" name="id" value="<?php if(isset($result['User'])) echo $result['User']['id'] ?>">
       </dl>
       <div class="error">
       <?php if(isset($message['user'])) echo "<p class='error'>".$message['user'] ?>
       <?php if(isset($message['name'])) echo "<p class='error'>".$message['name']?>
       <?php if(isset($message['mail'])) echo "<p class='error'>".$message['mail'] ?>
       <?php if(isset($message['pass'])) echo "<p class='error'>".$message['pass'] ?>
       <?php if(isset($message['address'])) echo "<p class='error'>".$message['address'] ?>
       </div>
       <input class="done_btn" id="edit_btn" type ="submit" name ="t-btn" value="保存する">
       </form>
       <a href="delete.php">退会する</a>
      </div>
  </div>
  <?php
  require ("../model/footer.php");
?>
</div>

</body>
</html>