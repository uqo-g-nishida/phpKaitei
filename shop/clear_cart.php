<?php
require_once 'message_link.php';

session_start();

if (isset($_SESSION["member_login"])) {
    // メンバー
    session_regenerate_id(true);

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'DELETE FROM dat_cart WHERE member_code = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $_SESSION['member_code'];
    $stmt->execute($data);

    $dbh = null;

} else {
    // ゲスト
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}

view_message_link_page(
    'カートを空にしました。',
    'index.php',
    '商品一覧に戻る'
);