<?php

session_start();
session_regenerate_id(true);

require_once '../common/sanitize.php';

$post = sanitize($_POST);

$max = $post['max'];

// 数量変更
for ($i = 0; $i < $max; $i++) {
    if (!preg_match("/^\d+$/", $post["kazu{$i}"])) {
        echo '
            数量に誤りがあります。<br>
            <a href="shop_cartlook.php">カートに戻る</a>
            ';
        exit();
    }
    if ($post["kazu{$i}"] < 1 || 10 < $post["kazu{$i}"]) {
        echo '
            数量は必ず1個以上、10個までです。<br>
            <a href="shop_cartlook.php">カートに戻る</a>
            ';
        exit();
    }

    $kazu[] = $post["kazu{$i}"];
}

// 削除
$cart = $_SESSION['cart'];
for ($i = $max; 0 <= $i; $i--) {
    if (isset($_POST["sakujo{$i}"])) {
        array_splice($cart, $i, 1);
        array_splice($kazu, $i, 1);
    }
}

// Sessionに保存
$_SESSION['cart'] = $cart;
$_SESSION['kazu'] = $kazu;

header('Location:shop_cartlook.php');
exit();