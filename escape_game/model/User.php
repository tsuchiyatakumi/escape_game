<?php
require_once("DB.php");

class User extends DB {

  //ログイン機能
  public function login($arr) {
    $sql = 'SELECT * FROM users WHERE user = :user AND pass = :pass';
    $stmt = $this->connect->prepare($sql);
    $params = array(':user' => $arr['user'], ':pass' => $arr['pass']);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //user登録のメソッド
  public function add($userID) {
    $sql = "INSERT INTO users(user, name, mail, pass, address,  created) VALUES(:user, :name, :mail, :pass, :address,  :created)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user' => $userID['user'],
      ':name' => $userID['name'],
      ':mail' => $userID['mail'],
      ':pass' => $userID['pass'],
      ':address' => $userID['address'],
      // ':role' => 0,
      ':created' => date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }

  //　ユーザー情報の入力チェック
  public function varidate($userID){
    $message = array();
    //ユーザーID
    if(empty($userID['user'])){
      $message['user'] = 'ユーザーIDを入力してください。';
    }else{
      if (!preg_match('/^[a-zA-Z0-9]+$/', $userID['user'])) {
      $message['user'] ='ユーザーIDは半角英数字で入力してください。';
    }
    }
    //ユーザーネーム
    if(empty($userID['name'])){
      $message['name'] = 'ニックネームを入力してください。';
    }
    //メールアドレス
    if(empty($userID['mail'])){
      $message['mail'] = 'メールアドレスを入力してください。';
    }else{
      if(!filter_var($userID['mail'], FILTER_VALIDATE_EMAIL)) {
        $message['mail'] = '正しいメールアドレス形式で入力してください。';
      }
    }
    //パスワード
    if(empty($userID['pass'])){
      $message['pass'] = 'パスワードを入力してください。';
    }else{
      if(strlen($userID['pass']) < 8) {
      $message['pass'] = 'パスワードは８文字以上入力してください。';
    }
    }
    // 所在地
    if(empty($userID['address'])){
      $message['address'] = '所在地を選択してください。';
    }
    return $message;
  }

  //  ユーザー編集処理  編集情報表示
  public function findById($id){
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  // ユーザー編集処理
  public function edit($userID){
    $sql = "UPDATE users SET user = :user, name = :name, mail = :mail, pass = :pass, address = :address
     WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id' => $userID['id'],
      ':user' => $userID['user'],
      ':name' => $userID['name'],
      ':mail' => $userID['mail'],
      ':pass' => $userID['pass'],
      ':address' => $userID['address'],
      // ':role' => 0,
      // ':updated' => date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }

  // ユーザー退会処理
  public function delete($id = null){
    if(isset($id)){
      $sql = "DELETE FROM users WHERE id = :id";
      $stmt = $this->connect->prepare($sql);
      $params = array(':id' => $id);
      $stmt->execute($params);
    }
  }
  //mypage.php　スレッド作成ログ
  public function myThrFind($id) {
    $sql = 'SELECT * FROM threads WHERE user_id = :user_id AND thr_status = 0';
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user_id' => $id,
    );
    $stmt->execute($params);
    $result = $stmt->fetchALL();
    return $result;
  }
    //manage.php  ユーザーリスト
  public function userFind() {
    $sql = 'SELECT id, user, name, user_status FROM users ORDER BY user ASC';
    $stmt = $this->connect->query($sql);
    $stmt->execute();
    $result = $stmt->fetchALL();
    return $result;
  }

  //manage.php ユーザーステータス find
  public function userStatusFind($id) {
    $sql = 'SELECT id, user, name, user_status FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  //manage.php ユーザーステータス
  public function userStatus($userStatusId, $userId) {
    $sql = 'UPDATE users SET user_status = :user_status WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    if($userStatusId == 0) {
      $user_staNow = 1;
    } else if($userStatusId == 1) {
      $user_staNow = 0;
    };
    $params = array(':user_status' => $user_staNow,
                    ':id' => $userId);
    $stmt->execute($params);
  }


  //manege.php スレッド一覧表示
  public function thrFind() {
    $sql = 'SELECT id, title, thr_status FROM threads ORDER BY title ASC';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  //manage.php スレッドステータス find
  public function thrStatusFind($id) {
    $sql = 'SELECT id, title, thr_status FROM threads WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id' => $id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  // //manage.php スレッドステータス
  public function thrStatus($thrStatusId,$threadId) {
    $sql = 'UPDATE threads SET thr_status = :thr_status WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    if($thrStatusId == 0) {
      $thr_staNow = 1;
    } else if($thrStatusId == 1) {
      $thr_staNow = 0;
    };
    $params = array(
      ':thr_status' => $thr_staNow,
      ':id' => $threadId);
    $stmt->execute($params);
  }


}
?>