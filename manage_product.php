<?php
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='login-user.php';
	</script>
	<?php
}

if(isset($_GET['pi']) && ($_GET['pi']) > 0 ){
	$pi=get_safe_value($con,$_GET['pi']);
	$delete_sql="delete from product_images where id='$pi'";
	mysqli_query($con,$delete_sql);
}

date_default_timezone_set("Asia/Colombo");
$categories_id='';
$name='';
$price='';
$image='';
$description	='';
$best_seller='';
$sub_categories_id='';
$status='0';
$local_area_id='';
$district_id='';
$multipleImageArr=[];
$user_id=$_SESSION['USER_ID'];
$msg='';
$image_required='required';
?>
	<script>
	var total_images=1;
	</script>
	<?php
if(isset($_GET['id']) && $_GET['id']!=''){
	
	$image_required='';
	$id=get_safe_value($con,$_GET['id']);
	$res=mysqli_query($con,"select * from product where id='$id'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$local_area_id=$row['local_area_id'];
		$district_id=$row['district_id'];
		$categories_id=$row['categories_id'];
		$sub_categories_id=$row['sub_categories_id'];
		$name=$row['name'];
		$price=$row['price'];
		$description=$row['description'];
		$best_seller=$row['best_seller'];
		$image=$row['image'];

		$resMultipleImage=mysqli_query($con,"select id,product_images from product_images where product_id='$id'");
		if(mysqli_num_rows($resMultipleImage)>0){
			$jj =0;
			while($rowMultipleImage=mysqli_fetch_assoc($resMultipleImage)){
				$multipleImageArr[$jj]['product_images']=$rowMultipleImage['product_images'];
				$multipleImageArr[$jj]['id']=$rowMultipleImage['id'];
				$jj++;
			}	
		}
	}else{
		header('location:product.php');
		die();
	}
}

if(isset($_POST['submit'])){
	$local_area_id=get_safe_value($con,$_POST['local_area_id']);
	$district_id=get_safe_value($con,$_POST['district_id']);
	$categories_id=get_safe_value($con,$_POST['categories_id']);
	$sub_categories_id=get_safe_value($con,$_POST['sub_categories_id']);
	$name=get_safe_value($con,$_POST['name']);
	$price=get_safe_value($con,$_POST['price']);
	$description=get_safe_value($con,$_POST['description']);
	$best_seller=get_safe_value($con,$_POST['best_seller']);
	
	$res=mysqli_query($con,"select * from product where name='$name'");
	$check=mysqli_num_rows($res);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			if($id==$getData['id']){
			
			}else{
				$msg="Product already exist";
			}
		}else{
			$msg="Product already exist";
		}
	}
	
	if(isset($_GET['id']) && $_GET['id']==0){
		if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
			$msg="Please select only png,jpg and jpeg image formate";
		}
	}else{
		if($_FILES['image']['type']!=''){
				if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
				$msg="Please select only png,jpg and jpeg image formate";
			}
		}
	}

	if(isset($_FILES['product_images'])){
		foreach($_FILES['product_images']['type'] as $key=>$val){
			if($_FILES['product_images']['type'][$key]!=''){
				if($_FILES['product_images']['type'][$key]!='image/png' && $_FILES['product_images']['type'][$key]!='image/jpg' && $_FILES['product_images']['type'][$key]!='image/jpeg'){
					$msg="Please select only png,jpg and jpeg image formate";
				}
			}
		}
	}
	
	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			if($_FILES['image']['name']!=''){
				$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
				move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
				$update_sql="update product set categories_id='$categories_id',name='$name',price='$price',description='$description',image='$image',best_seller='$best_seller',sub_categories_id='$sub_categories_id',status='$status',district_id='$district_id',local_area_id='$local_area_id' where id='$id'";
			}else{
				$update_sql="update product set categories_id='$categories_id',name='$name',price='$price',description='$description',best_seller='$best_seller',sub_categories_id='$sub_categories_id',status='$status',district_id='$district_id',local_area_id='$local_area_id'  where id='$id'";
			}
			mysqli_query($con,$update_sql);
		}else{
			$added_on=date('Y-m-d h:i:s');
			$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
			mysqli_query($con,"insert into product(categories_id,name,price,description,image,best_seller,sub_categories_id,status,user_id,district_id,local_area_id,added_on) values('$categories_id','$name','$price','$description','$image','$best_seller','$sub_categories_id','$status','$user_id','$district_id','$local_area_id','$added_on')");
			$id=mysqli_insert_id($con);
		}

		if(isset($_GET['id']) && $_GET['id']!=''){
			foreach($_FILES['product_images']['name'] as $key=>$val){
				if($_FILES['product_images']['name'][$key]!=''){
					if(isset($_POST['product_images_id'][$key])){
						$image=rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
						move_uploaded_file($_FILES['product_images']['tmp_name'][$key],PRODUCT_MULTIPLE_IMAGE_SERVER_PATH.$image);
						mysqli_query($con,"update product_images set product_images='$image' where id ='".$_POST['product_images_id'][$key]."'");
			
					}else{
						$image=rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
						move_uploaded_file($_FILES['product_images']['tmp_name'][$key],PRODUCT_MULTIPLE_IMAGE_SERVER_PATH.$image);
						mysqli_query($con,"insert into product_images(product_id,product_images) values('$id','$image')");
			
					}
				}
			}
		
		}else{
			if(isset($_FILES['product_images']['name'])){
			foreach($_FILES['product_images']['name'] as $key=>$val){
				$image=rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
				move_uploaded_file($_FILES['product_images']['tmp_name'][$key],PRODUCT_MULTIPLE_IMAGE_SERVER_PATH.$image);
				mysqli_query($con,"insert into product_images(product_id,product_images) values('$id','$image')");
			}
		}
		}	
		?>
	<script>
	window.location.href='my_order.php';
	</script>
	<?php
		die();
	}
}

