<?php
// Виводимо сесію-повідомлення
if (array_key_exists('message', $_SESSION)) :
?>
    <div style="width: 350px; height: 100%; padding: 10px; background: red">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
    </div>
<?php endif ?>