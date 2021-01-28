<?php
session_start();

require_once("../config/config.php");
require_once("../model/Chat.php");
try {
    // MySQLへの接続
    $chat = new Chat($host, $dbname, $user, $pass);
    $chat->connectDb();

    if(!isset($_SESSION['User'])) {
      header('location: login.php');
      exit;
    } else {
      if(!empty($_POST['thr'])) {
        $_SESSION['thr'] = $_POST['thr'];
        $thrTitleFind = $chat->thrTitleFind($_SESSION['thr']);
        $chatFindAll = $chat->chatFind($_SESSION['thr']);
      }

      if($_POST) {
        if(empty($_POST['chat'])) {
          $message = 'チャットが書かれていません。';

        } else {
          $chat->chatAdd($_SESSION['User']['id'], $_SESSION['thr']);
          header('Location: ./bulletin_board.php');
        }
      }
        $chatFindAll = $chat->chatFind($_SESSION['thr']);
        $thrTitleFind = $chat->thrTitleFind($_SESSION['thr']);

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
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/chat.css">
  <script type="text/javascript" src="../JS/jquery.js"></script>
  <script type="text/javascript">
    function dojQueryAjax() {
      $.ajax({
        type: "GET",
        url: "bulletin_board.php",
        cache: false,
        success: function (data) {
          $('#ajaxreload').load(data);
        },
        error: function () {
          alert("Ajax通信エラー");
        }
      });
    }
    window.addEventListener('load', function () {
      setInterval(dojQueryAjax, 5000);
    });
  </script>
</head>
<body class="home">
  <header>
    <div class="header_btn" id="header_1">
      <a href="mypage.php">マイページへ</a>
    </div>
    <div class="header_btn" id="header_2">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="text">
      <div class="main">
        <img id="join_logo" src="../img/join.png" alt="脱出ロゴ">
        <p>チャットエリア</p>
      </div>
    </div>
    <div class="chat_area">
      <div class="text_sub">
        <p>-タイトル-</p>
      </div>
      <p id="title"><?php print(htmlspecialchars($thrTitleFind['title'],ENT_QUOTES)); ?></p>
      <div class="text_sub">
        <p>-内容-</p>
      </div>
      <p id="contents"><?php print(htmlspecialchars($thrTitleFind['contents'],ENT_QUOTES)); ?></p>

      <div class="text_sub">
        <p>-チャット-</p>
      </div>
      <div class="chat" id="ajaxreload">
      <!-- チャットの表示 -->
      <?php foreach($chatFindAll as $chatFind) {?>
        <div class="chat_<?php if($_SESSION['User']['id'] == $chatFind['user_id']) { print('right');} else { print('left');} ?>">
          <div class="chat_name"><?php print(htmlspecialchars($chatFind['name'],ENT_QUOTES)); ?></div>
          <div class="chat_inner">
            <div class="chat_contents"><?php print(htmlspecialchars($chatFind['chat'],ENT_QUOTES)); ?></div>
            <div class="chat_time"><?php print(htmlspecialchars($chatFind['time'],ENT_QUOTES)); ?></div>
          </div>
        </div>
      <?php } ?>
      </div>
      <!-- チャットの投稿部分 -->
      <form class="chat_add" action="" method="POST">
        <textarea class="chat_text" name="chat"></textarea>
        <input type="submit" class="chat_btn">
      </form>
      <div class="error">
        <?php if(isset($message)) echo "<p class='error'>".$message ?>
      </div>

    </div>
  </div>
  <?php
  require ("../model/footer.php");
  ?>
</body>
</html>
