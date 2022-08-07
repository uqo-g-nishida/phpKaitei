<?php

$pro_code = $_POST['procode'];

// 参照
if (isset($_POST['disp'])) {
    if (!isset($_POST['procode'])) {
        header("Location: pro_ng.php");
        exit();
    }

    header("Location: pro_disp.php?procode=$pro_code");
    exit();
}

// 追加
if (isset($_POST['add'])) {
    header("Location: pro_add.php");
    exit();
}

// 編集
if (isset($_POST['edit'])) {
    if (!isset($_POST['procode'])) {
        header("Location: pro_ng.php");
        exit();
    }

    header("Location: pro_edit.php?procode=$pro_code");
    exit();
}

// 削除
if (isset($_POST['delete'])) {
    if (!isset($_POST['procode'])) {
        header("Location: pro_ng.php");
        exit();
    }

    header("Location: pro_delete.php?procode=$pro_code");
    exit();
}