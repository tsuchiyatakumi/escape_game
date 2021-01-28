<?php
session_start();

require_once("../config/config.php");
require_once("../model/Chat.php");

try {
    $chat = new Chat($host, $dbname, $user, $pass);
    $chat->connectDb();

    if(!isset($_SESSION['User']) ) {
      header('location: login.php');
      exit;
    } else{
      if($_POST){
          if(empty($_POST['title'] && $_POST['contents'])) {
            $message = '未入力な項目があります。';
          } else {
            $chat->Thread_add($_POST,$_SESSION['User']);
            header('location: home.php');
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
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/chat.css">
</head>
<body class="home">
  <header>
    <div class="header_btn" id="header_1">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div id="wrapper">
    <div class="text">
        <div class="main">
            <img id="join_logo" src="../img/join.png" alt="脱出ロゴ">
            <p>スレッド作成</p>
        </div>
    </div>
    <div class="chat_area">
    <form action="" method="POST">
      <div class="text_sub">
        <p>-タイトル-</p>
      </div>
      <input type="text" placeholder="(例)◯◯ゲームに参加したい人募集部屋" id="title" name="title">
      <div class="contents">
        <div class="text_sub">
          <p>-内容-</p>
        </div>
        <textarea id="contents" name="contents"></textarea>
        <div class="error">
          <?php if(isset($message)) echo "<p class='error'>".$message ?>
        </div>
      </div>
      <input class="done_btn" id="add_btn" type="submit" value="投稿開始">
    </form>
    </div>
</div>
  <?php
  require ("../model/footer.php");
  ?>
</body>
</html>
