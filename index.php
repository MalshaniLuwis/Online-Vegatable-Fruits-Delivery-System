<?php require('top.php');
$cat_id='';
$districts='';
$local_area='';
$sub_categories='';
$str='';
$loctionset='Location';
$crtgryset='Category';

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

if(isset($_GET['id'])){
  $cat_id=mysqli_real_escape_string($con,$_GET['id']);
}

if(isset($_GET['str'])){
  $str=mysqli_real_escape_string($con,$_GET['str']);
}

if(isset($_GET['sub_categories'])){
	$sub_categories=mysqli_real_escape_string($con,$_GET['sub_categories']);
  
}
if(isset($_GET['districts'])){
	$districts=mysqli_real_escape_string($con,$_GET['districts']);
}
if(isset($_GET['local_area'])){
	$local_area=mysqli_real_escape_string($con,$_GET['local_area']);
}
$price_high_selected="";
$price_low_selected="";
$new_selected="";
$old_selected="";
$sort_order="";
if(isset($_GET['sort'])){
	$sort=mysqli_real_escape_string($con,$_GET['sort']);
	if($sort=="price_high"){
		$sort_order=" order by product.price desc ";
		$price_high_selected="selected";	
	}if($sort=="price_low"){
		$sort_order=" order by product.price asc ";
		$price_low_selected="selected";
	}if($sort=="new"){
		$sort_order=" order by product.id desc ";
		$new_selected="selected";
	}if($sort=="old"){
		$sort_order=" order by product.id asc ";
		$old_selected="selected";
	}

}


if($cat_id>0){
	$get_product=get_product($con,$cat_id,'',$str,$sort_order,'',$sub_categories,$districts,$local_area,$start);
}else if ($districts>0) {
  $get_product=get_product($con,$cat_id,'',$str,$sort_order,'',$sub_categories,$districts,$local_area,$start);
}else if ($str>0) {
  $get_product=get_product($con,$cat_id,'',$str,$sort_order,'',$sub_categories,$districts,$local_area,$start);
}else{
	$get_product=get_product($con,'','',$str,$sort_order,'','','','',$start);
}	

if($cat_id>0){
  $catsql="select categories from categories where id=$cat_id";
  $catres=mysqli_query($con,$catsql);
  $catrow=mysqli_fetch_assoc($catres);
  $crtgryset=$catrow['categories'];
}
if($sub_categories>0){
  
  $catsql="select sub_categories from sub_categories where id=$sub_categories";
  $catres=mysqli_query($con,$catsql);
  $catrow=mysqli_fetch_assoc($catres);
  $crtgryset=$catrow['sub_categories'];
}
if($districts>0){
  $locsql="select districts from districts where id=$districts";
  $locres=mysqli_query($con,$locsql);
  $locrow=mysqli_fetch_assoc($locres);
  $loctionset=$locrow['districts'];
  
}
if($local_area>0){
  $locsql="select local_area from local_area where id=$local_area";
  $locres=mysqli_query($con,$locsql);
  $locrow=mysqli_fetch_assoc($locres);
  $loctionset=$locrow['local_area'];
}

