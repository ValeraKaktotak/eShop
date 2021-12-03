<?php

class CartController{

    //аджакс запрос на добавление товаров в корзину
    public function actionAddAjax($id){

        //добавляем товар в корзину
        echo Cart::addProduct($id);
        //echo Cart::countItems();
        return true;
    }

    //страница корзины
    public function actionIndex(){
        $categories = array();
        $categories = Category::getCategoriesList();

        $productsInCart = false;

        //Получим данные из корзины
        $productsInCart = Cart::getProducts();

        if($productsInCart){

            //получаем массив ключей(ID)
            $productsIds = array_keys($productsInCart);

            //Получаем полную информацию о товарах для списка товаров
            $products = Product::getProductsByIds($productsIds);

            //получаем общуу стоймость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once (ROOT.'/views/cart/index.php');

        return true;

    }

    //удаление товара с корзины
    public function actionDelete($id)
    {
        // Удалить товар из корзины
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products'][$id]);
        }
        // Возвращаем пользователя на страницу
        header("Location: http://eshop/cart");
    }

    //оформление заказа
    public function actionCheckout()
    {
        // Список категорий для левого меню категорий
        $categories = array();
        $categories = Category::getCategoriesList();


        // Статус успешного оформления заказа
        $result = false;


        // Форма отправлена?
        if (isset($_POST['submit'])) {
            // Форма отправлена? - Да
            // Считываем данные формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // Валидация полей
            $errors = false;
            if (!User::checkName($userName))
                $errors[] = 'Неправильное имя';
            if (!User::checkPhone($userPhone))
                $errors[] = 'Неправильный телефон';

            // Форма заполнена корректно?
            if ($errors == false) {
                // Форма заполнена корректно? - Да
                // Сохраняем заказ в базе данных
                // Собираем информацию о заказе
                $productsInCart = Cart::getProducts();
                if (User::isGuest()) {
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }

                // Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    // Оповещаем администратора о новом заказе
                    $adminEmail = 'valerakaktotak@gmail.com';
                    $message = 'http://eshop/admin/orders';
                    $subject = 'Новый заказ!';
                    mail($adminEmail, $subject, $message);

                    // Очищаем корзину
                    Cart::clear();
                }
            } else {
                // Форма заполнена корректно? - Нет
                // Итоги: общая стоимость, количество товаров
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        }
        else {
            // Форма отправлена? - Нет
            // Получием данные из корзины
            $productsInCart = Cart::getProducts();

            // В корзине есть товары?
            if ($productsInCart == false) {
                // В корзине есть товары? - Нет
                // Отправляем пользователя на главную искать товары
                header("Location: /");
            } else {
                // В корзине есть товары? - Да
                // Итоги: общая стоимость, количество товаров
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();


                $userName = false;
                $userPhone = false;
                $userComment = false;

                // Пользователь авторизирован?
                if(User::isGuest()) {
                    // Нет
                    // Значения для формы пустые
                } else {
                    // Да, авторизирован
                    // Получаем информацию о пользователе из БД по id
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    // Подставляем в форму
                    $userName = $user['name'];
                }
            }
        }
        require_once(ROOT . '/views/cart/checkout.php');

        return true;
    }
}

class PageTitle {
    const TITLE = 'Корзина';

}

