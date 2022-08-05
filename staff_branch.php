<?php

$staff_code = $_POST['staffcode'];

// 参照
if (isset($_POST['disp'])) {
    if (!isset($_POST['staffcode'])) {
        header("Location: staff_ng.php");
        exit();
    }

    header("Location: staff_disp.php?staffcode=$staff_code");
    exit();
}

// 追加
if (isset($_POST['add'])) {
    header("Location: staff_add.php");
    exit();
}

// 編集
if (isset($_POST['edit'])) {
    if (!isset($_POST['staffcode'])) {
        header("Location: staff_ng.php");
        exit();
    }

    header("Location: staff_edit.php?staffcode=$staff_code");
    exit();
}

// 削除
if (isset($_POST['delete'])) {
    if (!isset($_POST['staffcode'])) {
        header("Location: staff_ng.php");
        exit();
    }

    header("Location: staff_delete.php?staffcode=$staff_code");
    exit();
}