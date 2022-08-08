<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['member_login']) == false) {
    echo '
        ようこそゲスト様
        <a href="member_login.html">会員ログイン</a><br>
        <br>
        ';
} else {
    echo "
        ようこそ${_SESSION['staff_name']}様
        <a href='member_logout.php'>ログアウト</a><br>
        <br>
        ";
}
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品参照</title>
</head>
<body>

<?php

try {

    $pro_code = $_GET['procode'];

    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
        $kazu = $_SESSION['kazu'];
        if (in_array($pro_code, $cart)) {
            echo '
                その商品はすでにカートに入っています。<br>
                <a href="shop_list.php">商品一覧に戻る</a>
                ';
            exit();
        }
    }
    $cart[] = $pro_code;
    $kazu[] = 1;
    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

カートに追加しました。<br>
<br>
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>