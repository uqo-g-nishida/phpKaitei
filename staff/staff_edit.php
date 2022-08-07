<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スタッフ編集</title>
</head>
<body>

<?php

try {
    $staff_code = $_GET['staffcode'];

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM mst_staff WHERE code = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name = $rec['name'];
    $dbh = null;
} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<h1>スタッフ修正</h1><br>
スタッフコード：<?= $staff_code ?><br>
<form method="post" action="staff_edit_check.php">
    <input type="hidden" name="code" value="<?= $staff_code ?>"><br>
    <label for="name">スタッフ名</label><br>
    <input type="text" name="name" id="name" value="<?= $staff_name ?>"><br>
    <label for="pass">パスワードを入力してください</label><br>
    <input type="text" name="pass" id="pass"><br>
    <label for="pass2">パスワードをもう一度入力してください</label><br>
    <input type="text" name="pass2" id="pass2"><br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
</form>

</body>
</html>