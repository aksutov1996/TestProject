<?php

namespace Felix\StudyProject;

class Controller
{
    /**
     * Обработка запроса от пользователя
     *
     * todo Распарсить $_REQUEST['REQUEST_URI'] и понять какую страницу показывать
     *************(опечатка??? $_SERVER['REQUEST_URI'])
     * todo Проверку надо усложнить, чтобы учитывался http метод
     * todo Подключать хедер и футер
     *
     * @return void
     */
    public function process(): void
    {
        require_once __DIR__ . '/../www/config.php';

        $path_info = pathinfo($_SERVER['REQUEST_URI']);
        /*
         * Example:
         * $_SERVER['REQUEST_URI'] => '/mySites/coding-assignment-baby-bird-master/www/form
         * pathinfo($_SERVER['REQUEST_URI'])
         * pathinfo['basename'] => 'form'
         */
        $page = $path_info['basename'];
        //Принятие HTTP-запроса методом POST от js, обрабатывающего событие кнопки отправки
        $_POST = json_decode(file_get_contents("php://input"), true);
        if (isset($_POST['submit']) and mb_strtolower($_POST['submit']) == 'send') $page = 'send';

        switch ($page) {
            case 'form':
                $result = $this->formAction();
                break;
            case 'list':
                $result = $this->listAction();
                break;
            case 'send':
                $result = $this->sendAction();
                break;
            default:
                $ssl = 'http';
                if(isset($_SERVER['HTTPS'])) $ssl = 'https';
                $host = $_SERVER['HTTP_HOST'];
                $url = pathinfo($_SERVER['PHP_SELF']);
                $url = $url['dirname'];
                header('Location: '.$ssl.'://'.$host.$url.'/form');
                $result = null;
        }

        if (!is_null($result)) {
            require_once __DIR__ . '/../template/header.php'; //хедэр
            echo $result;                                     //контент
            require_once __DIR__ . '/../template/footer.php'; //футор
        }
    }

    /**
     * Вызывается на запрос GET /form
     *
     * todo Показ формы
     *
     * @return string
     */
    protected function formAction(): string {
        return <<<HTML
                <div class = 'InputForm'>
                    <form name = 'form' accept-charset="utf-8">
                        <h2>Form</h2>
                        <p>Name: <input type = 'text' name ='name' placeholder="Name" value=''/></p>
                        <p>Mail: <input type = 'text' name ='mail' placeholder="Mail" value='' /></p>
                        <p>Link: <input type = 'text' name ='link' placeholder="Link" value='' /></p>
                        <input class = 'send' type = 'button' value = 'Send' id = 'send'/>
                        </form>
                    </form>
                </div>
                HTML;
    }

    /**
     * Вызывается на запрос GET /list
     *
     * todo Показ списка сохранённых в базу форм
     *
     * @return string
     */
    protected function listAction(): string
    {
        $database = new Database();
        $table = <<<HTML
                        <table>
                            <thead>
                                <tr>
                                    <th class = 'LeftTd'>Name</th>
                                    <th>Mail</th>
                                    <th class = 'RightTd'>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                    HTML;
        $result = $database->getQuerySelect();//выполняется запрос на выборку данных из БД
        while ($row = $result->fetchArray()) //выводятся все данные в структуру table HTML
        {
            $table = $table.<<<HTML
                            <tr>
                                <td class = 'LeftTd'>{$row['name_user']}</td>
                                <td>{$row['mail_user']}</td>
                                <td class = 'RightTd'>{$row['link_user']}</td>
                            </tr>
                        HTML;
        }
        $table = $table."</tbody></table>";
        return $table;
    }

    /**
     * Вызывается на запрос POST /send
     *
     * todo Обработка и сохранение данных формы, ответ в формате json с обработкой на js
     *
     * @return string
     */
    protected function sendAction(): string
    {
        $post_cheked = $_POST['name'].$_POST['mail'].$_POST['link']; //переменная для валидации введённых данных
        if($post_cheked == '') {                                    //если ничего не введено
            $message = 'You have not entered the data.';
        }
        elseif (                                                    //защита от SQL-инъекций и XSS атак
            preg_match('/-{2}/', $post_cheked) or
            preg_match('/\'/', $post_cheked) or
            preg_match('/\"/', $post_cheked) or
            preg_match('/\/\*/', $post_cheked) or
            preg_match('/\*\//', $post_cheked) or
            preg_match('/</', $post_cheked) or
            preg_match('/>/', $post_cheked)
        ) {
            $message = 'You have entered invalid characters.';
        }
        else{
            // запись в базу $database->query()
            (new Database())->addData($_POST['name'], $_POST['mail'], $_POST['link']);
            $message = 'Thanks, '.$_POST['name'].'. Your data is recorded.';
        }
        //формируется ответ на запрос и передаётся message
        header('Content-Type: text/html;charset=UTF-8');
        header('Message:'.$message);
        /*header('Content-Type: application/json;charset=utf-8');
        //header('Content-Type: text/html;charset=UTF-8');
        //echo json_encode(array('message' => $message));
        //echo json_encode($message);
        header('Message:'.json_encode($message, JSON_UNESCAPED_UNICODE));*/

        return '';
    }
}
