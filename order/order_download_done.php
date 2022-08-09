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

<?php

try {

    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];

    // DB接続
    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $sql = '
        SELECT
            dat_sales.code,
            dat_sales.date,
            dat_sales.code_member,
            dat_sales.name AS dat_sales_name,
            dat_sales.email,
            dat_sales.postal,
            dat_sales.address,
            dat_sales.tel,
            dat_sales_product.code_product,
            mst_product.name AS mst_product_name,
            dat_sales_product.price,
            dat_sales_product.quantity
        FROM
            dat_sales,dat_sales_product,mst_product
        WHERE dat_sales.code = dat_sales_product.code_sales
        AND dat_sales.code = dat_sales_product.code_sales
        AND substr(dat_sales.date,1,4) = ?
        AND substr(dat_sales.date,6,2) = ?
        AND substr(dat_sales.date,9,2) = ?
        ';
    $stmt = $dbh->prepare($sql);
    $data[] = $year;
    $data[] = $month;
    $data[] = $day;
    $stmt->execute($data);

    $dbh = null;

    $csv = "注文コード,注文日時,会員番号,お名前,メール,郵便番号,住所,TEL,商品コード,商品名,価格,数量\n";

    while (true) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$rec) {
            break;
        }
        $csv .= "{$rec['code']},{$rec['date']},{$rec['code_member']},{$rec['dat_sales_name']},{$rec['email']},{$rec['postal']},{$rec['address']},{$rec['tel']},{$rec['code_product']},{$rec['mst_product_name']},{$rec['price']},{$rec['quantity']}\n";
    }

    $file = fopen('./chumon.csv', 'w');
    $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
    fputs($file, $csv);
    fclose($file);

} catch (Exception $e) {
    echo 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<a href="chumon.csv" download="chumon.csv">注文データのダウンロード</a><br>
<br>
<a href="order_download.php">日付選択へ</a><br>
<br>
<a href="../staff_login/staff_top.php">トップメニューへ</a>

</body>
</html>