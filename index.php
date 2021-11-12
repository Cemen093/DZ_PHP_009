<?php
//index - выводит таблицу(имя / размер / дата загрузки) всех файлов на сервер (при клике на имя - файл скачивается)
session_start();

$uploaddir = './uploads/';


if (isset($_GET['filename'])){
    $relative_path = $uploaddir.$_GET['filename'];
    if (file_exists($relative_path)){
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($relative_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($relative_path));
        readfile($relative_path);
    } else{
        http_response_code(404);
        header("Location: /codes/404.html");
    }
}

$message_1='';
$message_2='';
if (empty($_SESSION['Login']))
{
    $message_1 = '
        <a href="authorize.php">Authorize</a>
        </br>
        <a href="registration.php">Registration</a>
        </br>
        <a href="index.php">Файлы на сервере</a>
        </br>';
}
else
{
    $login = $_SESSION['Login'];

    $message_1 = '
    <p>Вы вошли как '.$login.'</p>
    <a href="add.php">Добавить файл на сервер</a>
    </br>
    <a href="index.php">Файлы на сервере</a>
    </br>
    <form action="logout.php" method="post">
        <input type="submit" value="Logout" name="logout">
    </form>';
}
$files = array_diff(scandir($uploaddir), array('..', '.'));
foreach ($files as $file){
    $start = stat($uploaddir.$file);
    $message_2 .= '<p><a href="index.php?filename='.$file.'">name: '.$file.' / size: '.$start['size'].' / download time: '.
        date_format(date_timestamp_set(date_create(), $start['ctime']), 'Y-m-d H:i:s').'</a></p>';
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<div class="top">
    <h1>Index</h1>
    '.$message_1.'
</div>
<div class="box">
    <div class="content">
    '.$message_2.'
    </div>
</div>';