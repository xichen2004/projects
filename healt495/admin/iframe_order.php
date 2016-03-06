<?
include('../inc/db.php');
$invoice_id = $_POST['order_id'];
$user_email = $_POST['user_email'];
	$order = mysqli_query($db, "SELECT * FROM order_id WHERE invoice='$invoice_id' AND user='$user_email'");
		$order = mysqli_fetch_assoc($order);
		$user = $order['user'];
		$product = $order['product'];
		$amount = $order['amount'];
		$bname = $order['bname'];
		$sname = $order['sname'];
		$bemail = $order['bemail'];
		$semail = $order['semail'];
		$shipping_price = $order['shipping_price'];
		$coupon = $order['coupon'];
		$baddress = $order['baddress'];
		$saddress = $order['saddress'];
		$comment = $order['comment'];
		$btel = $order['btel'];
		$stel = $order['stel'];
		$subtotal = $order['subtotal'];
		$total = $order['total'];
		$currency_code = $order['currency_code'];
		$is_same_shipping = $order['is_same_shipping'];
		$token = $order['token'];
		$invoice = $order['invoice'];
		$date_created = $order['date_created'];
		$status = $order['status'];
		$currency_rate = $order['currency_rate'];	
		if ($currency_code == "rmb") {
			$symbol = "¥";
		} else {
			$symbol = "$";
		}
		$coupon_result = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM coupon WHERE code='$coupon'"));
		$coupon_result = $coupon_result['discount'];
		$discount_price = $subtotal- $total;
		
		$product_exploded = explode(',',$product);
		$amount_exploded = explode(',',$amount);
		
		$number_or_product = count($product_exploded);
		
		if ($is_same_shipping == "true") {
			$address = $baddress;
		}else {
			$address = $saddress;
		}
								if ($zh == "yes") {
									$bname = "$last_name$first_name";
								}else {
									
								}
?>
<html lang="en" class="no-js"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>Health Supplements Plus</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory-->
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/custom.css">
    <link rel="stylesheet" href="./styles/vendor.css">
    <script src="./scripts/vendor/modernizr.js"></script>
    <!-- GMaps api-->
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
  </head>
  <body style="background-color:white; padding:15px;">
   <strong><ul class="list-inline">
    <li><a href="#" id="english_order" class="btn btn-success">English Invoice</a></li>
    <li><a href="#" id="chinese_order" class="btn btn-success">Chinese Invoice</a></li>
  </ul></strong><hr>
      <div id="english_tab">
        <!-- main start -->
        <!-- ================ -->
        <div class="main col-md-12">

            <div id="invoice-container" class="invoice-container">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="../images/logo_purple.png" height="35px" width="150px" alt="HSP">
                        <p class="invoice-slogan">Health Supplements Plus</p>
                        <address class="small">
                            <strong>Health Supplements Plus</strong><br>
                            <abbr title="Phone">P:</abbr> (403) 401-5701<br>
                            E-mail: <a href="mailto:admin@healthsupplementsplus.com">admin@healthsupplementsplus.com</a>
                        </address>
                    </div>
                    <?

                    ?>
                    <div class="col-sm-offset-3 col-sm-3">
                        <p class="text-right small"><strong>Invoice: </strong><?echo $invoice?><br><strong>Order Status: </strong><?echo $status?><br/> <?echo $date_created?></p>
                        <h5 class="text-right">Client</h5>
                        <p class="text-right small">
                            <strong>Name:</strong> <span><?echo $bname;?></span> <br>
                            <strong>Address:</strong> <?echo $baddress?> <br>
                            <strong>Tel:</strong> <?echo $btel?> <br>
                        </p>
                    </div>
                </div>
                <p class="small"><strong>Comments:</strong> 
                <?if (empty($comment)){
                    echo "N/A";
                }else {
                    echo $comment;
                }
                ?>
                </p>
                <table class="table cart table-bordered">
                    <thead>
                        <tr>
                            <th>Product Description </th>
                            <th>Price </th>
                            <th>Quantity</th>
                            <th class="amount">Total </th>
                        </tr>
                    </thead>
                    <tbody>

                    <?

                        for ($i= 0; $i < $number_or_product; $i++) {


                            $get_product_sql = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM product WHERE id='$product_exploded[$i];'"));
                            $product_name = $get_product_sql['name'];
                            $product_price = $get_product_sql['price']*(1-$get_product_sql['discount']);
                    ?>

                        <tr>
                            <td class="product"><?echo $product_name?></a></td>
                            <td class="price"><?echo $symbol;?><?echo number_format($product_price*$currency_rate,2)?> </td>
                            <td class="quantity"><?echo $amount_exploded[$i] ?> </td>
                            <td class="amount"><?echo $symbol;?><?echo number_format($product_price*$currency_rate*$amount_exploded[$i],2)?> </td>
                        </tr>											

                    <?
                        }

                    ?>

                        <tr>
                            <td class="total-quantity" colspan="3">Subtotal</td>
                            <td class="amount"><?echo $symbol?><?echo number_format($subtotal*$currency_rate,2);?></td>
                        </tr>
                        <?
                        if (!empty($coupon)) {?>
                        <tr>
                            <td class="total-quantity" colspan="1">Discount Coupon</td>
                            <td class="price"><?echo $coupon?></td>
                            <td class="price"><?echo $coupon_result*100;?>%</td>
                            <td class="amount">-<?echo $symbol;?><?echo number_format($discount_price*$currency_rate,2)?></td>
                        </tr>											
                        <?}
                        ?>
                        <tr>										
                            <td class="total-quantity" colspan="3">Shipping</td>
                            <td class="amount"><?echo $symbol?><?echo number_format($shipping_price*$currency_rate,2);?></td>
                        </tr>
                        <tr>
                            <td class="total-quantity" colspan="3">Total Price</td>
                            <td class="total-amount"><?echo $symbol?><?echo number_format($total*$currency_rate,2);?></td>
                        </tr>
                        <tr>
                            <td class="total-quantity" colspan="3">Ships to: <?echo $address?></td>
                        </tr>										
                    </tbody>
                </table>
                <p class="small">If you have any questions concerning this invoice, contact <strong>Health Supplements Plus</strong>, tel: <strong>(403) 401-5701</strong>, email: <strong>admin@healthsupplementsplus.com</strong> <br> Thank you for your business!</p>
                <hr>
            </div>
            <div class="text-right">	
                <button onclick="print_window();" class="btn btn-print btn-default-transparent btn-hvr hvr-shutter-out-horizontal">Print <i class="fa fa-print pl-10"></i></button>
            </div>
        </div>
        <!-- main end -->
