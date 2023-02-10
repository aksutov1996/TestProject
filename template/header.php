<?php
// todo Написать шапку сайта: html, head, body, меню, подключение css

$ssl = 'http';
if(isset($_SERVER['HTTPS'])) $ssl = 'https';
$host = $_SERVER['HTTP_HOST'];
$url = pathinfo($_SERVER['PHP_SELF']);
$url = $url['dirname'];

?>
<!doctype html>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <link rel="shortcut icon" href="static/images/favicon.svg">
            <link type="text/css" rel="stylesheet" href="static/css/style.css?ver=1" media="all">
            <!-- для оптимизации под экраны -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- /для оптимизации под экраны -->
            <title>StudyProject</title>
            <meta name="keywords" content="StudyProject">
            <meta name="description" content="Test project.">
        </head>
        <body>
            <header>
                <div class = 'MaxWidthHeader'>
                    <div class = 'LineLogo'>
                        <a href = 'index.php'>
                            <img src = "static/images/logo.svg" alt = 'logo'>
                        </a>
                        <h1>StudyProject</h1>
                    </div>
                    <div class = 'InfoHeader'>
                        <div class = 'InfoHeaderCart'>
                            <p>Phone:
                                <a class = 'phone' href = 'tel:+77777777777'><?php echo PHONE;?></a>
                            </p>
                            <p>Mail:
                                <a class = 'mail' href = 'mailto:example@mail.ru'><?php echo MAIL;?></a>
                            </p>
                        </div>
                    </div>
                    <div class = 'Menu'>
                        <ul>
                            <li>
                                <?php
                                echo "<a href = '".$ssl."://".$host.$url."/form'>Form</a>";
                                ?>
                            </li>
                            <li>
                                <?php
                                echo "<a href = '".$ssl."://".$host.$url."/list'>List</a>";
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <content>
                <div class = 'MaxWidthHeader'>

