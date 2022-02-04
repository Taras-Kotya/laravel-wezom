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
        // Sort
        $sort = (isset($_GET['sort_view']) ? 'view' : 'time');


        // SQL 
        $sql = 'SELECT * FROM `news` WHERE `status`="1" ORDER BY `' . $sort . '` DESC ';

        // Pagination
        $start = (!empty($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 0);
        $num_per_page = 2;
        $max_value = mysqli_num_rows(mysqli_query($mysqli, $sql));

        // SQL
        $qwe = mysqli_query($mysqli, $sql . ' LIMIT ' . $start . ',' . $num_per_page);
        ?>

        <?php
        if ($max_value > 0) :
        ?>
            <div class="mdc-tab-bar" role="tablist">
                <div class="mdc-tab-scroller">
                    <div class="mdc-tab-scroller__scroll-area">
                        <div class="mdc-tab-scroller__scroll-content">

                            <?php $active = (!isset($_GET['sort_view']) ? '--active' : ''); ?>

                            <a href="?" class="mdc-tab mdc-tab<?= $active ?>" role="tab" aria-selected="true" tabindex="0">
                                <span class="mdc-tab__content">
                                    <span class="mdc-tab__icon material-icons" aria-hidden="true">favorite</span>
                                    <span class="mdc-tab__text-label">За часом</span>
                                </span>
                                <span class="mdc-tab-indicator mdc-tab-indicator<?= $active ?>">
                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                </span>
                                <span class="mdc-tab__ripple"></span>
                            </a>

                            <?php $active = (isset($_GET['sort_view']) ? '--active' : ''); ?>

                            <a href="?sort_view" class="mdc-tab mdc-tab<?= $active ?>" role="tab" aria-selected="true" tabindex="0">
                                <span class="mdc-tab__content">
                                    <span class="mdc-tab__icon material-icons" aria-hidden="true">favorite</span>
                                    <span class="mdc-tab__text-label">За переглядами</span>
                                </span>
                                <span class="mdc-tab-indicator mdc-tab-indicator<?= $active ?>">
                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                </span>
                                <span class="mdc-tab__ripple"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <h1>Список новин</h1>


        <?php


        if ($max_value == 0) {
            echo 'Новин немає ';
        } else {

            // Виведення інформації
            while ($asd = mysqli_fetch_array($qwe)) {
        ?>
                <div style='padding: 15px; margin: 15px; border: 1px solid #aaa; background: #eee'>
                    <a href="?mod=view&id=<?= $asd['id'] ?>">
                        <img src="/img/<?= $asd['id'] ?>.png" style="max-width: 450px" srcset="">
                    </a>
                    <hr>
                    <li>
                        <a href="?mod=view&id=<?= $asd['id'] ?>">
                            <b>Заголовок:</b>
                            <?= $asd['title']; ?>
                        </a>
                    </li>

                    <li>
                        <b>Повідомлення:</b>
                        <?= $asd['message'] ?>
                    </li>

                    <br>

                    <li> Переглядів: <?= $asd['view'] ?>
                        | <?= times($asd['time']) ?>

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





    case 'view':

        $sql = 'SELECT * FROM `news` WHERE `id` = "' . ($_GET['id']) . '" ';
        $asd = mysqli_fetch_array(mysqli_query($mysqli, $sql));


        if (empty($asd['id'])) echo 'Новини немає';
        else {

            if (empty($_SESSION['view']['' . $_GET['id'] . '']) || $_SESSION['view']['' . $_GET['id'] . ''] < time()) {

                // Зробив на сесіях (але можу зробити і через БД, щоб надійніше)
                $_SESSION['view']['' . $_GET['id'] . ''] = time() + 3;
                echo '(кожні 3 секунди фіксується перегляд)';


                mysqli_query(
                    $mysqli,
                    'UPDATE `news` SET 
                                `view` = `view`+"1"
                                WHERE `id` = "' . $_GET['id'] . '"'
                );
            }


            ?>
            <div style='padding: 15px; margin: 15px; border: 1px solid #aaa; background: #eee'>
                <li>
                    <b>Заголовок:</b>
                    <a href="?mod=view&id=<?= $asd['id'] ?>"><?= $asd['title']; ?></a>
                </li>

                <li>
                    <b>Повідомлення:</b>
                    <?= $asd['message'] ?>
                </li>

                <br>

                <li> Переглядів: <?= $asd['view'] ?>
                    | <?= times($asd['time']) ?>

                </li>
            </div>
<?php
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