<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

require_once 'message_link.php';

// Twigを使用するテンプレートの読込み
$loader = new \Twig\Loader\FilesystemLoader('./view');
$twig = new \Twig\Environment($loader);

session_start();
session_regenerate_id(true);

try {

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    if (isset($_SESSION["member_login"])) {
        // メンバー
        $sql = 'SELECT * FROM dat_cart WHERE member_code = ?';
        $stmt = $dbh->prepare($sql);
        $data[] = $_SESSION['member_code'];
        $stmt->execute($data);

        $cart = array();
        $kazu = array();

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$rec) break;

            $cart[] = $rec['product_code'];
            $kazu[] = $rec['quantity'];
        }

        $max = count($cart);

    } else {
        // ゲスト
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $kazu = $_SESSION['kazu'];
            $max = count($cart);
        } else {
            $max = 0;
        }
    }

    if ($max == 0) {
        view_message_link_page(
            'カートに商品が入っていません。',
            'index.php',
            '商品一覧に戻る'
        );
        exit();
    }

    $products = array();

    foreach ($cart as $i => $val) {

        $sql = 'SELECT * FROM mst_product WHERE code = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $val;
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $products[] = [
            'cart' => $val,
            'name' => $rec['name'],
            'gazou_name' => $rec['gazou'],
            'price' => $rec['price'],
            'kazu' => $kazu[$i]
        ];
    }

    $dbh = null;

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

// htmlに渡すデータ
$data = array(
    'title' => 'カートの中身',
    'login' => isset($_SESSION['member_login']),
    'member_name' => $_SESSION['member_name'],
    'products' => $products,
    'products_max' => $max
);

// テンプレートのレンダリング
echo $twig->render('shop_cartlook.html.twig', $data);