$sortlink ='index.php?id='.$cat_id.'&sub_categories='.$sub_categories.'&districts='.$districts.'&local_area='.$local_area.'&str='.$str.'';
$srchlink ='index.php?id='.$cat_id.'&sub_categories='.$sub_categories.'&districts='.$districts.'&local_area='.$local_area.'';
?>


  <!-- PRODUCTS -->

  <section style="margin: 100px 80px 80px 80px;" class="newwrap">
        <div class="prdctsear">
          <button style="display:flex;align-items:center;" type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i style="font-size: 25px; color: rgb(6, 153, 79);" class="fas fa-map-marker-alt"></i><span style="margin-left:5px;"> <?php echo  $loctionset?></span></button>
          <button style="display:flex;align-items:center;"type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"><i style="font-size: 25px; color: rgb(6, 153, 79);" class="fas fa-stream"></i><span style="margin-left:5px;"> <?php echo  $crtgryset?></span></button>
          <div class="search__inner">
            <div style="display:flex;">
                <input style="width:400px; padding: 5px;" value="<?php echo $str ?>" placeholder="Search here... " id="str" type="text" name="str">
                <button id="srchbtn" onclick="search_post('<?php echo $srchlink?>')" style="color:#fff;outline: none;border:none; padding: 4px 10px;background:rgb(6, 153, 79);" type="button"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </div>

        <script>
        var input = document.getElementById("str");

          input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
              event.preventDefault();
              document.getElementById("srchbtn").click();
            }
          });
        </script>
    <div class="products-layout container">
      <div class="col-1-of-4">
      <?php if(count($get_product)>0){?>

          <ul class="block-content">
            <div class="col-3-of-4">
              <form style="margin-top:20px;" action="">
                <div class="item">
                  <div class="htc__grid__top">
                                <div class="htc__select__option">
                                <label for="sort-by">Sort By</label>
                                    <select  style ="width:200px;"class="ht__select" onchange="sort_product_drop('<?php echo $sortlink?>')" id="sort_product_id">
                                        <option value="">Default softing</option>
                                        <option value="price_low" <?php echo $price_low_selected?>>price low to hight</option>
                                        <option value="price_high" <?php echo $price_high_selected?>>price high to low</option>
                                        <option value="new" <?php echo $new_selected?>>new first</option>
										                    <option value="old" <?php echo $old_selected?>>old first</option>
                                    </select>
                                </div>
                               
                            </div>
                </div>
              </form>
          </ul>
        <div>
          <div class="block-title">
            <h3 style="font-size:18px">Categories</h3>
          </div>

          <ul class="block-content">
          <?php
            foreach($cat_arr as $list){
         ?>
            <li>
              <label for="">
                <a href="index.php?id=<?php echo $list['id']?>&districts=<?php echo $districts?>&local_area=<?php echo $local_area?>&str=<?php echo $str ?>"><span><?php echo $list['categories'] ?></span></a>
                <?php 
                $fsfsd=$list['id'];
                $dasd=mysqli_query($con,"select id from product where categories_id=$fsfsd"); 
                $hdfsauhf=mysqli_num_rows($dasd);
                ?>
                <small>(<?php echo $hdfsauhf ?>)</small>
              </label>
            </li>
            <?php }?>
          </ul>
        </div>
      </div>
      
        
          <div class="aygfuya">
            <table class="crttble">
              <tr>
                  <th style="height: 20px; background: none;"></th>
              </tr>
              <?php
          foreach($get_product as $list){
            ?>
              <tr class="clickable-row" data-href="ads.php?id=<?php echo $list['id']?>" style="border-bottom:1px solid rgb(182, 182, 182);cursor: pointer;">
                  <td>
                      <div style="justify-content: space-between;" class="cart-info">
                          <div style="display: flex;">
                            <a href="ads.php?id=<?php echo $list['id']?>"><img style="width: 150px;height:150px;object-fit:cover;" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>"></a>
                            <div style="text-align: left;">
                                <a href="ads.php?id=<?php echo $list['id']?>" style="color: #000; font-size: 20px;" href=""><p><?php echo $list['name']?></p></a>
                                <small><?php echo $list['districts']?>, <?php echo $list['sub_categories']?></small><br>
                                <span style="color: #000;">Rs. <?php echo number_format($list['price']);?></span>
                            </div>
                          </div>
                          <span style="align-self:flex-end;"><?php echo time_ago($list['added_on']);?></span>
                      </div>
                  </td>
              </tr>
              <?php } ?>
          </table>
          </div>

        
      </div>
      </div>
      </div>
    </div>
    <?php } else {  ?>
						<div style="margin-top:100px;height:200px;display:flex;width:1024px;justify-content:center;text-align:center;">
              <h3>Data not found</h3>
            </div>
            <style>

              .pagination{
                display: none;
              }
            </style>
					<?php } ?>
    
  </section>

  
  <script>
    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>






  <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Select Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="wrapperasd">
      <div class="parent-tab">
      <label for="tab">
     <span><a href="index.php?id=<?php echo $cat_id?>&sub_categories=<?php echo $sub_categories?>&str=<?php echo $str?>">All of Srilanka</a></span>
   </label>
   </div>
      <?php
     $i=1;
     
          foreach($district_arr as $list){
            ?>
    
    <div class="parent-tab">
      <input type="radio" name="tab" id="tab-<?php echo $i?>">
      <label for="tab-<?php echo $i?>">
        <span><?php echo $list['districts']?></span>
        <div class="icon"><i class="fas fa-plus"></i></div>
      </label>
      <div class="content">
       <li><a href="index.php?id=<?php echo $cat_id?>&sub_categories=<?php echo $sub_categories ?>&districts=<?php echo $list['id']?>&str=<?php echo $str?>">All of <?php echo $list['districts']?></a></li>
       <?php
            $location_id=$list['id'];
            $sub_area_res=mysqli_query($con,"select * from local_area where district_id='$location_id'");
            if(mysqli_num_rows($sub_area_res)>0){
            ?>
            <?php
            while($sub_area_rows=mysqli_fetch_assoc($sub_area_res)){
              echo '<li><a href="index.php?id='.$cat_id.'&sub_categories='.$sub_categories.'&districts='.$list['id'].'&local_area='.$sub_area_rows['id'].'&str='.$str.'">'.$sub_area_rows['local_area'].'</a></li>
            ';
            }
            ?>
            
            <?php 
          }
          $i++;  ?>
      </div>
    </div>
    <?php } ?>
  </div>

      </div>
    </div>
  </div>
