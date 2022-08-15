<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

// Twigを使用するテンプレートの読込み
$loader = new \Twig\Loader\FilesystemLoader('./view');
$twig = new \Twig\Environment($loader);

session_start();
session_regenerate_id(true);

try {
    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost;';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM mst_product WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    $products = array();

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$rec) break;

        $products[] = [
            'code' => $rec['code'],
            'name' => $rec['name'],
            'price' => $rec['price']
        ];
    }

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

// htmlに渡すデータ
$data = array(
    'title' => '商品一覧',
    'login' => isset($_SESSION['member_login']),
    'member_name' => $_SESSION['member_name'],
    'products' => $products
);

// テンプレートのレンダリング
echo $twig->render('index.html.twig', $data);