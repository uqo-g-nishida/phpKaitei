<?php

function pulldown_year()
{
    echo '<select name="year" id="year">';
    for ($i = 2000; $i <= 2025; $i++) {
        echo "<option value='{$i}'>$i</option>";
    }
    echo '</select>';
}

function pulldown_month()
{
    echo '<select name="month" id="month">';
    for ($i = 1; $i <= 12; $i++) {
        $str = sprintf('%02d', $i);
        echo "<option value='{$str}'>$str</option>";
    }
    echo '</select>';
}

function pulldown_day()
{
    echo '<select name="day" id="day">';
    for ($i = 1; $i <= 31; $i++) {
        $str = sprintf('%02d', $i);
        echo "<option value='{$str}'>$str</option>";
    }
    echo '</select>';
}