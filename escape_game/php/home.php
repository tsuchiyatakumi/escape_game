<?php
session_start();

require_once("../config/config.php");
require_once("../model/Chat.php");
try {
    // MySQLへの接続
  $chat = new Chat($host, $dbname, $user, $pass);
  $chat->connectDb();

  if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
  }

  if(!isset($_SESSION['User'])) {
    header('location: login.php');
    exit;
  } else {
    $myUserId = $_SESSION['User']['id'];
    $userName = $chat->findById($myUserId);
    $thrFindAll = $chat->thrFind();
  }
  $db = null;
  $sth = null;
} catch (PDOException $e) {
    print "エラー!: " . $e->getMessage() . "<br/gt;";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>PHP自作</title>
  <link rel="stylesheet" type="text/css" href="../css/home.css">
  <link rel="stylesheet" type="text/css" href="../css/base.css">
  <script type="text/javascript" src="../JS/jquery.js"></script>
  <script type="text/javascript" src="../JS/home.js"></script>
</head>
<body class="home">
<header>
  <div class="header_btn" id="header_1">
    <a href="mypage.php">マイページへ</a>
  </div>
  <div class="header_btn" id="header_2">
      <a href="?logout=1">ログアウト</a>
  </div>
</header>
<div id="wrapper">
  <div class="text">
    <p>ようこそ　<?php print(htmlspecialchars($userName['name'],ENT_QUOTES)) ?>　さん</p>
    <div class="main">
      <img id="join_logo" src="../img/join.png" alt="脱出ロゴ">
      <p>掲示板一覧</p>
    </div>
  </div>
  <div class="board_top">
      <div class="done_btn">
        <a href="thread.php">スレッド作成する</a>
      </div>
  </div>
  <div class="bulletin_area">
    <p> 掲示板タイトル一覧</p>
    <?php foreach($thrFindAll as $thrFind) { ?>
    <div class="thread top">
      <div class="thread_title ">
        <p><?php print(htmlspecialchars($thrFind['title'],ENT_QUOTES)) ?></p>
      </div>
      <div class="thread_content down">
        <p><?php print(htmlspecialchars($thrFind['contents'],ENT_QUOTES)) ?></p>
        <div class="thread_join">
          <form action="bulletin_board.php" method="POST">
            <input type="hidden" name="thr" value="<?php print(htmlspecialchars($thrFind['id'],ENT_QUOTES)); ?>">
            <input class="done_btn" id="join" type="submit" value="スレッドに参加">
          </form>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<?php
  require ("../model/footer.php");
?>
</body>
</html>
