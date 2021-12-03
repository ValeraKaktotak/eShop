<?php

class Cart{

    //добавление товара в корзину(сессию)
    public static function addProduct($id){
        $id = intval($id);

        //пустой массив для товаров в корзине
        $productsInCart = array();

        //Если в корзине есть товары (они хранятся в сессии)
        if(isset($_SESSION['products'])){
            //То заполним наш массив этими товарами
            $productsInCart = $_SESSION['products'];
        }

        //Если товар уже есть в корзине, но был добавлен еще раз, увеличим кол-во
        if(array_key_exists($id, $productsInCart)){
            $productsInCart[$id] ++;
        }else{
            //добавляем товар в корзину
            $productsInCart[$id] = 1;
        }
        $_SESSION['products'] = $productsInCart;

        return self::countItems();

    }

    //подсчет товаров в корзине(в сессии)
    public static function countItems(){
        if(isset($_SESSION['products'])){
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity){
                $count = $count + $quantity;
            }
            $a = "($count)";
            return $a;
        }else{
            return 0;
        }
    }

    //достаем инфу из сессии об айди и кол-ве товаров в корзине(если они там есть)
    public static function getProducts(){
        if(isset($_SESSION['products'])){
            //session_destroy();
            return $_SESSION['products'];
        }
        return false;
    }

    //подсчитываем общую стоймость продуктов в корзине
    public static function getTotalPrice($products){
        $productsInCart = self::getProducts();
        $total = 0;

        if($productsInCart){
            foreach($products as $item){
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }

    //очищаем карзину
    public static function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

}