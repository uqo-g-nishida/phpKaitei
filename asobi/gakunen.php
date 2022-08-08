<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学年</title>
</head>
<body>

<?php

$gakunen = $_POST['gakunen'];

switch ($gakunen) {
    case '1':
        $kousha = '南校舎';
        $bukatu = '部活動にはスポーツ係と文化係があります。';
        $mokuhyou = 'まずは学校生活に慣れよう';
        break;
    case '2':
        $kousha = '西校舎';
        $bukatu = '学園祭目指して全力で取り組みましょう。';
        $mokuhyou = '今しかできないことを見つけよう。';
        break;
    case'3':
        $kousha = '東校舎';
        $bukatu = '受験に就職に忙しくなります。後輩へ譲っていきましょう。';
        $mokuhyou = '将来への道を作ろう。';
        break;
    default:
        $kousha = '三年生と同じ';
        $bukatu = '部活動はありません。';
        $mokuhyou = '早く卒業しましょう';
        break;
}

echo "
    校舎：あなたの校舎は{$kousha}です。<br>
    部活：{$bukatu}<br>
    目標：{$mokuhyou}<br>
"

?>

</body>
</html>