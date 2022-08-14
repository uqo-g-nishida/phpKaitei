<?php

session_start();

if (isset($_SESSION["member_login"])) {
    // メンバー
    session_regenerate_id(true);

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'DELETE FROM dat_cart WHERE member_code = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $_SESSION['member_code'];
    $stmt->execute($data);

    $dbh = null;

} else {
    // ゲスト
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}

?>


<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>カート削除</title>
</head>
<body>
カートを空にしました。<br>

<form>
    <input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>
