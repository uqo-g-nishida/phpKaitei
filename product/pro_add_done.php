<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品追加完了</title>
</head>
<body>

<?php

try {

    $pro_name = $_POST['name'];
    $pro_price = $_POST['price'];

    $pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
    $pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    // データ追加
    $sql = 'INSERT INTO mst_product (name,price) VALUES (?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_name;
    $data[] = $pro_price;
    $stmt->execute($data);

    $dbh = null;

    echo "$pro_name を追加しました。<br>";

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<a href="pro_list.php">戻る</a>

</body>
</html>