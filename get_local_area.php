<?php
require('connection.inc.php');
require('functions.inc.php');
$district_id=get_safe_value($con,$_POST['district_id']);
$local_area_id=get_safe_value($con,$_POST['local_area_id']);
$res=mysqli_query($con,"select * from local_area where district_id='$district_id'");
if(mysqli_num_rows($res)>0){
	$html='';
	while($row=mysqli_fetch_assoc($res)){
		if($local_area_id==$row['id']){
			$html.="<option value=".$row['id']." selected>".$row['local_area']."</option>";
		}else{
			$html.="<option value=".$row['id'].">".$row['local_area']."</option>";
		}
	}
	echo $html;
}else{
	echo "<option value=''>No local areas found</option>";
}
?>