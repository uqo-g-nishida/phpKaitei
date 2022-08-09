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
    <title>注文ダウンロード</title>
</head>
<body>

<?php require_once '../common/pulldown.php' ?>

ダウンロードしたい注文日を選んでください。<br>
<form action="order_download_done.php" method="post">
    <?= pulldown_year() ?>年
    <?= pulldown_month() ?>月
    <?= pulldown_day() ?>日
    <input type="submit" value="OK">
</form>

</body>
</html>
