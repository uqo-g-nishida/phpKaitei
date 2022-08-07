<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品修正確認</title>
</head>
<body>

<?php
$pro_code = $_POST['code'];
$pro_name = $_POST['name'];
$pro_price = $_POST['price'];

$pro_name = htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
$pro_price = htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

$problem = false;

if ($pro_name == '') {
    echo '商品名が入力されていません。<br>';
    $problem = true;
} else {
    echo "商品名：$pro_name <br>";
}

if (!is_numeric($pro_price)) {
    echo '価格をきちんと入力してください<br>';
    $problem = true;
} else {
    echo "価格：$pro_price <br>";
}

if ($problem){
    echo '
        <form>
        <input type="button" onclick="history.back()" value="戻る">
        </form>
        ';
} else {
    echo '
        <form method="post" action="pro_edit_done.php">
            <input type="hidden" name="code" value="' .$pro_code.'">
            <input type="hidden" name="name" value="'.$pro_name.'">
            <input type="hidden" name="price" value="'.$pro_price.'">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
        ';
}
?>

</body>
</html>