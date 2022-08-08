<?php

session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    echo '
        ログインされていません。<br>
        <a href="../staff_login/staff_login.html">ログイン画面へ</a>
        ';
    exit();
}

$pro_code = $_POST['procode'];

// 参照
if (isset($_POST['disp'])) {
    if (!isset($pro_code)) {
        header("Location: pro_ng.php");
        exit();
    }

    header("Location: shop_product.php?procode=$pro_code");
    exit();
}

// 追加
if (isset($_POST['add'])) {
    header("Location: pro_add.php");
    exit();
}

// 編集
if (isset($_POST['edit'])) {
    if (!isset($pro_code)) {
        header("Location: pro_ng.php");
        exit();
    }

    header("Location: pro_edit.php?procode=$pro_code");
    exit();
}

// 削除
if (isset($_POST['delete'])) {
    if (!isset($pro_code)) {
        header("Location: pro_ng.php");
        exit();
    }

    header("Location: pro_delete.php?procode=$pro_code");
    exit();
}