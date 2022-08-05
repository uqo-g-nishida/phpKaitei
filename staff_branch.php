<?php

$staff_code = $_POST['staffcode'];

if (isset($_POST['edit'])) {
    header("Location: staff_edit.php?staffcode=$staff_code");
    exit();
}

if (isset($_POST['delete'])) {
    header("Location: staff_delete.php?staffcode=$staff_code");
    exit();
}