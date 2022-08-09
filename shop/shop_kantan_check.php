<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['member_login'])) {
    echo '
        ログインされていません。<br>
        <a href="shop_list.php">商品一覧へ</a>
        ';
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ご購入確認</title>
</head>
<body>

<?php

$code = $_SESSION['member_code'];

// DB接続
$dsn = 'mysql:dbname=shop;host=localhost';
$user = 'root';
$password = 'root';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

$sql = 'SELECT name, email ,postal, address, tel FROM dat_member WHERE code = ?';
$stmt = $dbh->prepare($sql);
$data[] = $code;
$stmt->execute($data);
$rec = $stmt->fetch(PDO::FETCH_ASSOC);

$dbh = null;

$onamae = $rec['name'];
$email = $rec['email'];
$postal = $rec['postal'];
$addres = $rec['address'];
$tel = $rec['tel'];

echo "
    お名前<br>
    {$onamae}<br><br>
    ";

echo "
    メールアドレス<br>
    {$email}<br><br>
    ";

echo "
    郵便番号<br>
    {$postal}<br><br>
    ";

echo "
    住所<br>
    {$addres}<br><br>
    ";

echo "
    電話番号<br>
    {$tel}<br><br>
    ";

?>

<form action="shop_kantan_done.php" method="post">
    <input type="hidden" name="onamae" value="<?= $onamae ?>">
    <input type="hidden" name="email" value="<?= $email ?>">
    <input type="hidden" name="postal" value="<?= $postal ?>">
    <input type="hidden" name="addres" value="<?= $addres ?>">
    <input type="hidden" name="tel" value="<?= $tel ?>">
    <input type="button" value="戻る" onclick="history.back()">
    <input type="submit" value="OK">
</form>

</body>
</html>