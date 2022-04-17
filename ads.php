<?php 
require('top.php');
if(isset($_GET['id'])){
	$product_id=mysqli_real_escape_string($con,$_GET['id']);
	if($product_id>0){
		$get_product=get_product($con,'',$product_id);
	}else{
		?>
		<script>
		window.location.href='index.php';
		</script>
		<?php
	}
}else{
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}


$uid=$_SESSION['USER_ID'];

$resafsaf=mysqli_query($con,"select * from wishlist where product_id='$product_id' and user_id='$uid'");
$rowafafa=mysqli_fetch_assoc($resafsaf);

$user_id=$get_product['0']['user_id'];
$sub_id=$get_product['0']['sub_categories_id'];
$local_id=$get_product['0']['local_area_id'];
$sql="select users.*,sub_categories.sub_categories,local_area.local_area from users,sub_categories,local_area where users.id=$user_id and sub_categories.id=$sub_id and local_area.id=$local_id";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);
$resMultipleImage=mysqli_query($con,"select product_images from product_images where product_id='$product_id'");
		if(mysqli_num_rows($resMultipleImage)>0){
			while($rowMultipleImage=mysqli_fetch_assoc($resMultipleImage)){
				$multipleImageArr[]=$rowMultipleImage['product_images'];
			}	
		}

?>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Call <?php echo $row['name']?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <span><a href="tel:<?php echo $row['mobile']?>"><?php echo $row['mobile']?></a></span>
      </div>
    </div>
  </div>
</div>
	  <section class="section product-detail">
    <div class="details container">
      <div class="left">
        <div class="main">
          <img class="big_img" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>" alt="" />
        </div>
        <?php if (isset($multipleImageArr[0])){ ?>
        <div class="thumbnails">
          <div class="thumbnail">
            <img class="small_img" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$get_product['0']['image']?>" alt="" />
          </div>
          <?php foreach($multipleImageArr as $list){ ?>
          <div class="thumbnail">
            <img class="small_img" src="<?php echo PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list?>" alt="" />
          </div>
          <?php }?>
        </div>
        <?php }?>
      </div>
      <div class="right">
        <div style="margin-bottom: 20px;">
          <span style="margin-left:2px;">For sale by <strong><?php echo $row['name']?></strong></span>
          <h1 style="margin-bottom:5px;margin-left:0;"><?php echo $get_product['0']['name']?></h1>
          <small style="margin-left:2px;"><?php echo $row['sub_categories']?>, <?php echo $row['local_area']?></small><br><br>
          <div class="price">Rs. <?php echo number_format($get_product['0']['price'])?></div>
          <?php if ($get_product['0']['best_seller']==1){
            echo '<span style="margin-left:20px;">Negotiable</span>';
          }?>
          <?php 
          if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
            $usercheck = $_SESSION['USER_ID'];
            $whishchck=mysqli_query($con,"select * from wishlist where user_id='$usercheck' and product_id='$product_id'");
            $checkwish=mysqli_num_rows($whishchck);

            if($checkwish>0){
              ?>
              <a style="width:100px;display:flex;align-items:center;padding:6px 15px;font-size:20px; border-radius:10px; color:#fff; background:blue;" href="ads.php?id=<?php echo $get_product['0']['id']?>&wishlist_id=<?php echo $rowafafa['id']?>"><i style="color:yellow;" class="fas fa-star"></i><small style="font-size:15px;margin-left:5px;">Saved</small></a>
               <?php
            }else{
              ?>
              
              <br><a style="width:120px;display:flex;align-items:center;padding:6px 15px;font-size:20px; border-radius:10px; color:#fff; background:blue;" href="javascript:void(0)" onclick="wishlist_manage('<?php echo $get_product['0']['id']?>','add')"><i class="far fa-star"></i><small style="font-size:15px;margin-left:5px;">Save Ad</small></a>
               <?php
        
            }
          }else{
            ?>
              
              <br><a style="width:120px;display:flex;align-items:center;padding:6px 15px;font-size:20px; border-radius:10px; color:#fff; background:blue;" href="wishlist.php"><i class="far fa-star"></i><small style="font-size:15px;margin-left:5px;">Save Ad</small></a>
      
            
             <?php } ?>
          
        </div>
        <br>
        <div>
        <button style="display:flex;align-items:center;border-radius:7px;" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i style="font-size:20px;" class="fas fa-phone-alt"></i><small style="font-size:15px;margin-left:5px;">Call <?php echo $row['name']?></small>
</button> 
        </div><br>
        <br><div>
          <a style="display:flex;align-items:center;padding:6px 15px;font-size:25px; border-radius:10px; color:#fff; background:green;" href="https://wa.me/<?php echo $row['mobile']?>"><i style="" class="fab fa-whatsapp"> </i><small style="font-size:15px;margin-left:5px;" > Chat with <?php echo $row['name']?></small></a>
        </div>

      </div>
    </div>
  </section>

  <section style="margin:30px;;">
    <h3>Product Detail</h3>
        <pre>
        <p><?php echo $get_product['0']['description']?></p>
        </pre>
        </section>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js" integrity="sha512-b4rL1m5b76KrUhDkj2Vf14Y0l1NtbiNXwV+SzOzLGv6Tz1roJHa70yr8RmTUswrauu2Wgb/xBJPR8v80pQYKtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <script>
	$(document).ready(function(){
		$(".small_img").hover(function(){
			$(".big_img").attr('src',$(this).attr('src'));
		});
		
	});

	lightGallery(document.querySelector('.left'));


</script>


		
<?php require('footer.php')?>        