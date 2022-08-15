<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

// Twigを使用するテンプレートの読込み
$loader = new \Twig\Loader\FilesystemLoader('./view');
$twig = new \Twig\Environment($loader);

require_once '../common/sanitize.php';

$post = sanitize($_POST);

// htmlに渡すデータ
$data = array(
    'title' => '注文確認',
    'onamae' => $post['onamae'],
    'email' => $post['email'],
    'postal' => $post['postal'],
    'addres' => $post['addres'],
    'tel' => $post['tel'],
    'chumon' => $post['chumon'],
    'pass' => $post['pass'],
    'pass2' => $post['pass2'],
    'danjo' => $post['danjo'],
    'birth' => $post['birth']
);

// テンプレートのレンダリング
echo $twig->render('shop_form_check.twig', $data);