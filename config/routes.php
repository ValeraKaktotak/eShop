<?php

    return array(
        'product/([0-9]+)' => 'product/view/$1',  //actionView($1) в ProductController    -    открывает выбранный товар
        'catalog' => 'catalog/index',  //  actionIndex в CatalogController    -    открыват каталог(общий)
        'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',   //actionCategory($1)($2) в CatalogController   -  пагинатор(странички)
        'category/([0-9]+)' => 'catalog/category/$1',  //actionCategory($1) в CatalogController   -   открывает товары выбраной категории

        'user/register' => 'user/register',    //actionRegister в UserController    -открывает страницу регистрации
        'user/login' => 'user/login',    //actionLogin в UserController    -проверка данных и переход в ЛК(если все норм)
        'user/logout' => 'user/logout',    //actionLogout в UserController    -проверка данных и переход в ЛК(если все норм)

        'account/edit' => 'account/edit',    // actionEdit в AccountController   -редактирование данных пользователя в личном кабинете
        'account' => 'account/index',    // actionIndex в AccountController   -личный кабинет

        'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1',  //actionAddAjax($1) в CartController   -   добавляем товар в корзину(AJAX запрос в футере)
        'cart/checkout' => 'cart/checkout',   // оформление заказа
        'cart/delete/([0-9]+)' => 'cart/delete/$1',   //actionDelete($i) в CartController    -    удаление товара с корзины
        'cart' => 'cart/index',   //actionIndex в CartController   -   корзина

        'contacts' => 'site/contact',     //actionContact в SiteController    -контакты

        // Управление товарами:
        'admin/product/create' => 'adminProduct/create',
        'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
        'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
        'admin/product' => 'adminProduct/index',
        // Управление категориями:
        'admin/category/create' => 'adminCategory/create',
        'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
        'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
        'admin/category' => 'adminCategory/index',
        // Управление заказами:
        'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
        'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
        'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
        'admin/order' => 'adminOrder/index',
        // Админпанель:
        'admin' => 'admin/index',   //- главная страница в админке

        'page-([0-9]+)' => 'site/index/$1',  // actionIndex в SiteController  -пагинатор на главной
        '' => 'site/index' // actionIndex в SiteController


    );