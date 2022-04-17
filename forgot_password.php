<?php 
require('top.php');
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
	?>
	<script>
	window.location.href='my_order.php';
	</script>
	<?php
}
?>

<style>
.field_error{
  color: red;
}

.email_verify_otp{display:none;}

form .mb-3 input{
	font-size:15px;
}

form .btn{
	font-size:15px;
}





</style>
<section class="section product-detail">
	<div style="display:flex;justify-content:center;" class="adasfas">
		<form style="width:30%;" id="login-form" method="post">
			<div class="mb-3">
				<label for="exampleInputEmail1" class="form-label">Email address</label>
				<input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp">
			</div>
			<div  syle="position:fixed" class="mb-3">
				<p class="field_error" id="email_error"></p>
			</div>
			<div syle="position:fixed" class="form-group">
				<div class="form-output login_msg">
				<p class="form-messege field_error"></p>
				</div>
			</div>
			<button type="button" onclick="forgot_password()" id="btn_submit" class="btn btn-primary">Submit</button>

			
		</form>
	</div>
</section>

		<script>
		function forgot_password(){
			jQuery('#email_error').html('');
			var email=jQuery('#email').val();
			if(email==''){
				jQuery('#email_error').html('Please enter email id');
			}else{
				jQuery('#btn_submit').html('Please wait...');
				jQuery('#btn_submit').attr('disabled',true);
				jQuery.ajax({
					url:'forgot_password_submit.php',
					type:'post',
					data:'email='+email,
					success:function(result){
						jQuery('#email').val('');
						jQuery('#email_error').html(result);
						jQuery('#btn_submit').html('Submit');
						jQuery('#btn_submit').attr('disabled',false);
					}
				})
			}
		}
		</script>
<?php require('footer.php')?>        