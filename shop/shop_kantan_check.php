<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

// Twigを使用するテンプレートの読込み
$loader = new \Twig\Loader\FilesystemLoader('./view');
$twig = new \Twig\Environment($loader);

session_start();
session_regenerate_id(true);

$code = $_SESSION['member_code'];

// DB接続
$dsn = 'mysql:dbname=shop;host=localhost';
$user = 'root';
$password = 'root';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

$sql = 'SELECT name, email ,postal, address, tel FROM dat_member WHERE code = ?';
$stmt = $dbh->prepare($sql);
$data[] = $code;
$stmt->execute($data);
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$dbh = null;

// htmlに渡すデータ
$data = array(
    'title' => '簡単注文',
    'login' => isset($_SESSION['member_login']),
    'onamae' => $rec['name'],
    'email' => $rec['email'],
    'postal' => $rec['postal'],
    'addres' => $rec['address'],
    'tel' => $rec['tel']
);

// テンプレートのレンダリング
echo $twig->render('shop_form_check.html.twig', $data);