<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ご購入確認</title>
</head>
<body>

<?php

require_once '../common/sanitize.php';

$post = sanitize($_POST);

$onamae = $post['onamae'];
$email = $post['email'];
$postal = $post['postal'];
$addres = $post['addres'];
$tel = $post['tel'];

$okflg = true;

if ($onamae == '') {
    echo 'お名前が入力されていません。<br><br>';
    $okflg = false;
} else {
    echo "
        お名前<br>
        {$onamae}<br><br>
        ";
}
if (!preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $email)) {
    echo 'メールアドレスを正確に入力して下さい。<br><br>';
    $okflg = false;
} else {
    echo "
        メールアドレス<br>
        {$email}<br><br>
        ";
}
if (!preg_match("/^\d+$/", $postal)) {
    echo '郵便番号は半角数字で入力して下さい。<br><br>';
    $okflg = false;
} else {
    echo "
        郵便番号<br>
        {$postal}<br><br>
        ";
}
if ($addres == '') {
    echo '住所が入力されていません。<br><br>';
    $okflg = false;
} else {
    echo "
        住所<br>
        {$addres}<br><br>
        ";
}
if (!preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $tel)) {
    echo '電話番号を正確に入力して下さい。<br><br>';
    $okflg = false;
} else {
    echo "
        電話番号<br>
        {$tel}<br><br>
        ";
}
?>

<?php if($okflg) : ?>
<form action="shop_form_done.php" method="post">
    <input type="hidden" name="onamae" value="<?= $onamae ?>">
    <input type="hidden" name="email" value="<?= $email ?>">
    <input type="hidden" name="postal" value="<?= $postal ?>">
    <input type="hidden" name="addres" value="<?= $addres ?>">
    <input type="hidden" name="tel" value="<?= $tel ?>">
    <input type="button" value="戻る" onclick="history.back()">
    <input type="submit" value="OK">
</form>
<?php else : ?>
<form>
    <input type="button" value="戻る" onclick="history.back()">
</form>
<?php endif; ?>

</body>
</html>