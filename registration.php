<?php
//registration	-	регистрация (логин / пароль)
session_start();

$message_1='';
$message_2='';
if (empty($_SESSION['Login']))
{
    $message_1 = '
        <a href="authorize.php">Authorize</a>
        </br>
        <a href="index.php">Файлы на сервере</a>
        </br>';
    $message_2 = '
            <h2>Registration</h2>
            <form action="registration.php" method="post">
                <p><label>Login:<input type="text" placeholder="Login" name="user_login"></label></p>
                <p><label>Password:<input type="text" placeholder="Password" name="user_password"></label></p>
                <div>
                    <input type="reset" value="Reset ">
                    <input type="submit" value="Registrations" name="submit">
                </div>
            </form>';
} else{
    $message_1 = '
        <a href="add.php">Добавить файл на сервере</a>
        </br>
        <a href="index.php">Файлы на сервере</a>
        </br>
        <form action="logout.php" method="post">
            <input type="submit" value="Logout" name="logout">
        </form>';
    $message_2 = 'Страница не доступна для зарегестрированных пользователей.';
}


$pattern_name = '/\w{3,}/';
$pattern_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';

if (isset($_POST['submit']))
{
    $login= isset($_POST['user_login']) ? $_POST['user_login'] : '';
    $password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
    $filename = 'users.txt';
    if(!preg_match($pattern_name, $login)){
        $message_2 = '<p class="error">login incorrect</p>';
    } else if(!preg_match($pattern_password, $password)){
        $message_2 = '<p class="error">password incorrect</p>';
    } else if (file_exists($filename) and preg_match('/login='.$login.';/', file_get_contents($filename))){
        $message_2 = '<p class="error">login already exists</p>';
    } else {
        file_put_contents($filename, "login=" . $login . ';password=' . $password . ';' . PHP_EOL, FILE_APPEND);
        $_SESSION['Login'] = $_POST['user_login'];
        header("Location: index.php");
    }
}

echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <link href="style.css" rel="stylesheet"/>
    </head>
    <body>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <div class="top">
        <h1>Registration</h1>
        '.$message_1.'
    </div>
    <div class="box">
        <div class="content">
            '.$message_2.'
        </div>
    </div>
';