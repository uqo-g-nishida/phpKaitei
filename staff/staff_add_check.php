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
    <title>スタッフ追加確認</title>
</head>
<body>

<?php
require_once '../common/sanitize.php';

$post = sanitize($_POST);
$staff_name = $post['name'];
$staff_pass = $post['pass'];
$staff_pass2 = $post['pass2'];

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

if ($staff_pass != $staff_pass2) {
    echo 'パスワードが一致していません。<br>';
    $problem = true;
}

if ($problem) {
    echo '
        <form>
        <input type="button" onclick="history.back()" value="戻る">
        </form>
        ';
} else {
    $staff_pass = md5($staff_pass);
    echo '
        <form method="post" action="staff_add_done.php">
            <input type="hidden" name="name" value="' . $staff_name . '">
            <input type="hidden" name="pass" value="' . $staff_pass . '">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="OK">
        </form>
        ';
}
?>

</body>
</html>