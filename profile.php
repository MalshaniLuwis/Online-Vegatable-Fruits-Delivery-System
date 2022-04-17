<?php 
require('top.php');
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='index.php';
	</script>
	<?php
}
?>

<style>
.field_error{
  color: red;
}


form .mb-3 input{
	font-size:15px;
}

form .btn{
	font-size:15px;
}





</style>


<section class="afasfaf">
    <div class="accntbtn">
      <a href=""><i class="far fa-star"></i> Saved Ads</a>
      <a href=""><i class="fas fa-file-invoice-dollar"></i> Your Ads</a>
    </div>


    <div style="margin-top: 60px;" class="loginreg">
      <form style="width:30%;" id="login-form" method="post">
        <center><h3>Change Name</h3></center>
          <div style="margin-top: 20px;" class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $_SESSION['USER_NAME']?>">
            <span class="field_error" id="name_error"></span>
          </div>
          <button type="button" onclick="update_profile()" id="btn_submit" class="btn btn-primary">Update</button>
  
        </form>
  
        <form style="width:30%;" method="post" id="frmPassword">
          <center><h3>Change Password</h3></center>
          <div style="margin-top: 20px;" class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Current Password</label>
            <input type="password" class="form-control" name="current_password" id="current_password">
			<span class="field_error" id="current_password_error"></span>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">New Password</label>
            <input type="password" class="form-control" name="new_password" id="new_password">
			<span class="field_error" id="new_password_error"></span>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confrim Password</label>
            <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password">
			<span class="field_error" id="confirm_new_password_error"></span>
          </div>
          <button type="button" class="btn btn-primary" onclick="update_password()" id="btn_update_password">Submit</button>
        </form>
      </div>
  </section>

		<script>
		function update_profile(){
			jQuery('.field_error').html('');
			var name=jQuery('#name').val();
			if(name==''){
				jQuery('#name_error').html('Please enter your name');
			}else{
				jQuery('#btn_submit').html('Please wait...');
				jQuery('#btn_submit').attr('disabled',true);
				jQuery.ajax({
					url:'update_profile.php',
					type:'post',
					data:'name='+name,
					success:function(result){
						jQuery('#name_error').html(result);
						jQuery('#btn_submit').html('Update');
						jQuery('#btn_submit').attr('disabled',false);
					}
				})
			}
		}
		
		function update_password(){
			jQuery('.field_error').html('');
			var current_password=jQuery('#current_password').val();
			var new_password=jQuery('#new_password').val();
			var confirm_new_password=jQuery('#confirm_new_password').val();
			var is_error='';
			if(current_password==''){
				jQuery('#current_password_error').html('Please enter password');
				is_error='yes';
			}if(new_password==''){
				jQuery('#new_password_error').html('Please enter password');
				is_error='yes';
			}if(confirm_new_password==''){
				jQuery('#confirm_new_password_error').html('Please enter password');
				is_error='yes';
			}
			
			if(new_password!='' && confirm_new_password!='' && new_password!=confirm_new_password){
				jQuery('#confirm_new_password_error').html('Please enter same password');
				is_error='yes';
			}
			
			if(is_error==''){
				jQuery('#btn_update_password').html('Please wait...');
				jQuery('#btn_update_password').attr('disabled',true);
				jQuery.ajax({
					url:'update_password.php',
					type:'post',
					data:'current_password='+current_password+'&new_password='+new_password,
					success:function(result){
						jQuery('#current_password_error').html(result);
						jQuery('#btn_update_password').html('Update');
						jQuery('#btn_update_password').attr('disabled',false);
						jQuery('#frmPassword')[0].reset();
					}
				})
			}
			
		}
		</script>
<?php require('footer.php')?>        