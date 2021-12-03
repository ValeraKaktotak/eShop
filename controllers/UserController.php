<?php
//заменили автоподключением Autoloader.php (User.php)

    class UserController{

        public function actionRegister(){

            $name = '';
            $email = '';
            $password = '';
            $result = false;

            if(isset($_POST['submit'])){
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $errors = false;

                if(!User::checkName($name)){
                    $errors[] = 'Имя введено не верно';
                }

                if(!User::checkEmail($email)){
                    $errors[] = 'Email введен не верно';
                }

                if(!User::checkPassword($password)){
                    $errors[] = 'Пароль введен не верно';
                }

                //Проверка email на существование
                if(User::checkEmailExsist($email)){
                    $errors[] = 'Такой email уже существует';
                }

                if($errors == false){
                    $result = User::register($name, $email, $password);
                }
            }

            require_once (ROOT.'/views/user/register.php');

            return true;
        }

        public function actionLogin(){
            $email = '';
            $password = '';

            if(isset($_POST['submit'])){
                $email = $_POST['email'];
                $password = $_POST['password'];

                $errors = false;

                //Валидация полей ввода данных
                if(!User::checkEmail($email)){
                    $errors[] = 'Email введен не верно';
                }
                if(!User::checkPassword($password)){
                    $errors[] = 'Пароль введен не верно';
                }

                //Проверка существует ли пользователь
                $userId = User::checkUserData($email, $password);
                if($userId == false){
                    $errors[] = 'Не верные данные для входа на сайте';
                }
                else{
                    //если данные верные, запоминаем пользователя Сессия
                    User::auth($userId);
                    //перенаправляем в закрытую часть - кабинет
                    header("Location: /account");
                }
            }

            require_once (ROOT.'/views/user/login.php');

            return true;
        }

        //удаляем данные для входа из сессии
        public function actionLogout(){
            unset($_SESSION['user']);
            header("Location: /");
        }

    }

class PageTitle{
    const TITLE = 'Личный кабинет';
}