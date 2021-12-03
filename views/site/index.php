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
                                    <a href="/category/<?php echo $categoryItem['id']; ?>">
                                        <?php echo $categoryItem['name']; ?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Последние товары</h2>
                    <?php foreach($latestProducts as $latestProductsItem ): ?>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="/template/images/shop/23_Dell_E2314H_Black.jpg" alt="" />
                                    <h2><?php echo $latestProductsItem['price']; ?></h2>
                                    <p><a href="/product/<?php echo $latestProductsItem['id']; ?>"><?php echo $latestProductsItem['name']; ?></a></p>
                                    <a href="/cart/addAjax/<?php echo $latestProductsItem['id']; ?>" data-id="<?php echo $latestProductsItem['id'];?>"
                                       class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        В корзину
                                    </a>
                                </div>
                                <?php if($latestProductsItem['is_new']): ?>
                                <img src="/template/images/product-details/new.jpg" alt="#" class="new">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div><!--features_items-->
                <?php echo $pagination->get(); ?>

                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">Рекомендуемые товары</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $i = 0; foreach ($sliderItems as $product): ?>

                                <div class="item <?php if ($i == 0) echo 'active'; $i++; ?>">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="/template/images/shop/<?php echo $product['image'];?>" alt="" />
                                                    <h2><?php echo $product['price'];?></h2>
                                                    <p>
                                                        <a href="/product/<?php echo $product['id'];?>">
                                                            <?php echo $product['name'];?>
                                                        </a>
                                                    </p>
                                                    <a href="#" class="btn btn-default add-to-cart" data-id="<?php echo $product['id'];?>><i class="fa fa-shopping-cart"></i>В корзину</a>
                                                </div>
                                                <?php if ($product['is_new']): ?>
                                                    <img src="/template/images/home/new.png" class="new" alt="" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div><!--/recommended_items-->

            </div>
        </div>
    </div>
</section>
<?php include ROOT.'/views/layouts/footer.php'?>