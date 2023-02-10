<?php

namespace Felix\StudyProject;

use SQLite3;

class Database extends SQLite3
{
    protected string $databaseDir = __DIR__ . '/../db/sqlite.db';

    function __construct()
    {
        parent::__construct($this->databaseDir, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    }

    public function addData($name, $mail, $link) //запись в таблицу БД
    {
        $addDataSql = <<<SQL
                            INSERT INTO Result (name_user, mail_user, link_user) VALUES (:name, :mail, :link);
                        SQL; //запрос на запись введеных данных в таблицу Result
        $stmt = $this->prepare($addDataSql); //подготовка данных
        //указывается, в какой столбец записывать входные данные
        $stmt->bindParam(':name', $name, SQLITE3_TEXT);
        $stmt->bindParam(':mail', $mail, SQLITE3_TEXT);
        $stmt->bindParam(':link', $link, SQLITE3_TEXT);
        $stmt->execute(); //выполяется запрос
        $stmt->close();
    }

    public function getQuerySelect(): object //выполняется запрос на выборку данных из таблицы Result
    {
        $selectDataSql = <<<SQL
                                SELECT * FROM Result;
                            SQL;
        return $this->query($selectDataSql);
    }
}
