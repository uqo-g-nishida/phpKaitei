<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スタッフ追加確認</title>
</head>
<body>

<?php
$staff_name = $_POST['name'];
$staff_pass = $_POST['pass'];
$staff_pass2 = $_POST['pass2'];

$staff_name = htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
$staff_pass = htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');
$staff_pass2 = htmlspecialchars($staff_pass2,ENT_QUOTES,'UTF-8');

$problem = false;

if ($staff_name == '') {
    echo 'スタッフ名が入力されていません。<br>';
    $problem = true;
} else {
    echo "スタッフ名：$staff_name <br>";
}

if ($staff_pass == '') {
    echo 'パスワードが入力されていません。<br>';
    $problem = true;
}

if ($staff_pass != $staff_pass2){
    echo 'パスワードが一致していません。<br>';
    $problem = true;
}

if ($problem){
    echo '
        <form>
        <input type="button" onclick="history.back()" value="戻る">
        </form>
        ';
} else {
    $staff_pass = md5($staff_pass);
    echo '
        <form method="post" action="staff_add_done.php">
            <input type="hidden" name="name" value="' .$staff_name.'">
            <input type="hidden" name="pass" value="'.$staff_pass.'">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
        ';
}
?>

</body>
</html>