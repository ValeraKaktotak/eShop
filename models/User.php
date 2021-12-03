<?php

class User{

    //регистрируем нового пользователя (добавляем новую запись в БД)
    public static function register($name, $email, $password){
        $db = Db::getConnections();
        $sql = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();

    }

    //проверяем правильность данных в поле bame
    public static function checkName($name){
        if(strlen($name) >= 2){
            return true;
        }
        return false;
    }

    //проверяем правильность данных в поле password
    public static function checkPassword($password){
        if(strlen($password) >= 6){
            return true;
        }
        return false;
    }

    //проверяем правильность данных в поле email
    public static function checkEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

    //проверяем существование email в нашей базе
    public static function checkEmailExsist($email){
        $db = Db::getConnections();
        $sql = "SELECT COUNT(*) FROM user WHERE email = :email";

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        $db = null;
        $sql = null;

        if($result->fetchColumn()){
            return true;
        }
        return false;
    }

    //проверяем(по паролю и email) и возвращаем ID пользователя с нашей БД(если он есть)
    public static function checkUserData($email, $password){
        $db = Db::getConnections();
        $sql = "SELECT * FROM user WHERE email = :email AND password = :password";

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();

        $db = null;
        $sql = null;

        if($user){
            return $user['id'];
        }
        return false;
    }

    //запоминаем пользователя если он есть в нашей БД и он ввел норм значения
    public static function auth($userId){
        $_SESSION ['user'] = $userId;
    }

    //проверяем залогинился-ли пользователь
    public static function checkLogged(){
        //если сессия есть вернет идентификатор пользователя, или вернет на страницу входа
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }else{
            header("Location: /user/login");
        }
    }

    //Проверяет телефон: не меньше, чем 10 символов
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    //проверяем пользователь гость или уже вошел на свой аккаунт
    public static function isGuest(){
        if(isset($_SESSION['user'])){
            return false;
        }
        return true;
    }

    //получаем данные пользоватеья по айди
    public static function getUserById($id){
        if($id){
            $db = Db::getConnections();
            $sql = "SELECT * FROM user WHERE id = :id";

            $result = $db->prepare($sql);
            $result->bindParam('id', $id, PDO::PARAM_INT);

            //указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    //заменяем данные пользователя(имя и пароль) с ЛК
    public static function edit($id, $name, $password){
        $db = Db::getConnections();
        $sql = 'UPDATE user SET name = :name, password = :password WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->bindParam('name', $name, PDO::PARAM_STR);
        $result->bindParam('password', $password, PDO::PARAM_STR);

        return $result->execute();

    }
}


