<?php

/* Вы должны включить отчёт об ошибках для mysqli, прежде чем пытаться установить соединение */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_user = "root";
$db_pass = "123123";
$db_table = "wezom_junior";

$mysqli = mysqli_connect('localhost', $db_user, $db_pass, $db_table);

/* Установите желаемую кодировку после установления соединения */
mysqli_set_charset($mysqli, 'utf8mb4');