<?php
chdir('..');
// $title = 'Список новин';
require 'libs/_include.php'; // всі інклуди
?>


<?php
$mod = @trim($_GET['mod']);
switch ($mod) {
    default:
?>
        <?php

        // SQL 
        $sql = 'SELECT * FROM `feedback` WHERE `status`="1" ORDER BY `time` DESC ';

        // Pagination
        $start = (!empty($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 0);
        $num_per_page = 3;
        $max_value = mysqli_num_rows(mysqli_query($mysqli, $sql));

        // SQL
        $qwe = mysqli_query($mysqli, $sql . ' LIMIT ' . $start . ',' . $num_per_page);
        ?>

        <h1>Список відгуків</h1>


        <?php


        if ($max_value == 0) {
            echo 'Відгуків немає ';
        } else {

            // Виведення інформації
            while ($asd = mysqli_fetch_array($qwe)) {
        ?>
                <div style='padding: 15px; margin: 15px; border: 1px solid #aaa; background: #eee'>
                    <li>
                        <b><?= $asd['name']; ?></b> (<u><?= $asd['email']; ?></u>)
                    </li>


                    <li>
                        <b>Повідомлення:</b>
                        <?= $asd['message'] ?>
                    </li>

                    <br>

                    <li> 
                        <?= times($asd['time']) ?>
                    </li>
                </div>

            <?php
            }

            if ($max_value > $num_per_page) {
                echo str_pages(
                    '?' .
                        (isset($_GET['sort_view']) ? 'sort_view&' : ''),
                    $start,
                    $max_value,
                    $num_per_page
                );
            }
        }

        break;

}
?>




<?php
require 'footer/menu_user.php';
?>
<?php
require 'libs/foot.php';
?>