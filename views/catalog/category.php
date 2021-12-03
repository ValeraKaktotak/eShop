<?php include ROOT.'/views/layouts/header.php'?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Каталог</h2>
                        <div class="panel-group category-products">
                            <?php foreach($categories as $categoryItem ): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="/category/<?php echo $categoryItem['id']; ?>" class="<?php if($categoryId == $categoryItem['id']) echo 'active'; ?>">
                                                <?php echo $categoryItem['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            <? endforeach; ?>

                        </div>

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Последние товары</h2>
                        <?php foreach($categoryProducts as $latestProductsItem ): ?>
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/template/images/shop/23_Dell_E2314H_Black.jpg" alt="" />
                                            <h2><?php echo $latestProductsItem['price']; ?></h2>
                                            <p><a href="/product/<?php echo $latestProductsItem['id']; ?>"><?php echo $latestProductsItem['name']; ?></a></p>
                                            <a href="/cart/addAjax/<?php echo $latestProductsItem['id']; ?>" data-id="<?php echo $latestProductsItem['id'];?>" class="btn btn-default add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                В корзину
                                            </a>
                                        </div>
                                        <?php if($latestProductsItem['is_new']): ?>
                                            <img src="/template/images/product-details/new.jpg" alt="#" class="new">
                                        <? endif; ?>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                    <!--features_items-->
                    <?php echo $pagination->get(); ?>

                </div>
            </div>
        </div>
    </section>
<?php include ROOT.'/views/layouts/footer.php'?>