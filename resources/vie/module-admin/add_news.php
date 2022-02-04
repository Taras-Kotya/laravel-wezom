<?php
chdir('..');
require 'libs/_include.php'; // всі інклуди
?>


<?php
$mod = @trim($_GET['mod']);
switch ($mod) {
    default:
        echo '<h1>Додати новину</h1>';
        $form = getForm('add_news');
        $form->show();

        break;




    case 'add':
        $sql = 'SELECT * FROM `news` WHERE `title` = "' . htmltext($_POST['title']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));

        if (empty($_POST['title'])) echo '<font color="red">Нема заголовку </font><br>';

        elseif (empty($_POST['message'])) echo '<font color="red">Нема повідомлення</font><br>';

        // elseif (!empty($qwe['id'])) echo 'Вже є така новина';

        elseif (!isset($_FILES['file'])) echo 'Ви не обрали фото';

        else {

            // проверяем, можно ли загружать изображение
            $check = can_upload($_FILES['file']);

            if ($check === true) {

                mysqli_query(
                    $mysqli,
                    'INSERT INTO `news` SET 
                        `title` = "' . htmltext($_POST['title']) . '" ,
                        `message` = "' . htmltext($_POST['message']) . '" ,
                        `status` = "' . $_POST['status'] . '" ,
                        `time` = "' . time() . '" ,
                        `view` = "' . 0 . '" '
                );
                $qwe['id'] = mysqli_insert_id($mysqli);

                // загружаем изображение на сервер
                make_upload($_FILES['file'], $qwe['id']); 
                echo "Файл успішно завантажений! <br>";

                echo "Додана новина #" . $qwe['id'];
            } else {
                // выводим сообщение об ошибке
                echo "<strong>$check</strong>";
            }
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