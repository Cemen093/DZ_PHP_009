<?php
//autorize		-	авторизация (логин / пароль)
session_start();

if (empty($_SESSION["Login"])) {
    $message_1='
        <a href="registration.php">Registration</a>
        </br>
        <a href="index.php">Файлы на сервере</a>
        </br>';
    $message_2='
            <form action="authorize.php" method="post">
                <p><label>Login:<input type="text" placeholder="Login" name="user_login"></label><p>
                <p><label>Password:<input type="text" placeholder="Password" name="user_password"></label></p>
                <div>
                    <input type="reset" value="Reset ">
                    <input type="submit" value="Sing in" name="submit">
                </div>
            </form>';
} else{
    $message_1='
        <a href="add.php">Добавить файл на сервер</a>
        </br>
        <a href="index.php">Файлы на сервере</a>
        </br>
        <form action="logout.php" method="post">
            <input type="submit" value="Logout" name="logout">
        </form>';
    $message_2 = 'Страница не доступна для зарегестрированных пользователей.';
}

if (isset($_POST['submit']) and isset($_POST['user_login']) and isset($_POST['user_password'])) {
    $login = $_POST['user_login'];
    $password = $_POST['user_password'];

    $filename = 'users.txt';
    if (file_exists($filename)){
        $file = file_get_contents($filename);
        if (preg_match('/login='.$login.';password='.$password.'/', $file)){
            $_SESSION['Login'] = $login;
            header("Location: index.php");
        }
    }
}


echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Authorize</title>
        <link href="style.css" rel="stylesheet"/>
    </head>
    <body>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <div class="top">
        <h1>Authorize</h1>
        '.$message_1.'
    </div>
    <div class="box">
        <div class="content">
            <h2>Authorize</h2>
            '.$message_2.'
        </div>
    </div>
    </body>
    </html>
';