$district_res=mysqli_query($con,"select * from districts order by districts asc");
$district_arr=array();
while($districtrow=mysqli_fetch_assoc($district_res)){
	$district_arr[]=$districtrow;	
}
?>

<style>
*{
	color:#000;
}


form .form-group input{
	font-size:15px;
	margin: 5px 0;
	
}
form .form-group{
	font-size:15px;
	margin: 15px 0;
	
}


form .btn{
	font-size:15px;
}

form .form-group select{
	font-size:15px;
	margin: 5px 0;
}
form .form-group textarea{
	font-size:15px;
	margin: 5px 0;
}
* {
  margin:0px;
  padding:0px;
  box-sizing:border-box;
}
body {
  font-family:"Raleway",sans-serif;
  background:#f8f8f8;
}

.imgrpeiv {
  margin:20px 40px 20px 20px;
  padding:0px 50px;
}
.imgrpeiv h4 {
  text-align:center;
  color:#000;
  font-size:30px;
  font-weight:400;
}
.imgrpeiv .gridzxf {
  margin-top:50px;
  display:flex;
  justify-content:space-around;
  flex-wrap:wrap;
  gap:20px;
}
.imgrpeiv .gridzxf .asfdasfaf {
  width:200px!important;
  height:200px!important;
  box-shadow:0px 0px 20px 5px rgba(100,100,100,0.1)!important;
}
.imgrpeiv .gridzxf .asfdasfaf input {
  display:none;
}
.imgrpeiv .gridzxf .asfdasfaf img {
  width:200px;
  height:200px;
  object-fit:cover;
}
.imgrpeiv .gridzxf .asfdasfaf div {
  position:absolute;
  height:40px;
  width: 200px;
  margin-top:-40px;
  background:rgba(0,0,0,0.5);
  text-align:center;
  line-height:40px;
  font-size:13px;
  color:#f5f5f5;
  font-weight:600;
  overflow:hidden;
}
.imgrpeiv .gridzxf .asfdasfaf div span {
  font-size:40px;
}

</style>

