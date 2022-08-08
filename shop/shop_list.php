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
    <title>商品一覧</title>
</head>
<body>

<?php

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

    echo '
        <h1>商品一覧</h1><br>
        ';

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$rec) break;

        echo "
            <a href='shop_product.php?procode={$rec['code']}'>
            ${rec['code']}
            ${rec['name']}
            ${rec['price']}
            </a>
            <br>
            ";
    }

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<br>
<a href="shop_cartlook.php">カートを見る</a><br>
<br>
<a href="../staff_login/staff_top.php">ホームに戻る</a>

</body>
</html>