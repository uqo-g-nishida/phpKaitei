<?php
require_once 'vendor/autoload.php';

// テンプレートファイルがあるディレクトリ（本サンプルではカレントディレクトリ）
$loader = new Twig_Loader_Filesystem('.');

$twig = new Twig_Environment($loader);

$template = $twig->loadTemplate('sample.html.twig');
$data = array(
    'title' => 'sample',
    'message'  => 'My Webpage!',
);
echo $template->render($data);