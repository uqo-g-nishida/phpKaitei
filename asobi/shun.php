<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>季節の野菜</title>
</head>
<body>

<?php

$tsuki = $_POST['tsuki'];

$yasai[] = '';
$yasai[] = 'ブロッコリー';
$yasai[] = 'カリフラワー';
$yasai[] = 'レタス';
$yasai[] = 'みつば';
$yasai[] = 'アスパラガス';
$yasai[] = 'セロリ';
$yasai[] = 'ナス';
$yasai[] = 'ピーマン';
$yasai[] = 'オクラ';
$yasai[] = 'さつまいも';
$yasai[] = '大根';
$yasai[] = 'ほうれんそう';

echo "${tsuki}月は${yasai[$tsuki]}が旬です。"

?>

</body>
</html>