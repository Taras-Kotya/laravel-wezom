<?php

require_once('libs/json-form-generator/form.class.php');


function getForm($formname)
{
    $form = new Form(['file' => "forms/$formname.json"]);
    return $form;
}




function can_upload($file)
{
    // если имя пустое, значит файл не выбран
    if ($file['name'] == '')
        return 'Вы не выбрали файл.';

    /* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
    if ($file['size'] == 0)
        return 'Файл слишком большой.';

    // разбиваем имя файла по точке и получаем массив
    $getMime = explode('.', $file['name']);
    // нас интересует последний элемент массива - расширение
    $mime = strtolower(end($getMime));
    // объявим массив допустимых расширений
    $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

    // если расширение не входит в список допустимых - return
    if (!in_array($mime, $types))
        return 'Недопустимый тип файла.';

    return true;
}





function make_upload($file, $id_news)
{
    // формируем уникальное имя картинки: случайное число и name
    $name = mt_rand(0, 10000) . $file['name'];
    $format = substr(strrchr($file['name'], "."), 1);


    copy($file['tmp_name'], 'img/' . $id_news . '.' . $format);
}








function debug($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}





function htmltext($text)
{
    $text = trim(htmlspecialchars_decode(addslashes(stripslashes($text))));
    $text = preg_replace('|[\s]+|s', ' ', $text); // удаляем лишние пробелы

    return $text;
}





function slv($str, $msg1, $msg2, $msg3)
{
    $str = (int)$str;
    $str1 = abs($str) % 100;
    $str2 = $str % 10;

    if ($str1 > 10 && $str1 < 20) return $str . ' ' . $msg3;
    if ($str2 > 1 && $str2 < 5) return $str . ' ' . $msg2;
    if ($str2 == 1) return $str . ' ' . $msg1;
    return $str . ' ' . $msg3;
}



function times($times = NULL)
{
    $time = time();

    if (($time - $times) <= 60) {
        $timesp = slv(($time - $times), 'секунду', 'секунды', 'секунд') . ' назад';
        return $timesp;
    } elseif (($time - $times) <= 3600) {
        $timesp = slv((($time - $times) / 60), 'минуту', 'минуты', 'минут') . ' назад';
        return $timesp;
    } else {
        $today = date("j M Y", $time);
        $today = date("j M Y", $time);
        $yesterday = date("j M Y", strtotime("-1 day"));
        $timesp = date("j M Y  в H:i", $times);
        $timesp = str_replace($today, 'Сегодня', $timesp);
        $timesp = str_replace($yesterday, 'Вчера', $timesp);
        $timesp = strtr($timesp, array("Jan" => "Янв", "Feb" => "Фев", "Mar" => "Марта", "May" => "Мая", "Apr" => "Апр", "Jun" => "Июня", "Jul" => "Июля", "Aug" => "Авг", "Sep" => "Сент", "Oct" => "Окт", "Nov" => "Ноября", "Dec" => "Дек",));
        return $timesp;
    }
}












function str_pages($base_url, $start, $max_value, $num_per_page)
{
    global $styleGame;
    ////////////////////////////////////////////////////////////
    // Функция постраничной навигации                         //
    ////////////////////////////////////////////////////////////
    // За основу взята аналогичная функция от форума SMF2.0   //
    ////////////////////////////////////////////////////////////
    $pgcont = 4;
    $pgcont = (int)($pgcont - ($pgcont % 2)) / 2;
    if ($start >= $max_value) {
        $start = max(0, (int)$max_value - (((int)$max_value % (int)$num_per_page) == 0 ? $num_per_page : ((int)$max_value % (int)$num_per_page)));
    } else {
        $start = max(0, (int)$start - ((int)$start % (int)$num_per_page));
        $base_link = '<a class="str" href="' . strtr($base_url, array('%' => '%%')) . 'start=%d' . '">%s</a> ';
        $pageindex = ($start == 0 ? '' : sprintf($base_link, $start - $num_per_page, '&lt;&lt;'));
    }
    if ($start > $num_per_page * $pgcont) {
        $pageindex .= sprintf($base_link, 0, '1');
    }
    if ($start > $num_per_page * ($pgcont + 1)) {
        $pageindex .= '<span style="font-weight: bold;"> ... </span>';
    }
    for ($nCont = $pgcont; $nCont >= 1; $nCont--) {
        if ($start >= $num_per_page * $nCont) {
            $tmpStart = $start - $num_per_page * $nCont;
            $pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
        }
    }
    $pageindex .= " <a class='str' style='color: #bbb'>" . '<b>' . ($start / $num_per_page + 1) . '</b>' . "</a> ";
    $tmpMaxPages = (int)(($max_value - 1) / $num_per_page) * $num_per_page;
    for ($nCont = 1; $nCont <= $pgcont; $nCont++)
        if ($start + $num_per_page * $nCont <= $tmpMaxPages) {
            $tmpStart = $start + $num_per_page * $nCont;
            $pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
        }
    if ($start + $num_per_page * ($pgcont + 1) < $tmpMaxPages) {
        $pageindex .= '<span style="font-weight: bold;"> ... </span>';
    }
    if ($start + $num_per_page * $pgcont < $tmpMaxPages) {
        $pageindex .= sprintf($base_link, $tmpMaxPages, $tmpMaxPages / $num_per_page + 1);
    }
    if ($start + $num_per_page < $max_value) {
        $display_page = ($start + $num_per_page) > $max_value ? $max_value : ($start + $num_per_page);
        $pageindex .= sprintf($base_link, $display_page, '&gt;&gt;');
    }


    return '<hr>' . $pageindex . '<hr>';
}
