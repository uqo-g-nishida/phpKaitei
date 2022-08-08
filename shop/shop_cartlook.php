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
    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

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
    <?php
    for ($i = 0; $i < $max; $i++) {
    ?>
    
    <?= $pro_name[$i] ?>
    <img src='../product/gazou/<?= $pro_gazou_name[$i]?>'>
    <?= $pro_price[$i] ?>円
    <input type="text" name="kazu<?=$i?>" id="<?=$i?>" value="<?= $kazu[$i] ?>">
    <?= $pro_price[$i] * $kazu[$i] ?>円
    <br>
    
    <?php
    }
    ?>

    <input type="hidden" name="max" value="<?= $max ?>">
    <input type="submit" value="数量変更"><br>
    <input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>