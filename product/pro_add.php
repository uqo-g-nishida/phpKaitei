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
    <title>商品追加</title>
</head>
<body>
<h1>商品追加</h1>
<form method="post" action="pro_add_check.php" enctype="multipart/form-data">
    <label for="name">商品名を入力してください</label><br>
    <input type="text" name="name" id="name"><br>
    <label for="price">価格を入力してください</label><br>
    <input type="text" name="price" id="price"><br>
    <label for="gazou">画像を選択してください</label><br>
    <input type="file" name="gazou" id="gazou"><br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>