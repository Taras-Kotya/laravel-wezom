<?php
chdir('..');
require 'libs/_include.php'; // всі інклуди
?>


<?php
$mod = @trim($_GET['mod']);
switch ($mod) {
    default:
        echo '<h1>Додати відгук</h1>';
        $form = getForm('add_feedback');
        $form->show();

        break;




    case 'add':
        $result = ['success' => false];
        $code = htmltext($_POST['captcha']);
        $name = htmltext($_POST['name']);
        $email = ($_POST['email']);
        $message = htmltext($_POST['message']);
        
        if (empty($_SESSION['captcha'])) {
            echo 'Капча не найдена';
            break;
        }

        if (empty($code)) {
            echo 'Будь-ласка введіть код!';
            break;
        }
        if (empty($name)) {
            echo 'Будь-ласка введіть ім\'я!';
            break;
        }
        if (empty($message)) {
            echo 'Будь-ласка введіть вігук!';
            break;
        }
        if (empty($email)) {
            echo 'Будь-ласка введіть email!';
            break;
        }



        $captcha = @$_SESSION['captcha'];
        unset($_SESSION['captcha']);
        session_write_close();

        $code = crypt(trim($code), '$1$itchief$7');
        $result['success'] = $captcha === $code;

        if (!$result['success']) {
            echo 'Введенный код не соответствует изображению!';
            break;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "E-mail адреса вказана невірно.\n";
            break;
        }


   
        $pattern = '/^[A-Za-z0-9 ]+$/i';
        if (!preg_match($pattern, $name)) {
            echo 'Тільки латиниця та цифри!';
            break;
        }


        mysqli_query(
            $mysqli,
            'INSERT INTO `feedback` SET 
                `name` = "' . $name . '" ,
                `email` = "' . $email . '" ,
                `message` = "' . $message . '" ,
                `status` = "0" ,
                `time` = "' . time() . '" '
        );
        $qwe['id'] = mysqli_insert_id($mysqli);
        echo "Доданий відгук #" . $qwe['id'];



      




?>

    <?php
        break;
}
    ?>




<?php
require 'footer/menu_user.php';
?>
<?php
require 'libs/foot.php';
?>