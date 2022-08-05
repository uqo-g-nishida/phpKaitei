<?php

$staff_code = $_POST['staffcode'];

if (isset($_POST['add'])) {
    header("Location: staff_add.php");
    exit();
}

if (isset($_POST['edit'])) {
    if (!isset($_POST['staffcode'])) {
        header("Location: staff_ng.php");
        exit();
    }

    header("Location: staff_edit.php?staffcode=$staff_code");
    exit();
}

if (isset($_POST['delete'])) {
    if (!isset($_POST['staffcode'])) {
        header("Location: staff_ng.php");
        exit();
    }

    header("Location: staff_delete.php?staffcode=$staff_code");
    exit();
}