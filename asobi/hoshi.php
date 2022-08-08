<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>あの星は</title>
</head>
<body>

<?php

$mbango = $_POST['mbango'];

$hoshi = array(
    'M1' => 'カニ星雲',
    'M31' => 'アンドロメダ大星雲',
    'M42' => 'オリオン大星雲',
    'M45' => 'すばる',
    'M57' => 'ドーナツ星雲'
);

foreach ($hoshi as $key => $val) {
    echo "{$key}は{$val}<br>";
}

echo "あなたが選んだ星は、${hoshi[$mbango]}です。";

?>

</body>
</html>