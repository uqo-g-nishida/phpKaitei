<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

function view_message_link_page($title, $login, $member_name, $message, $link, $link_text)
{
    // Twigを使用するテンプレートの読込み
    $loader = new \Twig\Loader\FilesystemLoader('./view');
    $twig = new \Twig\Environment($loader);

    // htmlに渡すデータ
    $data = array(
        'title' => $title,
        'login' => $login,
        'member_name' => $member_name,
        'message' => $message,
        'link' => $link,
        'link_text' => $link_text
    );

    // テンプレートのレンダリング
    echo $twig->render('message_link.html.twig', $data);
}