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
    <title>ショップ管理トップメニュー</title>
</head>
<body>
<h1>ショップ管理トップメニュー</h1><br>
<br>
<a href="../staff/staff_list.php">スタッフ管理</a><br>
<br>
<a href="../product/pro_list.php">商品管理</a><br>
<br>
<a href="../order/order_download.php">注文ダウンロード</a><br>
<br>
<a href="staff_logout.php">ログアウト</a>
</body>
</html>
