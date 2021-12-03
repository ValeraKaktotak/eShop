<?php

class Product
{
    const SHOW_BY_DEFAULT = 6;

    //вывод товаров на страницу
    public static function getLatestProduct($count = self::SHOW_BY_DEFAULT)
    {

        $count = intval($count);
        $db = DB::getConnections();
        $productList = array();
        $result = $db->query('SELECT id, name, price, image, is_new FROM product '
            . 'WHERE status = "1" '
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count);
        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['image'] = $row['image'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;
    }

    //вывод всех товаров
    public static function getProductsList()
    {

        $db = DB::getConnections();
        $productList = array();
        $result = $db->query('SELECT id, name, price, code FROM product ORDER BY id ASC');
        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['code'] = $row['code'];
            $productList[$i]['price'] = $row['price'];
            $i++;
        }

        return $productList;
    }

    //вывод товаров на страницу с учетом пагинатора
    public static function getLatestProductPagination($page, $count = self::SHOW_BY_DEFAULT)
    {

        $count = intval($count);
        $db = DB::getConnections();
        $page = ($page -1) * self::SHOW_BY_DEFAULT;
        $productList = array();
        $result = $db->query('SELECT id, name, price, image, is_new FROM product '
            . 'WHERE status = "1" '
            . 'ORDER BY id DESC '
            . 'LIMIT ' . $count.' OFFSET '.$page);
        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['image'] = $row['image'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;
    }

    //запрос продуктов для слайдера
    public static function getRecommendedProduct(){

        $db = DB::getConnections();
        $productList = array();
        $result = $db->query('SELECT id, name, price, image, is_new FROM product '
            . 'WHERE is_recommended = "1"');
        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['image'] = $row['image'];
            $productList[$i]['price'] = $row['price'];
            $productList[$i]['is_new'] = $row['is_new'];
            $i++;
        }

        return $productList;
    }

    //вывод товаров на странице категории с учетом пагинатора
    public static function getProductsListByCategory($categoryId = false, $page)
    {
        $page = intval($page);
        if ($categoryId && $page > 0) {

            $offset = ($page -1) * self::SHOW_BY_DEFAULT;

            $db = DB::getConnections();
            $products = array();
            $result = $db->query('SELECT id, name, price, image, is_new FROM product '
                                        .'WHERE status = "1" AND category_id = '.$categoryId
                                        .' ORDER BY id DESC LIMIT '.self::SHOW_BY_DEFAULT
                                        .' OFFSET '.$offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }
        else{
            $page =1;
            $offset = ($page -1) * self::SHOW_BY_DEFAULT;

            $db = DB::getConnections();
            $products = array();
            $result = $db->query('SELECT id, name, price, image, is_new FROM product '
                .'WHERE status = "1" AND category_id = '.$categoryId
                .' ORDER BY id DESC LIMIT '.self::SHOW_BY_DEFAULT
                .' OFFSET '.$offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }

            return $products;
        }

    }

    //вывод выбранного товара
    public static function getProductById($id){

        $db = DB::getConnections();
        $product = array();
        $result = $db->query('SELECT * FROM product WHERE id= '.$id);

        return $result->fetch(MYSQLI_ASSOC);

    }

    //метод для определение общего количества товаров в категории
    public  static function getTotalProductsInCategory($categoryId){

        $page = array();
        $db = Db::getConnections();
        $result = $db->query('SELECT count(id) AS count FROM product '
                                    .'WHERE status="1" AND category_id = '.$categoryId);


        $page = $result->fetch(MYSQLI_ASSOC);

        return $page['count'];

    }

    //метод для определение общего количества товаров (вне зависимости от категории)
    public  static function getTotalProductsInSite(){

        $page = array();
        $db = Db::getConnections();
        $result = $db->query('SELECT count(id) AS count FROM product '
            .'WHERE status="1"');


        $page = $result->fetch(MYSQLI_ASSOC);

        return $page['count'];

    }

    //получаем полную инфу о товарах в корзине
    public static function getProductsByIds($idsArray){
        $products = array();

        $db = Db::getConnections();
        //конвертируем массив в строку
        $idsArray = implode(',', $idsArray);

        $sql = "SELECT * FROM product WHERE status = '1' AND id IN ($idsArray)";

        $result = $db->query($sql);
        $result-> setFetchMode(PDO::FETCH_ASSOC);


        $i = 0;
        while($row = $result->fetch()){
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    //удаление товара по айди
    public static function deleteProductById($id){

        //соеденяем с БД
        $db = Db::getConnections();
        //текст запроса к Бд
        $sql = 'DELETE FROM product WHERE id = :id';
        //используем подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        //возвращаем результат true или false
        return $result->execute();
    }

    //Добавление товара в БД
    public static function createProduct($options){
        //соеденяем с БД
        $db = Db::getConnections();

        //текст запроса к БД
        $sql = 'INSERT INTO product'
                .' (name, code, price, category_id, brand, availability,'
                .' description, is_new, is_recommended, status)'
                .' VALUES'
                .' (:name, :code, :price, :category_id, :brand, :availability,'
                .' :description, :is_new, :is_recommended, :status)';

        //получение и возврат результатов, используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam('name', $options['name'], PDO::PARAM_STR);
        $result->bindParam('code', $options['code'], PDO::PARAM_INT);
        $result->bindParam('price', $options['price'], PDO::PARAM_INT);
        $result->bindParam('category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam('brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam('availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam('description', $options['description'], PDO::PARAM_STR);
        $result->bindParam('is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam('is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam('status', $options['status'], PDO::PARAM_INT);
        if($result->execute()){
            //если запрос добавлен успешно возвращает айди данной записи
            return $db->lastInsertId();
        }
        return 0;

    }
}