<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

// Twigを使用するテンプレートの読込み
$loader = new \Twig\Loader\FilesystemLoader('./view');
$twig = new \Twig\Environment($loader);

session_start();
session_regenerate_id(true);

try {
    $pro_code = $_GET['procode'];

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM mst_product WHERE code = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    $product = array(
        'code' => $pro_code,
        'name' => $rec['name'],
        'price' => $rec['price'],
        'gazou_name' => $rec['gazou']
    );

    $dbh = null;
} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

// htmlに渡すデータ
$data = array(
    'title' => '商品参照',
    'login' => isset($_SESSION['member_login']),
    'member_name' => $_SESSION['member_name'],
    'product' => $product
);

// テンプレートのレンダリング
echo $twig->render('shop_product.html.twig', $data);