</div>

<div id="chinese_tab">
						<!-- main start -->
						<!-- ================ -->
						<div class="main col-md-12">

							<div id="invoice-container" class="invoice-container">
								<div class="row">
									<div class="col-sm-6">
										<img src="../images/logo_purple.png" height="35px" width="150px" alt="HSP">
										<p class="invoice-slogan">Health Supplements Plus</p>
										<address class="small">
											<strong>Health Supplements Plus</strong><br>
											<abbr title="Phone">电话:</abbr> (403) 401-5701<br>
											电子信箱: <a href="mailto:admin@healthsupplementsplus.com">admin@healthsupplementsplus.com</a>
										</address>
									</div>
									<?

									?>
									<div class="col-sm-offset-3 col-sm-3">
										<p class="text-right small"><strong>发票: </strong><?echo $invoice?><br><strong>订单状态: </strong><?echo $status?><br/> <?echo $date_created?></p>
										<h5 class="text-right">客户</h5>
										<p class="text-right small">
											<strong>名字:</strong> <span><?echo $bname;?></span> <br>
											<strong>地址:</strong> <?echo $baddress?> <br>
											<strong>电话:</strong> <?echo $btel?> <br>
										</p>
									</div>
								</div>
								<p class="small"><strong>其他评论:</strong> 
								<?if (empty($comment)){
									echo "没";
								}else {
									echo $comment;
								}
								?>
								</p>
								<table class="table cart table-bordered">
									<thead>
										<tr>
											<th>产品 </th>
											<th>价格 </th>
											<th>数量</th>
											<th class="amount">小计 </th>
										</tr>
									</thead>
									<tbody>
									
									<?
									
										for ($i= 0; $i < $number_or_product; $i++) {
											
											
											$get_product_sql = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM product WHERE id='$product_exploded[$i];'"));
											$product_name = $get_product_sql['zh_name'];
											$product_price = $get_product_sql['price']*(1-$get_product_sql['discount']);
									?>
											
										<tr>
											<td class="product"><?echo $product_name?></a></td>
											<td class="price"><?echo $symbol;?><?echo number_format($product_price*$currency_rate,2)?> </td>
											<td class="quantity"><?echo $amount_exploded[$i] ?> </td>
											<td class="amount"><?echo $symbol;?><?echo number_format($product_price*$currency_rate*$amount_exploded[$i],2)?> </td>
										</tr>											
											
									<?
										}
									
									?>

										<tr>
											<td class="total-quantity" colspan="3">小计</td>
											<td class="amount"><?echo $symbol?><?echo number_format($subtotal*$currency_rate,2);?></td>
										</tr>
										<?
										if (!empty($coupon)) {?>
										<tr>
											<td class="total-quantity" colspan="1">折扣卷</td>
											<td class="price"><?echo $coupon?></td>
											<td class="price"><?echo $coupon_result*100;?>%</td>
											<td class="amount">-<?echo $symbol;?><?echo number_format($discount_price*$currency_rate,2)?></td>
										</tr>											
										<?}
										?>
										<tr>										
											<td class="total-quantity" colspan="3">邮递费</td>
											<td class="amount"><?echo $symbol?><?echo number_format($shipping_price*$currency_rate,2);?></td>
										</tr>
										<tr>
											<td class="total-quantity" colspan="3">总价</td>
											<td class="total-amount"><?echo $symbol?><?echo number_format($total*$currency_rate,2);?></td>
										</tr>
										<tr>
											<td class="total-quantity" colspan="3">邮递到: <?echo $address?></td>
										</tr>										
									</tbody>
								</table>
								<p class="small">如果您有任何关于此发票有任何疑问，请联系 <strong>Health Supplements Plus</strong>, 电话: <strong>(403) 401-5701</strong>, 电子信箱: <strong>admin@healthsupplementsplus.com</strong> <br> 谢谢和您的合作！</p>
								<hr>
							</div>
							<div class="text-right">	
								<button onclick="print_window();" class="btn btn-print btn-default-transparent btn-hvr hvr-shutter-out-horizontal">打印 <i class="fa fa-print pl-10"></i></button>
							</div>
						</div>
						<!-- main end -->
</div>

      <?include('inc/scripts.php');?>
    </body>
</html>
