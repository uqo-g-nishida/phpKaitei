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
    <title>スタッフ追加</title>
</head>
<body>
<h1>スタッフ追加</h1>
<form method="post" action="staff_add_check.php">
    <label for="name">スタッフ名を入力してください</label><br>
    <input type="text" name="name" id="name" style="width:200px"><br>
    <label for="pass">パスワードを入力してください</label><br>
    <input type="text" name="pass" id="pass" style="width:100px"><br>
    <label for="pass2">パスワードをもう一度入力してください</label><br>
    <input type="text" name="pass2" id="pass2" style="width:100px"><br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>
</body>
</html>