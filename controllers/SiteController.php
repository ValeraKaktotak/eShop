<?php
//заменили автоподключением Autoloader.php
/*
include_once ROOT.'/models/Category.php';
include_once ROOT.'/models/Product.php';
*/

    class SiteController{

        public function actionIndex($page = 1){

            $categories = array();
            $categories = Category::getCategoriesList();

            $latestProducts = array();
            $latestProducts = Product::getLatestProductPagination($page);

            //метод для заполнения слайдера
            $sliderItems = array();
            $sliderItems = Product::getRecommendedProduct();

            $total = Product::getTotalProductsInSite();

            //Создаем объект Pagination постраничная пагинация
            $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

            require_once (ROOT.'/views/site/index.php');
            return true;
        }

        public function actionContact(){
            $userEmail = '';
            $userText = '';
            $result = false;

            if(isset($_POST['submit'])){
                $userEmail = $_POST['userEmail'];
                $userText = $_POST['userText'];
                $errors = false;

                //Валидация полей
                if(!User::checkEmail($userEmail)){
                    $errors[] = 'Не правильный формат email адреса';
                }

                if($errors == false){
                    $adminEmail = 'valerakaktotak@gmail.com';
                    $massage = "Текст: {$userText}. От {$userEmail}";
                    $subject = 'Тема письма';
                    $result = mail($adminEmail, $subject, $massage);
                    $result = true;
                }
            }
            require_once (ROOT.'/views/site/contact.php');
            return true;
        }
    }






    class PageTitle{
        const TITLE = 'Главная';
    }