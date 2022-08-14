<?php

try {
    require_once '../common/sanitize.php';

    $post = sanitize($_POST);
    $member_email = $post['email'];
    $member_pass = $post['pass'];

    $member_pass = md5($member_pass);

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT code, name FROM dat_member WHERE email = ? AND password = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $member_email;
    $data[] = $member_pass;
    $stmt->execute($data);

    $dbh = null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rec) {
        echo '
            メールアドレスかパスワードが間違っています。<br>
            <a href="member_login.html">戻る</a>
            ';
    } else {
        // セッション作成
        session_start();
        $_SESSION['member_login'] = 1;
        $_SESSION['member_code'] = $rec['code'];
        $_SESSION['member_name'] = $rec['name'];

        header('Location: index.php');
        exit();
    }
} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}