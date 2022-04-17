<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
$wishlist_count=0;
$cat_res=mysqli_query($con,"select * from categories where status=1 order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
	$cat_arr[]=$row;	
}

$per_page=10;
$start=0;
$current_page=1;
if(isset($_GET['start'])){
	$start=$_GET['start'];
	if($start<=0){
		$start=0;
		$current_page=1;
	}else{
		$current_page=$start;
		$start--;
		$start=$start*$per_page;
	}
}
$record=mysqli_num_rows(mysqli_query($con,"select * from product where status=1 order by added_on desc"));
$pagi=ceil($record/$per_page);
$pro_refsdfs=mysqli_query($con,"select * from product where status=1 order by added_on desc limit $start,$per_page");


$pro_res=mysqli_query($con,"select product.*,sub_categories.sub_categories,districts.districts from product,sub_categories,districts where product.status=1 and product.sub_categories_id=sub_categories.id and product.district_id=districts.id order by product.added_on desc");
$pro_arr=array();
while($prorow=mysqli_fetch_assoc($pro_res)){
	$pro_arr[]=$prorow;	
}








$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

if(isset($_SESSION['USER_LOGIN'])){
	$uid=$_SESSION['USER_ID'];
	
	if(isset($_GET['wishlist_id'])){
		$wid=get_safe_value($con,$_GET['wishlist_id']);
		mysqli_query($con,"delete from wishlist where id='$wid' and user_id='$uid'");
	}

	$wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,product.price,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}

$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/',$script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];

$cat_res=mysqli_query($con,"select * from categories where status=1 order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
	$cat_arr[]=$row;	
}


$district_res=mysqli_query($con,"select * from districts order by districts asc");
$district_arr=array();
while($districtrow=mysqli_fetch_assoc($district_res)){
	$district_arr[]=$districtrow;	
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Favicon -->
  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/custom.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <!-- Glidejs -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css" integrity="sha512-kwJUhJJaTDzGp6VTPBbMQWBFUof6+pv0SM3s8fo+E6XnPmVmtfwENK0vHYup3tsYnqHgRDoBDTJWoq7rnQw2+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./styles.css" />
  <script src="js/vendor/modernizr-3.5.0.min.js"></script>
  <title>Fresh Vegies</title>
</head>

<body>
  <!-- Button trigger modal -->



  <!-- Navigation -->
  <nav class="nav">
    <div class="wrapper container">
      <a href="index.php"><img style="width: 100px;" src="images/logo.png" alt=""></a>
      <ul class="nav-list">
        <div class="top">
          <label for="" class="btn close-btn"><i class="fas fa-times"></i></label>
        </div>
        <li><a href="index.php">All Ads</a></li>
        <li><a href="wishlist.php">Saved Ads</a></li>
        <li><a href="manage_product.php">Post Your Add</a></li>
        
        <li>
        <?php if(isset($_SESSION['USER_LOGIN'])){
					?>
          <a href="login-user.php" class="desktop-item">My Account</a>
          <input type="checkbox" id="showdrop2" />
          <label for="showdrop2" class="mobile-item">My Account<span><i class="fas fa-chevron-down"></i></span></label>
          <ul class="drop-menu2">
            <li><a href="my_order.php">Your Ads</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
        <?php
          }else{
            echo '<a href="login-user.php" class="desktop-item">Login | Register</a>';
          }
          ?>
        <!-- icons -->
      </ul>
      <label for="" class="btn open-btn"><i class="fas fa-bars"></i></label>
    </div>  
  </nav>