<?php
//add -	доступна только авторизованным пользовалям и нужна для загрузки файлов ( не более 250 мб)
//загрузки на сервер?
session_start();

$uploaddir = './uploads/';
$message_1='';
$message_2='';

if (isset($_POST['submit'])){
    if (empty($_FILES['userfile']['name'])){
        $message_2 .= '<p>File name not specified</p>';
    }else{
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){
            $message_2 .= '<p>файл успешно загружен.</p>';
        }else{
            $message_2 .= '<p>файл не был загружен</p>';
        }
    }
}

if (empty($_SESSION['Login']))
{
    $message_1 = '
        <a href="authorize.php">Authorize</a>
        </br>
        <a href="registration.php">Registration</a>
        </br>
        <a href="index.php">Файлы на сервере</a>
        </br>';
    $message_2 = 'Страница не доступна для не зарегестрированных пользователей.';
}
else
{
    $login = $_SESSION['Login'];

    $message_1 = '
    <p>Вы вошли как '.$login.'</p>
    <a href="index.php">Файлы на сервере</a>
    </br>
    <form action="logout.php" method="post">
        <input type="submit" value="Logout" name="logout">
    </form>';
    $message_2 = '
        <form enctype="multipart/form-data" action="" method="POST">
            <p><input type="hidden" name="MAX_FILE_SIZE" value="250000000" /></p>
            <p><input name="userfile" type="file" /></p>
            <p><input type="submit" value="Отправить файл" name="submit"/></p>
        </form>';
}
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add</title>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<div class="top">
    <h1>Add</h1>
    '.$message_1.'
</div>
<div class="box">
    <div class="content">
        <h2>Add file</h2>
        '.$message_2.'
    </div>
</div>';