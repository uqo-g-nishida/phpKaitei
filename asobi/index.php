<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

// Twigを使用するテンプレートの読込み
$loader = new \Twig\Loader\FilesystemLoader('./view');
$twig = new \Twig\Environment($loader);

// htmlに渡すデータ
$data = array(
    'title' => 'MyTitle',
    'message'  => 'MyMessage',
);

// テンプレートのレンダリング
echo $twig->render('index.twig', $data);
?>