<?php
require_once("DB.php");

class Chat extends DB {

  // ユーザー情報表示
  public function findById($id){
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  // スレッド作成
  public function Thread_add($thread,$thrUser) {
    $sql = 'INSERT INTO threads(title, contents, user_id, created) VALUES(:title, :contents, :user_id, :created);';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':title' => $thread['title'],
      ':contents' => $thread['contents'],
      ':user_id' => $thrUser['id'],
      ':created' => date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }

  // スレッド一覧表示
  public function thrFind() {
    $sql = 'SELECT * FROM threads WHERE thr_status = 0';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  //  スレッドタイトル表示
  public function thrTitleFind($id) {
    $sql = 'SELECT * FROM threads WHERE id = :id ';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $id,
    );
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //  コメント投稿

  public function chatAdd($userAd, $thr) {
    $sql = 'INSERT INTO chats(thread_id, chat, user_id) VALUES(:thread_id, :chat, :user_id)';
    $stmt = $this->connect->prepare($sql);
    $params = array(':thread_id' => $thr,
                    ':chat' => $_POST['chat'],
                    ':user_id' => $userAd);
    $stmt->execute($params);
  }

  //  チャット表示
  public function chatFind($thr) {
    $sql = 'SELECT * FROM chats c, users u WHERE c.user_id=u.id AND c.thread_id = :id ORDER BY c.id';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $thr,
    );
    $stmt->execute($params);
    $result = $stmt->fetchAll();
    return $result;
  }

}
?>
