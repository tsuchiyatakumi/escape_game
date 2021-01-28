<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    if(!isset($_SESSION['User']) || $_SESSION['User']['role'] != 1) {
      header('location: login.php');
      exit;
    } else {
      $userFindAll = $user->userFind();
      $thrFindAll = $user->thrFind();

      if(!empty($_POST['user_status'])){
        if($_POST) {
          $userStatusFind = $user->userStatusFind($_POST['user_status']);
          $user->userStatus($userStatusFind['user_status'], $userStatusFind['id']);
        }
        $userFindAll = $user->userFind();
      }elseif(!empty($_POST['thr_status'])){
        if($_POST) {
          $thrStatusFind = $user->thrStatusFind($_POST['thr_status']);
          $user->thrStatus($thrStatusFind['thr_status'], $thrStatusFind['id']);
        }
        $thrFindAll = $user->thrFind();
      }
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
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/manage.css">
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
        <p>管理ページ</p>
      </div>
    </div>
    <div id="user_manege">
        <p class="text_sub">ユーザー一覧</p>
        <div id="user_top">
        <?php foreach($userFindAll as $userFind) { ?>
            <div class="user_box">
                <div class="user_name">
                    <p><?php print(htmlspecialchars($userFind['name'])) ?></p>
                    <p id="status">（<?php if($userFind['user_status'] == 0) {
                        print('利用中');
                    } else {
                        print('アカウントロック');
                    } ?>）</p>
                </div>
                <div id="status_btn">
                    <form action="" method="POST">
                    <!-- <input type="hidden" value=<?php print($userFind['user_status']); ?> name="user_status"> -->
                    <input type="hidden" value=<?php print($userFind['id']); ?> name="user_status">
                    <input type="submit"  value="ステータス変更" id="status">
                    </form>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    <div id="thread_manege">
        <p class="text_sub">掲示板タイトル一覧</p>
        <div id="thread_top">
        <?php foreach($thrFindAll as $thrFind) { ?>
            <div class="thread_box">
                <div class="thread_title ">
                    <p><?php print(htmlspecialchars($thrFind['title'],ENT_QUOTES)) ?></p>
                    <p id="status">（<?php if($thrFind['thr_status'] == 0) {
                        print('投稿可能');
                    } else {
                        print('投稿不可');
                    } ?>）</p>
                </div>
                <div id="status_btn">
                    <form action="" method="POST">
                    <input type="hidden" value=<?php print($thrFind['id']); ?> name="thr_status">
                    <input type="submit" value="ステータス変更" id="status">
                    </form>
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