<?php

    class Category{

        /**
         * возвращает массив с категориями*/
        public static function getCategoriesList(){

            $db = Db::getConnections();

            $categoryList = array();

            $result = $db->query('SELECT id, name FROM category ORDER BY sort_order ASC');

            $i =0;
            while($row = $result->fetch()){
                $categoryList[$i]['id'] = $row['id'];
                $categoryList[$i]['name'] = $row['name'];
                $i++;
            }
            return $categoryList;
        }

        /**
         * Возвращает массив категорий для списка в админпанели <br/>
         * (при этом в результат попадают и включенные и выключенные категории)
         * @return array <p>Массив категорий</p>
         */
        public static function getCategoriesListAdmin(){

            $db = Db::getConnections();

            //соединение с БД
            $categoryList = array();

            $result = $db->query('SELECT *, name FROM category ORDER BY sort_order ASC');

            $i =0;
            while($row = $result->fetch()){
                $categoryList[$i]['id'] = $row['id'];
                $categoryList[$i]['name'] = $row['name'];
                $categoryList[$i]['sort_order'] = $row['sort_order'];
                $categoryList[$i]['status'] = $row['status'];
                $i++;
            }
            return $categoryList;
        }
    }