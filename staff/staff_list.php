<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スタッフ一覧</title>
</head>
<body>

<?php

try {
    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = 'SELECT * FROM mst_staff WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    echo '
        <h1>スタッフ一覧</h1><br>
        <form method="post" action="staff_branch.php">
        ';

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$rec) break;

        echo "
            <input type='radio' name='staffcode' value='${rec['code']}'>
            ${rec['code']}
            ${rec['name']}
            <br>
            ";
    }

    echo '
        <input type="submit" name="disp" value="参照">
        <input type="submit" name="add" value="追加">
        <input type="submit" name="edit" value="修正">
        <input type="submit" name="delete" value="削除">
        </form>
        ';

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<a href="../">ホームに戻る</a>

</body>
</html>