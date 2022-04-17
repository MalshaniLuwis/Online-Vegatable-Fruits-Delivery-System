<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}

$usercheck = $_SESSION['USER_ID'];
$sql="select * from product where user_id = $usercheck and status = 0 order by id desc";
$res=mysqli_query($con,$sql);
$adasdas=mysqli_num_rows($res);
?>

        
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div style="margin:100px;" class="conafafa">
			<a style="background:blue;padding:10px 20px;border-radius:5px;color:#fff;" href="manage_product.php">Post Your Ad Now !</a>
      <?php if($adasdas>0){ ?>
        <center><h3 style="margin:30px;">Pending Ads</h3></center>
        <div style="display:flex;align-items:center;justify-content:center;">
      <table style="width:800px;">
        <tr>
          <th style="background:none;"></th>
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
          <td><a href="manage_product.php?id=<?php echo $row['id']?>">edit</a></td>
          <td><a href="#">remove</a></td>
          
        </tr>
        <?php } ?>
       
      </table>
      </div>
      <?php } ?>


      <center><h3 style="margin:30px;">Your Ads</h3></center>
        <div style="display:flex;align-items:center;justify-content:center;">
      <table style="width:800px;">
        <tr>
          <th style="background:none;"></th>
          <th style="background:none;"></th>
          <th style="background:none;"></th>
        </tr>
        <?php 
          $sql="select * from product where user_id = $usercheck and status = 1 order by id desc";
          $res=mysqli_query($con,$sql);
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
          <td><a href="manage_product.php?id=<?php echo $row['id']?>">edit</a></td>
          <td><a href="#">remove</a></td>
          
        </tr>
        <?php } ?>
       
      </table>
      </div>
    
      </div>
    </div>
        
        						
<?php require('footer.php')?>        