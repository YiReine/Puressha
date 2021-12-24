<?php
include("myHelper.php");
$user = confirmLogin();
if(!$user) header('location:../puressha');
?><?php
include("../handleData/helpers/format.php");
$fm = new Format();

include("../handleData/classes/sanpham.php");
include("../handleData/classes/chitietsanpham.php");


$prod = new sanpham();
$prodD = new chitietsanpham();

$cart = array();

$cart = array();
if(checkCart()){
	$cart = $_SESSION["cart"];
	$check = 1;
}
else $check = 0;

$total=0;
$amount=0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Essence</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.php"><img src="img/core-img/logo.png" alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="shop.php">Shop</a>
                                <div class="megamenu">
                                    <ul class="single-mega cn-col-4">
                                        <li><a href="shop.php">Danh mục</a></li>
                                    </ul>
                                    <div class="single-mega cn-col-4">
                                        <img src="img/bg-img/bg-6.jpg" alt="">
                                    </div>
                                </div>
                            </li>
                            <li><a href="order.php" style="<?php if(!$user) echo'display: none'?>">Order</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                
                <!-- User Login Info -->
                <div class="user-login-info classynav">
                    <ul><li><a href="#"><img src="img/core-img/user.svg" alt=""></a>
					<ul class="dropdown" style="<?php if($user) echo'display: none'?>">
                                    <li><a href="../customer/login.php">Login</a></li>
                                    <li><a href="../customer/register.php">Register</a></li>
                    </ul>
					<ul class="dropdown" style="<?php if(!$user) echo'display: none'?>">
                                    <li></li>
                                    <li><a href="index.php">Profile</a></li>
                                    <li><a><form method="post" >
										<input style="border: 0; background: white" type="submit" name="submit" value="Logout"></form></a></li>
                    </ul></li></ul>
                </div>
				<?php 
				include("../customer/logout.php");
				?>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="img/core-img/bag.svg" alt=""> <span><?php echo count($cart)?></span></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="img/core-img/bag.svg" alt=""> <span><?php echo count($cart)?></span></a>
        </div>

        <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list">
                <!-- Single Cart Item -->
                
                <!-- Single Cart Item -->
				<?php
				if (!$check) echo "<p><strong>Chưa có mặt hàng được chọn vào giỏ hàng</strong></p>";
				else {
					foreach($cart as $c){
						$productC = $prod->getByMSP($c[0]);
						$pC = $productC->fetch_assoc();
						
						$productCD = $prodD->getByMCTSP($c[1]);
						$pCD = $productCD->fetch_assoc();
						echo '<div class="single-cart-item">
								<div class="product-image">
									<img src="img/product-img/'.$pCD['ANH'].'" class="cart-thumb" alt="">
									<!-- Cart Item Desc -->
									<div class="cart-item-desc">
									  <span class="product-remove"><form method="post" >
													<input type="hidden" name="prodD" value="'.$pCD['MCTSP'].'">
													<button style="border: none; background: none"
														   type="submit" name="button" value="Del to Cart"><i class="fa fa-close" aria-hidden="true"></i></button></form></span>
										<h6><a href="detail.php?'.$pCD['MCTSP'].'">'.$pC['TEN'].'</a></h6>
										<p class="size">Size: '.$pCD['SIZE'].'</p>
										<p class="color">Color: '.$pCD['MAU_SAC'].'</p>
										<p class="color">Qty: '.$c[2].'</p>
										<p class="price">'.$fm->format_currency($pCD['GIA_BAN']).' VND</p>
									</div>
								</div>
							</div>';
						
						$total=$total+$pCD['GIA_BAN']*$c[2];
						$amount= $amount + $c[2];
						}
					}
                
				?>
            </div>
			<!-- Cart Summary -->
            <div class="cart-amount-summary" >

                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>amount:</span> <span><?php echo $amount?></span></li>
                    <li><span>total:</span> <span><?php echo $fm->format_currency($total)?> VND</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="checkout.php<?php ?>" class="btn essence-btn">check out</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Right Side Cart End ##### -->

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Checkout Area Start ##### -->
    <?php
		include("../handleData/classes/khachhang.php");
		$cus = new khachhang();
		$customer = $cus->getByMKH($_SESSION['myid']);
		$c = $customer->fetch_assoc();
	?>
    <div class="checkout_area section-padding-80">
        <div class="container">
		<form action="#" method="post">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="checkout_details_area mt-50 clearfix">

                        <div class="cart-page-heading mb-30">
                            <h5>Billing Address</h5>
                        </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name_cus">Tên khách hàng<span>*</span></label>
                                    <input type="text" class="form-control" id="name_cus" name="name_cus" value="<?php echo $c['TEN']?>" required> 
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sdt">Số điện thoại<span>*</span></label>
                                    <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo $c['SDT']?>" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="address">Địa chỉ<span>*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $c['DIA_CHI']?>">
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <div class="cart-page-heading">
                            <h5>Your Order</h5>
                            <p>The Details</p>
                        </div>
							
                        <ul class="order-details-form mb-4">
                            <li><span>Sản phẩm</span><span>Số lượng</span><span>Giá</span><span>Thành tiền</span></li>
                            <?php
							foreach($cart as $c){
								$sp = $prod->getByMSP($c[0]);
								$spC = $sp->fetch_assoc();
						
								$productCD = $prodD->getByMCTSP($c[1]);
								$pCD = $productCD->fetch_assoc();
								
                           echo'<li>
                            	<ul><li style = "width: 80px">'.$spC['TEN'].'</li></ul>
                                <ul><li>'.$c[2].'</li></ul>
                                <ul><li>'.$fm->format_currency($pCD['GIA_BAN']).'</li></ul>
                                <ul><li>'.$fm->format_currency($pCD['GIA_BAN']*$c[2]).'</li></ul>
                            </li>';
							}
							?>
                            <li><span>Phí ship</span> <span>Miễn phí</span></li>
                            <li><span>Tổng tiền</span> <span style="color:#F00"><?php echo $fm->format_currency($total)?> VND</span></li>
                        </ul>

                        <div id="accordion" role="tablist" class="mb-4">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h6 class="mb-0">
                                        <input class="form-check-input" type="radio" name="checkout" id="cash" value="CASH">
                                         <label for="cash">CASH</label>
                                    </h6>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingTwo">
                                    <h6 class="mb-0">
                                      <input class="form-check-input" type="radio" name="checkout" id="creditcart" value="CREDIT CARD">
                                       <label for="creditcart">CREDIT CARD</label>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <?php  //include("saveOrder.php"); ?>
						<input type="submit" class="btn btn-secondary btn btn-danger"  name="submit" value="Order">
                    </div>
                </div>
            </div>
           </form>
        </div>
    </div>
    
    <!-- ##### Checkout Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.html">Shop</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                            <h6>Subscribe</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your email here">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

<div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
            
        </div>


    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Classy Nav js -->
    <script src="js/classy-nav.min.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>