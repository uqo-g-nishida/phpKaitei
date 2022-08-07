<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品編集</title>
</head>
<body>

<?php

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
    $pro_name = $rec['name'];
    $pro_price = $rec['price'];
    $pro_gazou_name_old = $rec['gazou'];
    $dbh = null;
} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<h1>商品修正</h1><br>
商品コード：<?= $pro_code ?><br>
<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
    <input type="hidden" name="code" value="<?= $pro_code ?>"><br>
    <input type="hidden" name="gazou_name_old" value="<?= $pro_gazou_name_old ?>"><br>
    <label for="name">商品名</label><br>
    <input type="text" name="name" id="name" value="<?= $pro_name ?>"><br>
    <label for="price">価格を入力してください</label><br>
    <input type="text" name="price" id="price" value="<?= $pro_price ?>"><br>
    <img src="<?= "./gazou/${pro_gazou_name_old}" ?>"><br>
    <input type="file" name="gazou" id="gazou"><br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>

</body>
</html>