</div>  
<style>
.wrapperasd{
  max-width: 600px;
  padding: 0 20px;
}
.wrapperasd .parent-tab,
.wrapperasd .child-tab{
  margin-bottom: 8px;
  border-radius: 3px;
  box-shadow: 0px 0px 15px rgba(0,0,0,0.18);
}

.wrapperasd .parent-tab label,
.wrapperasd .child-tab label{
  background: #fff;
  padding: 10px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  border-radius: 3px;
  position: relative;
  z-index: 99;
  transition: all 0.3s ease;
}

.parent-tab input:checked ~ label,
.child-tab input:checked ~ label{
  border-radius: 3px 3px 0 0;
}
.wrapperasd label span{
  color: #000;
  font-size: 17px;
  font-weight: 500;
}
.wrapperasd .child-tab label span{
  font-size: 17px;
}
.parent-tab label .icon{
  position: relative;
  height: 30px;
  width: 30px;
  font-size: 15px;
  color: #007bff;
  display: block;
  background: #fff;
  border-radius: 50%;
  text-shadow: 0 -1px 1px #0056b3;
}
.wrapperasd .child-tab label .icon{
  height: 27px;
  width: 27px;
}
.parent-tab label .icon i{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.parent-tab input:checked ~ label .icon i:before,
.child-tab input:checked ~ label .icon i:before{
  content: '\f068';
}
.wrapperasd .parent-tab .content,
.wrapperasd .child-tab .sub-content{
  max-height: 0px;
  overflow: hidden;
  background: #fff;
  border-radius: 0 0 3px 3px;
  transition: all 0.4s ease;
}
.parent-tab input:checked ~ .content,
.child-tab input:checked ~ .sub-content{
  max-height: 100vh;
}
.tab-3 input:checked ~ .content{
  padding: 15px 20px;
}

.parent-tab .content {
  margin-left:30px;
}
.parent-tab .content li{
  margin:5px;
  font-size: 16px;
  
}
.child-tab .sub-content p{
  font-size: 15px;
}
input[type="radio"],
input[type="checkbox"]{
  display: none;
}
</style>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Select Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="wrapperasd">
      <div class="parent-tab">
      <label for="tab">
     <span><a href="index.php?&districts=<?php echo $districts?>&local_area=<?php echo $local_area?>&str=<?php echo $str ?>">All Categories</a></span>
   </label>
   </div>
   
   <?php
  $j=50;
  
  foreach($cat_arr as $list){
         ?>
 
 <div class="parent-tab">
   
   <input type="radio" name="tab" id="tab-<?php echo $j?>">
   <label for="tab-<?php echo $j?>">
     <span><?php echo $list['categories']?></span>
     <div class="icon"><i class="fas fa-plus"></i></div>
   </label>
   <div class="content">
    <li><a href="index.php?id=<?php echo $list['id']?>&districts=<?php echo $districts?>&local_area=<?php echo $local_area?>&str=<?php echo $str ?>">All off <?php echo $list['categories']?></a></li>
    <?php
            $cat_id=$list['id'];
            $sub_cat_res=mysqli_query($con,"select * from sub_categories where status='1' and categories_id='$cat_id'");
            if(mysqli_num_rows($sub_cat_res)>0){
            ?>
            <?php
            while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
           echo '<li><a href="index.php?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'&districts='.$districts.'&local_area='.$local_area.'&str='.$str.'">'.$sub_cat_rows['sub_categories'].'</a></li>
         ';
         }
         ?>
         
         <?php 
       }
       $j++;  ?>
   </div>
 </div>
 <?php } ?>
</div>
      </div>
    </div>
  </div>
</div>

<style>
.pagination li a{
  display: flex;
  align-items: center;
  justify-content: center;
  width: 3.5rem;
  height: 3.5rem;
  border-radius: 100%;
  color: black;
  font-size: 1.3rem;
  border: 1px solid blue;
  margin-right: 0.5rem;
  cursor: pointer;
}



.pagination li a:hover {
  border: 1px solid blue;
  background-color: blue;
  color: var(--white);
}

.pagination a.active {
  border: 1px solid blue;
  background-color: blue;
  color: var(--white);
}


</style>
<ul class="pagination mt-30">
	<?php 
	for($i=1;$i<=$pagi;$i++){
	$class='';
	if($current_page==$i){
		?><li><a class="page-item active" href="javascript:void(0)"><?php echo $i?></a></li><?php
	}else{
	?>
		<li><a  class="page-item" href="<?php echo $sortlink?>&start=<?php echo $i?>"><?php echo $i?></a></li>
	<?php
	}
	?>
    
	<?php } ?>
  </ul>


  
<?php require('footer.php')?>        