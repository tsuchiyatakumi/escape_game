<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if(isset($_GET['del'])){
    $user->delete($_GET['del']);
  }

  if(!isset($_SESSION['User'])) {
    header('location: login.php');
    exit;
  } else {
    $myUserId = $_SESSION['User']['id'];
    $userName = $user->findById($myUserId);
  }
}catch (PDOException $e) {
  echo "接続失敗: " . $e->getMessage() . "\n";
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PHP自作</title>
    <link rel="stylesheet" type="text/css" href="../css/delete.css">
    <link rel="stylesheet" type="text/css" href="../css/base.css">
</head>
<body>
<div id="wrapper">
    <img id="logo" src="../img/mainlogo.png" alt="メインロゴ">

    <div id="delete_top">
        <img id="delete_logo" src="../img/delete.png" alt="退会ロゴ">
        <p id="delete_p">退会のお手続き</p>
    </div>
    <div id="delete">
    <h1 class="text"><?php print(htmlspecialchars($userName['name'],ENT_QUOTES)) ?>　さん</h1>
    <p>本当に退会されますか？</p>
        <a href="delete_end.php?del=<?=$_SESSION['User']['id']?>"><span>退会する</span>
        </a><br><br>
        <a href="mypage.php">My Pageへ戻る</a>
    </div>
</div>
<?php
  require ("../model/footer.php");
?>
</body>
</html>