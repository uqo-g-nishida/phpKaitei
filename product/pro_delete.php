<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    echo '
        ログインされていません。<br>
        <a href="../staff_login/staff_login.html">ログイン画面へ</a>
        ';
    exit();
} else {
    echo "${_SESSION['staff_name']}さんログイン中<br>";
}
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品削除</title>
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
    $pro_gazou_name = $rec['gazou'];
    $dbh = null;
} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<h1>商品削除</h1><br>
商品コード：<?= $pro_code ?><br>
商品名：<?= $pro_name ?><br>
<img src="<?= "./gazou/${pro_gazou_name}" ?>"><br>
この商品を削除してもよろしいですか？<br>

<form method="post" action="pro_delete_done.php">
    <input type="hidden" name="code" value="<?= $pro_code ?>"><br>
    <input type="hidden" name="gazou_name" value="<?= $pro_gazou_name ?>"><br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>

</body>
</html>