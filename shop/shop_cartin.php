<?php
require_once 'message_link.php';

session_start();
session_regenerate_id(true);

try {

    $pro_code = $_GET['procode'];

    if (isset($_SESSION["member_login"])) {
        // メンバー
        // DB接続
        $dsn = 'mysql:dbname=shop;host=localhost';
        $user = 'root';
        $password = 'root';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->query('SET NAMES utf8');

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

        if (in_array($pro_code, $cart)) {
            view_message_link_page(
                'その商品はすでにカートに入っています。',
                'index.php',
                '商品一覧に戻る'
            );
            $dbh = null;
            exit();
        }

        $sql = 'INSERT INTO dat_cart(member_code, product_code, quantity) VALUES (?, ?, ?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = $_SESSION['member_code'];
        $data[] = $pro_code;
        $data[] = '1';
        $stmt->execute($data);

        $dbh = null;
    } else {
        // ゲスト
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $kazu = $_SESSION['kazu'];
        }

        if (in_array($pro_code, $cart)) {
            view_message_link_page(
                'その商品はすでにカートに入っています。',
                'index.php',
                '商品一覧に戻る'
            );
            exit();
        }

        $cart[] = $pro_code;
        $kazu[] = 1;
        $_SESSION['cart'] = $cart;
        $_SESSION['kazu'] = $kazu;
    }

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

view_message_link_page(
    '商品をカートに追加しました。',
    'index.php',
    '商品一覧に戻る'
);