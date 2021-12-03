<?php

//управление товарами в админке

class AdminProductController extends AdminBase {

    //екшен для страницы управления товарами(главная)
    public function actionIndex(){

        //проверка доступа
        self::checkAdmin();

        //получаем список товаров
        $productsList = Product::getProductsList();

        //подключаем вид
        require_once (ROOT.'/views/admin_product/index.php');
        return true;
    }

    //екшен для удаление товара с БД
    public function actionDelete($id){

        //проверка доступа
        self::checkAdmin();

        //получаем данные товара по айди(в виде нужно название удаляемого товара)
        $product = Product::getProductById($id);

        //обработка формы
        if(isset($_POST['submit'])){
            //если форма отправлена удаляем товар
            Product::deleteProductById($id);

            //перенаправляем пользователя на страницу управления товарами
            header("Location: /admin/product");
        }

        require_once (ROOT.'/views/admin_product/delete.php');
        return true;
    }

    //екшен для добавления товара в БД
    public function actionCreate(){

        //проверка доступа
        self::checkAdmin();

        //получаем список(массив) категорий для выпадающего списка в виде
        $categoriesList = category::getCategoriesListAdmin();

        //создаем массив для данных с формы
        $options = array();

        //обработка формы
        if(isset($_POST['submit'])){
            //если форма отправлена получаем данные из формы
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];
        }

        //флаг ошибок в форме
        $errors = false;

        //валидация значений(для примера)
        if(!isset($options['name']) || empty($options['name'])){
            $errors = 'заполните поля';
        }

        //добавляем товар в БД
        if($errors == false){
        //Если ошибок нет добавляем новый товар
            $id = Product::createProduct($options);

            //если запись добавлена
            if($id){
                //проверим загружалось ли через форму изображение
                if(is_uploaded_file($_FILES["image"]["tmp_name"])){
                    //если загружалось переместим его в нужную папку и дадим новое имя
                    move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/upload/images/");
                }
            }
            //перенаправляем пользователя 6на страницу управления товарами
            header("Location: /admin/product");
        }

        //подключаем вид
        require_once (ROOT.'/views/admin_product/create.php');
        return true;
    }

    //екшен для редактирования товара в БД
    public function actionUpdate($id){

        //проверка доступа
        self::checkAdmin();

        //получаем список(массив) категорий для выпадающего списка в виде
        $categoriesList = category::getCategoriesListAdmin();

        //получаем данные по конкретному товару
        $product = Product::getProductById($id);

        //создаем массив для данных с формы
        $options = array();

        //обработка формы
        if(isset($_POST['submit'])){
            //если форма отправлена получаем данные из формы
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];
        }

        //флаг ошибок в форме
        $errors = false;

        //валидация значений(для примера)
        if(!isset($options['name']) || empty($options['name'])){
            $errors = 'заполните поля';
        }

        //добавляем товар в БД
        if($errors == false){
            //Если ошибок нет добавляем новый товар
            $id = Product::createProduct($options);

            //если запись добавлена
            if($id){
                //проверим загружалось ли через форму изображение
                if(is_uploaded_file($_FILES["image"]["tmp_name"])){
                    //если загружалось переместим его в нужную папку и дадим новое имя
                    move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/upload/images/");
                }
            }
            //перенаправляем пользователя 6на страницу управления товарами
            header("Location: /admin/product");
        }

        //подключаем вид
        require_once (ROOT.'/views/admin_product/update.php');
        return true;
    }
}