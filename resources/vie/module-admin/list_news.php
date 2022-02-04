<?php
chdir('..');
$title = 'Список новин';
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
        $sql = 'SELECT * FROM `news` ORDER BY `' . $sort . '` DESC ';

        // Pagination
        $start = (!empty($_GET['start']) && is_numeric($_GET['start']) ? $_GET['start'] : 0);
        $num_per_page = 30;
        $max_value = mysqli_num_rows(mysqli_query($mysqli, $sql));

        // SQL
        $qwe = mysqli_query($mysqli, $sql . ' LIMIT ' . $start . ',' . $num_per_page);

        ?>


        <?php
        // Сортування
        /*
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
        <?php endif; /* */ ?>






        <h1>Список новин</h1>

        <?php


        if ($max_value == 0) {
            echo 'Новин немає ';
        } else {
            echo '(тут всі на одній сторінці) <br>';

            // Виведення інформації
            while ($asd = mysqli_fetch_array($qwe)) {
        ?>

                <div style='
                padding: 15px; 
                margin: 15px; 
                border: 1px solid #aaa;
                background: <?= (!empty($asd['status']) ? '#ddd' : '#ffeb9c') ?>;
                '>
                    <img src="/img/<?= $asd['id'] ?>.png" style="max-width: 450px" srcset="">
                    <hr>
                    <li>
                        <b>Заголовок:</b>
                        <?= $asd['title']; ?>
                    </li>

                    <li> <b>Повідомлення:</b> <?= $asd['message'] ?> </li>

                    <br>
                    
                    <li> Переглядів: <?= $asd['view'] ?>
                        | <a href="?mod=del&id=<?= $asd['id'] ?>">видалити </a>
                        | <?= times($asd['time']) ?>
                        <?= (!empty($asd['status']) ? '' :
                            '| <a href="?mod=public&id=' . $asd['id'] . '"><b><font color="green">опубликовать</font></b></a>'
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








    case 'del':
        $sql = 'SELECT * FROM `news` WHERE `id` = "' . ($_GET['id']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));

        if (empty($qwe['id'])) echo 'Новини немає';

        else {
            mysqli_query(
                $mysqli,
                'DELETE FROM `news`
                WHERE `id` = "' . $_GET['id'] . '"'
            );

            echo "<u>Видалена новина #" . $_GET['id'] . '</u>';
        }
        ?>


    <?php
        break;









    case 'public':
        $sql = 'SELECT * FROM `news` WHERE `id` = "' . ($_GET['id']) . '" ';
        $qwe = mysqli_fetch_array(mysqli_query($mysqli, $sql));

        if (empty($qwe['id'])) echo 'Новини немає';

        else {
            mysqli_query(
                $mysqli,
                'UPDATE `news` SET 
                            `status` = "1",
                            `time` = "' . time() . '"
                            WHERE `id` = "' . $_GET['id'] . '"'
            );
            echo "<u>Опублікована новина #" . $_GET['id'] . '</u>';
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