<?php

// todo Написать подвал сайта /body, /html и подключение js

$ssl = 'http';
if(isset($_SERVER['HTTPS'])) $ssl = 'https';
$host = $_SERVER['HTTP_HOST'];
$path_info = pathinfo($_SERVER['REQUEST_URI']);
$url = $path_info['dirname'];

?>
        </div>
    </content>
    <footer>
        <div class = 'MaxWidthHeader'>
            <div class = 'Footer'>
                <p>Phone:
                    <a class = 'phone' href = 'tel:+77777777777'><?php echo PHONE;?></a>
                </p>
                <p>Mail:
                    <a class = 'mail' href = 'mailto:example@mail.ru'><?php echo MAIL;?></a>
                </p>
                <p>Address:
                    <a class = 'address'><?php echo ADDRESS;?></a>
                </p>
                <p>Time work:
                    <a class = 'timeWork'><?php echo TIME_WORK;?></a>
                </p>
                <?php //подключается js на обработку события нажатия кнопки
                if($path_info['basename'] == 'form') {        //подключение только на стрнице с формой
                    echo "<script src='" . $ssl . "://" . $host . $url . "/static/js/send_button.js'></script>";
                }
                ?>
            </div>
        </div>
    </footer>
</body>
