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
    <title>商品追加確認</title>
</head>
<body>

<?php
require_once '../common/sanitize.php';

$post = sanitize($_POST);
$pro_name = $post['name'];
$pro_price = $post['price'];
$pro_gazou = $_FILES['gazou'];

$problem = false;

if ($pro_name == '') {
    echo '商品名が入力されていません。<br>';
    $problem = true;
} else {
    echo "商品名：$pro_name <br>";
}

if (!preg_match("/^\d+$/", $pro_price)) {
    echo '価格をきちんと入力してください<br>';
    $problem = true;
} else {
    echo "価格：$pro_price <br>";
}

if ($pro_gazou['size'] > 0) {
    if ($pro_gazou['size'] > 1000000) {
        echo '画像が大きすぎます。';
        $problem = true;
    } else {
        move_uploaded_file($pro_gazou['tmp_name'], './gazou/' . $pro_gazou['name']);
        echo "<img src='./gazou/${pro_gazou['name']}'><br>";
    }
}

if ($problem) {
    echo '
        <form>
        <input type="button" onclick="history.back()" value="戻る">
        </form>
        ';
} else {
    echo '
        上記の商品を追加します。
        <form method="post" action="pro_add_done.php">
            <input type="hidden" name="name" value="' . $pro_name . '">
            <input type="hidden" name="price" value="' . $pro_price . '">
            <input type="hidden" name="gazou_name" value="' . $pro_gazou['name'] . '">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
        ';
}
?>

</body>
</html>