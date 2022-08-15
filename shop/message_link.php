<?php
// Twigライブラリの読込み
require_once '../vendor/autoload.php';

/// メッセージとリンクだけのページ
function view_message_link_page($message, $link, $link_text)
{
    // Twigを使用するテンプレートの読込み
    $loader = new \Twig\Loader\FilesystemLoader('./view');
    $twig = new \Twig\Environment($loader);

    // htmlに渡すデータ
    $data = array(
        'title' => $message,
        'login' => isset($_SESSION['member_login']),
        'member_name' => $_SESSION['member_name'],
        'message' => $message,
        'link' => $link,
        'link_text' => $link_text
    );

    // テンプレートのレンダリング
    echo $twig->render('message_link.html.twig', $data);
}