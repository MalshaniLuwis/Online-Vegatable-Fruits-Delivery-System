<?php 
require('top.php');
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']=='yes'){
	?>
	<script>
	window.location.href='profile.php';
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
<section class="section products">
    <div class="loginreg">
    <form style="width:30%;" id="login-form" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="text" class="form-control" name="login_email" id="login_email" aria-describedby="emailHelp">
     
          <span class="field_error" id="login_email_error"></span>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="login_password" id="login_password">
          <span class="field_error" id="login_password_error"></span>
        </div>
        <button type="submit" onclick="user_login()" class="btn btn-primary">Submit</button>
        <a href="forgot_password.php" class="forgot_password">Forgot Password</a>

        <div class="form-output login_msg">
          <p class="form-messege field_error"></p>
        </div>
      </form>

      <form style="width:30%;" id="register-form" method="post">
	  	<div class="mb-3">
            <label for="" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control">
			<span class="field_error" id="name_error"></span>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="text" name="email" id="email" class="form-control" aria-describedby="emailHelp"><br>
		  <button type="button" class="btn btn-primary email_sent_otp" onclick="email_sent_otp()">Send OTP</button>
		  <br><input type="text" id="email_otp" placeholder="OTP" style="width:25%" class="email_verify_otp">
			<button type="button" class="btn btn-primary email_verify_otp" onclick="email_verify_otp()">Verify OTP</button>
			
			<span id="email_otp_result"></span>
			<span class="field_error" id="email_error"></span>
        </div>
	
        <div class="mb-3">
            <label for="" class="form-label">Mobile</label>
            <input type="text" class="form-control" name="mobile" id="mobile">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password">
		  <span class="field_error" id="password_error"></span>
        </div>
        <button type="button" class="btn btn-primary" onclick="user_register()" disabled id="btn_register" class="btn btn-primary">Submit</button>
		<div class="form-output register_msg">
			<p class="form-messege field_error"></p>
		</div>
	  </form>
    </div>
</section>
				

					
		<input type="hidden" id="is_email_verified"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
		<script>
		function email_sent_otp(){
			jQuery('#email_error').html('');
			var email=jQuery('#email').val();
			if(email==''){
				jQuery('#email_error').html('Please enter email id');
			}else{
				jQuery('.email_sent_otp').html('Please wait..');
				jQuery('.email_sent_otp').attr('disabled',true);
				jQuery.ajax({
					url:'send_otp.php',
					type:'post',
					data:'email='+email+'&type=email',
					success:function(result){
						if(result=='done'){
							jQuery('#email').attr('disabled',true);
							jQuery('.email_verify_otp').show();
							jQuery('.email_sent_otp').hide();
							
						}else if(result=='email_present'){
							jQuery('.email_sent_otp').html('Send OTP');
							jQuery('.email_sent_otp').attr('disabled',false);
							jQuery('#email_error').html('Email id already exists');
						}else{
							jQuery('.email_sent_otp').html('Send OTP');
							jQuery('.email_sent_otp').attr('disabled',false);
							jQuery('#email_error').html('Please try after sometime');
						}
					}
				});
			}
		}
		function email_verify_otp(){
			jQuery('#email_error').html('');
			var email_otp=jQuery('#email_otp').val();
			if(email_otp==''){
				jQuery('#email_error').html('Please enter OTP');
			}else{
				jQuery.ajax({
					url:'check_otp.php',
					type:'post',
					data:'otp='+email_otp+'&type=email',
					success:function(result){
						if(result=='done'){
							jQuery('.email_verify_otp').hide();
							jQuery('#email_otp_result').html('Email id verified');
							jQuery('#is_email_verified').val('1');
							jQuery('#btn_register').attr('disabled',false);
							
						}else{
							jQuery('#email_error').html('Please enter valid OTP');
						}
					}
					
				});
			}
		}
		
		</script>
<?php require('footer.php')?>        