<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($con,$str){
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}

function get_product($con,$cat_id='',$product_id='',$search_str='',$sort_order='',$is_best_seller='',$sub_categories='',$districts='',$local_area='',$start=''){
	$sql="select product.*,categories.categories,sub_categories.sub_categories,districts.districts,local_area.local_area from product,categories,sub_categories,districts,local_area where product.status=1 and product.sub_categories_id=sub_categories.id and product.district_id=districts.id and product.local_area_id=local_area.id ";
	
	if($cat_id!=''){
		$sql.=" and product.categories_id=$cat_id ";
	}
	if($product_id!=''){
		$sql.=" and product.id=$product_id ";
	}
	if($sub_categories!=''){
		$sql.=" and product.sub_categories_id=$sub_categories ";
	}
	if($districts!=''){
		$sql.=" and product.district_id=$districts ";
	}
	if($local_area!=''){
		$sql.=" and product.local_area_id=$local_area ";
	}
	if($is_best_seller!=''){
		$sql.=" and product.best_seller=1 ";
	}
	$sql.=" and product.categories_id=categories.id ";
	if($search_str!=''){
		$sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%') ";
	}
	if($sort_order!=''){
		$sql.=$sort_order;
	}else{
		$sql.=" order by product.id desc ";
	}
	if($start!=''){
		$per_page=10;
		$record=mysqli_num_rows(mysqli_query($con,$sql));
		$pagi=ceil($record/$per_page);
		$sql.=" limit $start,$per_page";
	}
	//echo $sql;
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function wishlist_add($con,$uid,$pid){
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($con,"insert into wishlist(user_id,product_id,added_on) values('$uid','$pid','$added_on')");
}
date_default_timezone_set("Asia/Colombo");
     
   function time_ago($timestamp)  
   {  
		$time_ago = strtotime($timestamp);  
		$current_time = time();  
		$time_difference = $current_time - $time_ago;  
		$seconds = $time_difference;  
		$minutes      = round($seconds / 60 );           
		$hours           = round($seconds / 3600);           
		$days          = round($seconds / 86400);         
		$weeks          = round($seconds / 604800);         
		$months          = round($seconds / 2629440);     
		$years          = round($seconds / 31553280);     
		if($seconds <= 60)  
		{  
	   return "Just Now";  
	 }  
		else if($minutes <=60)  
		{  
	   if($minutes==1)  
			 {  
		 return "one minute ago";  
	   }  
	   else  
			 {  
		 return "$minutes minutes ago";  
	   }  
	 }  
		else if($hours <=24)  
		{  
	   if($hours==1)  
			 {  
		 return "an hour ago";  
	   }  
			 else  
			 {  
		 return "$hours hrs ago";  
	   }  
	 }  
		else if($days <= 7)  
		{  
	   if($days==1)  
			 {  
		 return "yesterday";  
	   }  
			 else  
			 {  
		 return "$days days ago";  
	   }  
	 }  
		else if($weeks <= 4.3) 
		{  
	   if($weeks==1)  
			 {  
		 return "a week ago";  
	   }  
			 else  
			 {  
		 return "$weeks weeks ago";  
	   }  
	 }  
		 else if($months <=12)  
		{  
	   if($months==1)  
			 {  
		 return "a month ago";  
	   }  
			 else  
			 {  
		 return "$months months ago";  
	   }  
	 }  
		else  
		{  
	   if($years==1)  
			 {  
		 return "one year ago";  
	   }  
			 else  
			 {  
		 return "$years years ago";  
	   }  
	 }  
   }  
   
?>