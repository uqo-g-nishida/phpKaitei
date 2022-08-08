<?php
function gengo($seireki)
{
    if (1868 <= $seireki && $seireki <= 1911) {
        return '明治';
    } elseif ($seireki <= 1925) {
        return '大正';
    } elseif ($seireki <= 1988) {
        return '昭和';
    } else {
        return '平成';
    }
}