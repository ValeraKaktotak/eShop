<?php


class Db{

    public static function getConnections(){

        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $host = $params['host'];
        $db   = $params['dbname'];
        $user = $params['user'];
        $pass = $params['password'];
        $charset = 'utf8';

        /*
         * устаревший тип подключения через mysqli
         *
        $db = new mysqli($params['host'], $params['user'],$params['password'], $params['dbname']);
        if(mysqli_connect_errno()){
            return 'Соединение с базой данных не установлено'.mysqli_connect_error();
        }
        return $db;
        */

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);

        return $pdo;
    }
}