<div style = "margin:100px 50px; color:#000;" class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Post</strong><small> Ads</small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
								<div style="display:flex;">
									<div class="form-group">
										<label for="categories" class=" form-control-label">Location</label>
										<select style="width:350px" class="form-control" name="district_id" id="district_id" onchange="get_local_area('')"  required>
											<option>Select District</option>
											<?php
											$res=mysqli_query($con,"select id,districts from districts order by districts asc");
											while($row=mysqli_fetch_assoc($res)){
												if($row['id']==$district_id){
													echo "<option selected value=".$row['id'].">".$row['districts']."</option>";
												}else{
													echo "<option value=".$row['id'].">".$row['districts']."</option>";
												}
												
											}
											?>
										</select>
									</div>
									
									<div style="margin-left:30px;" class="form-group">
										<label for="categories" class=" form-control-label">Local Area</label>
										<select style="width:350px" class="form-control" name="local_area_id" id="local_area_id">
											<option>Select Local Area</option>
										</select>
									</div>
								</div>

								<div style="display:flex;">
									<div class="form-group">
										<label for="categories" class=" form-control-label">Categories</label>
										<select style="width:350px" class="form-control" name="categories_id" id="categories_id" onchange="get_sub_cat('')" required>
											<option>Select Category</option>
											<?php
											$res=mysqli_query($con,"select id,categories from categories where status=1 order by categories asc");
											while($row=mysqli_fetch_assoc($res)){
												if($row['id']==$categories_id){
													echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
												}else{
													echo "<option value=".$row['id'].">".$row['categories']."</option>";
												}
												
											}
											?>
										</select>
									</div>
									
									<div style="margin-left:30px;" class="form-group">
										<label for="categories" class=" form-control-label">Sub Categories</label>
										<select style="width:350px" class="form-control" name="sub_categories_id" id="sub_categories_id">
											<option>Select Sub Category</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Product Name</label>
									<input type="text" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name?>">
								</div>
								
								<div style="display:flex;">
									<div class="form-group">
										<label for="categories" class=" form-control-label">Price</label>
										<input type="text" name="price" placeholder="Enter product price" class="form-control" required value="<?php echo $price?>">
									</div>

									<div style="margin-left:30px;" class="form-group">
										<label for="categories" class=" form-control-label">Negotiable</label>
										<select style="width:100px" class="form-control" name="best_seller" required>
											<option value=''>Select</option>
											<?php
											if($best_seller==1){
												echo '<option value="1" selected>Yes</option>
													<option value="0">No</option>';
											}elseif($best_seller==0){
												echo '<option value="1">Yes</option>
													<option value="0" selected>No</option>';
											}else{
												echo '<option value="1">Yes</option>
													<option value="0">No</option>';
											}
											?>
										</select>
									</div>
								</div>


								<div class="form-group">
									<div style="display:flex;justify-content:space-between;" >
										
									</div>
									<div class="imgrpeiv">
										<h4>Upload Images</h4>
											
										
										<?php if(isset($_GET['id']) && $_GET['id']!='') {
												echo '<button style="float:right;" id="hdebtn" class="btn btn-primary" onclick="add_more_images()">Add more</button>';
											
											?>
											<div id="image_box" class="gridzxf">
												<div class="asfdasfaf">
												<input name="image" type="file" id="file-1" >
												<label for="file-1" id="file-1-preview">
													<img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>" alt="">
													<div>
													<span></span>
													</div>
												</label>
												</div>
												<?php if(isset($multipleImageArr[0])) {
														$ss = $jj+1;
													
												?>
												<script>
												total_images=<?php echo $ss ?>;
												</script>
												<?php	
												$asd=20; 
												foreach($multipleImageArr as $list){?>
												<div id="add_image_box<?php echo $list['id']?>" class="asfdasfaf">
													<input name="product_images[]" type="file" id="file-<?php echo $asd ?>" >
													<label for="file-<?php echo $asd ?>" id="file-<?php echo $asd ?>-preview">
														<img src="<?php echo PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list['product_images']?>">
														<div>
														<span></span>
														</div>
													</label>
													<button type="button" style="margin-top:5px;width:200px;" onClick="location.href='manage_product.php?id=<?php echo $id ?>&pi=<?php echo $list['id']?>'" class="btn btn-danger">Remove</button>
													<input type="hidden" name="product_images_id[]" value="<?php echo $list['id']?>">
													</div>
													
												<?php
												?>
												<script>
												previewBeforeUpload("file-20");
												previewBeforeUpload("file-21");
												previewBeforeUpload("file-22");
												</script>
												<?php
												$asd++;
												}
													}?>
													
											</div>
										<?php }else {
											echo '<button style="float:right;" id="hdebtn" class="btn btn-primary" onclick="add_more_images()">Add more</button>';
											?>
										<div id="image_box" class="gridzxf">
											<div class="asfdasfaf">
											<input name="image" type="file" id="file-1" >
											<label for="file-1" id="file-1-preview">
												<img src="https://bit.ly/3ubuq5o" alt="">
												<div>
												<span>+</span>
												</div>
											</label>
											</div>
										</div>
										<?php }?>
									</div>
								</div>
								
								<div style="margin-top:80px" class="form-group">
									<label for="categories" class=" form-control-label">Description</label>
									<textarea style="height:300px;" name="description" placeholder="Enter product description" class="form-control" required><?php echo $description?></textarea>
								</div>
								
										
							   <button style="width:100px; float:right;" id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 <script>
