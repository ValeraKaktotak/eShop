<?php

/**
 * Контроллер AdminController
 * Главная страница в админпанели
 */

class AdminController extends AdminBase{

    //екшен для стартовой страницы админ панели
    public function actionIndex()
    {
        //проверка доступа из абстрактного родительского класса AdminBase
        self::checkAdmin();

        //подключаем вид(страничку)
        require_once(ROOT.'/views/admin/index.php');
        return true;
    }


}

class PageTitle {
    const TITLE = 'Админка';

}