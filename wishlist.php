<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='login-user.php';
	</script>
	<?php
}
$uid=$_SESSION['USER_ID'];

$res=mysqli_query($con,"select product.name,product.image,product.price,product.id as pid,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'");
?>

<div style="margin:100px;" class="conafafa">
			
     
        <center><h3 style="margin:30px;">Saved Ads</h3></center>
        <div style="display:flex;align-items:center;justify-content:center;">
      <table style="width:800px;">
        <tr>
          <th style="background:none;"></th>
          <th style="background:none;"></th>
        </tr>
        <?php 
					while($row=mysqli_fetch_assoc($res)){?>
        <tr>
          <td>
            <div class="cart-info">
              <img style="width: 120px;height:120px;object-fit:cover;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>" alt="" />
              <div>
                <p><?php echo $row['name']?></p>
                <span><?php echo $row['price']?></span>
                
              </div>
            </div>
          </td>
          <td><a href="wishlist.php?wishlist_id=<?php echo $row['id']?>">remove</a></td>
          
        </tr>
        <?php } ?>
       
      </table>
      </div>
     
    </div>


        
		<input type="hidden" id="qty" value="1"/>						
<?php require('footer.php')?>        