function previewBeforeUpload(id){
  document.querySelector("#"+id).addEventListener("change",function(e){
    if(e.target.files.length == 0){
      return;
    }
    let file = e.target.files[0];
    let url = URL.createObjectURL(file);
    document.querySelector("#"+id+"-preview div").innerText = file.name;
    document.querySelector("#"+id+"-preview img").src = url;
  });
}

previewBeforeUpload("file-1");
previewBeforeUpload("file-2");

</script>
		
		<script>
			function get_sub_cat(sub_cat_id){
				var categories_id=jQuery('#categories_id').val();
				jQuery.ajax({
					url:'get_sub_cat.php',
					type:'post',
					data:'categories_id='+categories_id+'&sub_cat_id='+sub_cat_id,
					success:function(result){
						jQuery('#sub_categories_id').html(result);
					}
				});
			}

			function get_local_area(local_area_id){
				var district_id=jQuery('#district_id').val();
				jQuery.ajax({
					url:'get_local_area.php',
					type:'post',
					data:'district_id='+district_id+'&local_area_id='+local_area_id,
					success:function(result){
						jQuery('#local_area_id').html(result);
					}
				});
			}
		</script>
		
		<script>
			if(total_images >=4 ){
				$("#hdebtn").hide();
			}
			
			var prv =2;
			function remove_image(id){
				jQuery('#add_image_box'+id).remove();
				total_images=total_images-1;
				$("#hdebtn").show();
			}
			
			function add_more_images(){
				
				var hfss ='<div id="add_image_box'+total_images+'" class="asfdasfaf"><input name="product_images[]" type="file" id="file-'+prv+'" required><label for="file-'+prv+'" id="file-'+prv+'-preview"><img src="https://bit.ly/3ubuq5o" alt=""><div><span>+</span></div></label><button style="margin-top:5px;width:200px;" onclick=remove_image("'+total_images+'") class="btn btn-danger">Remove</button></div>';
				var html = '<div ><label for="categories" class=" form-control-label">Image</label><input type="file" name="product_images[]" class="form-control" <?php echo  $image_required?>></div>';
				jQuery('#image_box').append(hfss);
				previewBeforeUpload("file-"+prv+"");
				prv++;
				total_images++;
				
				if(total_images >=4 ){
				$("#hdebtn").hide();
			}
			}
			
			
			
			
		</script>
         
<?php
require('footer.php');
?>
<script>
<?php
if(isset($_GET['id'])){
?>
get_sub_cat('<?php echo $sub_categories_id?>');
get_local_area('<?php echo $local_area_id?>');
<?php } ?>
</script>