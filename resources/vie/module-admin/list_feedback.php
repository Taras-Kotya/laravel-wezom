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
        $sql = 'SELECT * FROM `feedback` ORDER BY `time` DESC ';

        // Pagination
        $start = (!empty($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 0);
        $num_per_page = 300;
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
                <div style='
                padding: 15px; 
                margin: 15px; 
                border: 1px solid #aaa;
                background: <?=(!empty($asd['status']) ? '#ddd' : '#ffeb9c')?>;
                '>
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
                        | <a href="?mod=del&id=<?= $asd['id'] ?>">видалити</a> (id<?= $asd['id'] ?>)
                        | <a href="?mod=red&id=<?= $asd['id'] ?>">редагувати</a>
                        <?= (!empty($asd['status']) ? '' :
                            '| <a href="?mod=public&id=' . $asd['id'] . '"><font color="green">опубликовать</font></a>'
                        ) ?>
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






    case 'public':
        $sql = 'SELECT * FROM `feedback` WHERE `id` = "' . ($_GET['id']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));

        if (empty($qwe['id'])) echo 'Новини немає';

        else {
            mysqli_query(
                $mysqli,
                'UPDATE `feedback` SET 
                                    `status` = "1"
                                    WHERE `id` = "' . $_GET['id'] . '"'
            );
            echo "<u>Опублікований відгук #" . $_GET['id'] . '</u>';
        }
        ?>
        <?php
        break;







    case 'red':
        $sql = 'SELECT * FROM `feedback` WHERE `id` = "' . ($_GET['id']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));
        if (empty($qwe['id'])) echo 'Відгуку немає';
        else {
        ?>
            <h1>Редагування відгуку</h1>
            <form action="?mod=save&id=<?=$_GET['id']?>" method="post">
                <p>Ім'я: <br>
                    <input type='text' style='padding: 7px' name='name' value='<?= $qwe['name'] ?>'>
                </p>
                <p>email: <br>
                    <input type='text' style='padding: 7px'  name='email' value='<?= $qwe['email'] ?>'>
                </p>
                <p>Відгук: <br>
                    <textarea type='text' style='min-width: 245px; min-height: 145px;' name='message'><?= $qwe['message'] ?></textarea>
                </p>
                <p>Статус: <br>
                    <select name="status" id="" style='padding: 7px' >
                        <option value="0">на модерації</option>
                        <option value="1" <?=($qwe['status']==1 ? 'selected' : '') ?>>опубліковано</option>
                    </select>
                </p>

                <p>
                    <button type='input' style='padding: 12px'  name='save' value='зберегти'>Зберегти</button>
                </p>


            </form>



        <?php
        }
        break;




    case 'save':
        $sql = 'SELECT * FROM `feedback` WHERE `id` = "' . ($_GET['id']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));
        if (empty($qwe['id'])) echo 'Відгуку немає';


        
        else {
            
            mysqli_query(
            $mysqli,
            'UPDATE `feedback` SET 
            `status` = "'. htmltext($_POST['status']) .'",
                        `name` = "'. htmltext($_POST['name']) .'",
                        `email` = "'. htmltext($_POST['email']) .'",
                        `message` = "'. htmltext($_POST['message']) .'",
                        `status` = "'. htmltext($_POST['status']) .'"
                        WHERE `id` = "' . $_GET['id'] . '"'
        );
        echo "<u>Відредагований відгук #" . $_GET['id'] . '</u>';
        }
        break;




    case 'del':
        $sql = 'SELECT * FROM `feedback` WHERE `id` = "' . ($_GET['id']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));

        if (empty($qwe['id'])) echo 'Відгуку немає';

        else {
            mysqli_query(
                $mysqli,
                'DELETE FROM `feedback`
                        WHERE `id` = "' . $_GET['id'] . '"'
            );

            echo "<u>Видалений відгук #" . $_GET['id'] . '</u>';
        }
    ?>


<?php
        break;
}
?>




<?php
require 'footer/menu_adm.php';
?>
<?php
require 'libs/foot.php';
?>