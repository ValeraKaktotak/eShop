<?php

class Order{

    public static function save($userName, $userPhone, $userComment, $userId, $productsInCart){

        //конвертируем массив в строку
        $productsInCart = json_encode($productsInCart);

        $db = Db::getConnections();
        $sql = "INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) VALUES (:userName, :userPhone, :userComment, :userId, :productsInCart)";

        $result = $db->prepare($sql);
        $result->bindParam(':userName', $userName, PDO::PARAM_STR);
        $result->bindParam(':userPhone', $userPhone, PDO::PARAM_INT);
        $result->bindParam(':userComment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':productsInCart', $productsInCart, PDO::PARAM_INT);
        return $result->execute();
    }
}