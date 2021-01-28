<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if(isset($_GET['logout'])) {
    $_SESSION = array();
    session_destroy();
  }

  if(!isset($_SESSION['User'])) {
    header('location: login.php');
    exit;
  }else{
    $myUserId = $_SESSION['User']['id'];
    $userName = $user->findById($myUserId);
    $myThrFindAll = $user->myThrFind($myUserId);
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
    <title>自作PHP</title>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <script type="text/javascript" src="../JS/jquery.js"></script>
  <script type="text/javascript" src="../JS/home.js"></script>
</head>
<body class="home">
<header>
  <?php if($_SESSION['User']['role'] == 1) { ?>
  <div class="header_btn" id="header_1">
    <a href="manage.php">管理ページ</a>
  </div>
  <?php } ?>
  <div class="header_btn" id="header_2">
    <a href="home.php">ホームへ</a>
  </div>
  <div class="header_btn" id="header_1">
      <a href="?logout=1">ログアウト</a>
  </div>
</header>
<div id="wrapper">
    <div class="text">
      <p><?php print(htmlspecialchars($userName['name'],ENT_QUOTES)) ?>　さんの My Page</p><br>
    </div>
    <div id="edit">
      <div class="done_btn">
        <a href="edit.php?edit=<?=$_SESSION['User']['id']?>">登録内容の編集</a>
      </div>
    </div>
    <div id="user_area">
      <h4 id="user">ユーザーID：<?php print(htmlspecialchars($userName['user'],ENT_QUOTES)) ?></h4>
      <h4 id="address">所在地：<?php print(htmlspecialchars($userName['address'],ENT_QUOTES)) ?></h4>
      <div class="thread_area">
        <h4>-　<?php print(htmlspecialchars($userName['name'],ENT_QUOTES)) ?>　さんの スレッド作成ログ-</h4>
        <?php foreach($myThrFindAll as $myThrFind) { ?>
        <div class="thread top">
          <div class="thread_title ">
            <p><?php print(htmlspecialchars($myThrFind['title'],ENT_QUOTES)) ?></p>
          </div>
          <div class="thread_content down">
            <p><?php print(htmlspecialchars($myThrFind['contents'],ENT_QUOTES)) ?></p>
            <div class="thread_join">
              <form action="bulletin_board.php" method="POST">
                <input type="hidden" name="thr" value="<?php print(htmlspecialchars($myThrFind['id'],ENT_QUOTES)); ?>">
                <input class="done_btn" id="join" type="submit" value="スレッドに参加">
              </form>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
</div>
<?php
  require ("../model/footer.php");
?>
</body>
</html>