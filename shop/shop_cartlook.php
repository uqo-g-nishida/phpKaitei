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
        ようこそ${_SESSION['member_name']}様
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
        echo '
            カートに商品が入っていません。<br>
            <br>
            <a href="index.php">商品一覧に戻る</a>
            ';
        exit();
    }

    foreach ($cart as $key => $val) {

        $sql = 'SELECT * FROM mst_product WHERE code = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $val;
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        $pro_name[] = $rec['name'];
        $pro_price[] = $rec['price'];
        $pro_gazou_name[] = $rec['gazou'];
    }

    $dbh = null;

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<h1>カートの中身</h1>

<form action="kazu_change.php" method="post">
    <table border="1">
        <thead>
        <tr>
            <th>商品</th>
            <th>商品画像</th>
            <th>価格</th>
            <th>数量</th>
            <th>小計</th>
            <th>削除</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < $max; $i++) : ?>
            <tr>
                <input type="hidden" name="cart<?= $i ?>" value="<?= $cart[$i] ?>">
                <td><?= $pro_name[$i] ?></td>
                <td><img src='../product/gazou/<?= $pro_gazou_name[$i] ?>'></td>
                <td><?= $pro_price[$i] ?>円</td>
                <td><input type="text" name="kazu<?= $i ?>" id="<?= $i ?>" value="<?= $kazu[$i] ?>"></td>
                <td><?= $pro_price[$i] * $kazu[$i] ?>円</td>
                <td><input type="checkbox" name="sakujo<?= $i ?>" id="sakujo<?= $i ?>"></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <input type="hidden" name="max" value="<?= $max ?>">
    <input type="submit" value="数量変更"><br>
</form>

<br>
<a href="shop_form.html">ご購入手続きに進む</a><br>

<?php
if (isset($_SESSION["member_login"])) {
    echo '<a href="shop_kantan_check.php">会員かんたん注文に進む</a><br>';
}
?>

<br>
<a href="index.php">一覧に戻る</a>

</body>
</html>