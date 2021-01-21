<?php
require_once('connect.php');

if(isset($_POST) && !empty($_POST) && $_POST['type']=='chk_email'){
	$email = mysql_real_escape_string($_POST['email']);
	$email_qry = "SELECT id FROM users WHERE email='".$email."'";
	$email_res = mysql_query($email_qry);
	$email_row = mysql_num_rows($email_res);

	$msg = "";
	if($email_row>0){
		$msg = "duplicate";
	}
	echo $msg;
}

if(isset($_POST) && !empty($_POST)){
	
	$first_name = mysql_real_escape_string($_POST['first_name']);
	$last_name = mysql_real_escape_string($_POST['last_name']);
	$email = mysql_real_escape_string($_POST['email']);
	$password = mysql_real_escape_string($_POST['password']);
	
	if($email!='' && $password!=''){
		$user_is_qry = "INSERT INTO users SET
						first_name='".$first_name."',
						last_name='".$last_name."',
						email='".$email."',
						password='".$password."',
						created_at='".date('Y-m-d H:i:s')."'
						";
		$user_is_qry = mysql_query($user_is_qry);
		$last_id = mysql_insert_id();

		if($last_id>0){
			header('location:login.php');
		} 
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog Registration</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($){

		/*var msg = '<?php //echo $_REQUEST['msg'];?>';
		if(msg=='duplicate'){
			//alert
		}*/

		$('#user_reg').submit(function(){
			var first_name = $('#first_name').val();
			var last_name = $('#last_name').val();
			var email = $('#email').val();
			var password = $('#password').val();
			var cnf_password = $('#cnf_password').val();

			if(first_name.trim()==''){
				alert("Please enter first name");
				return false;
			}else if(last_name.trim()==''){
				alert("Please enter last name");
				return false;
			}else if(email.trim()==''){
				alert("Please enter email");
				return false;
			}else if(password.trim()==''){
				alert("Please enter password");
				return false;
			}else if(cnf_password.trim()==''){
				alert("Please enter confirm password");
				return false;
			}else if(password!=cnf_password){
				alert("Please enter same password");
				return false;
			}else{
				$.ajax({
					url:'registration.php',
					type:'post',
					data:{'email':email,'type':'chk_email'},
					success:function(data){
						if(data.trim()=='duplicate'){
							alert("This email is already registered.");
							return false;
						}else{
							return true;
						}
					}
				});
				
			}
		});
	});
</script>
</head>
<body>
	<form method="post" name="user_reg" id="user_reg">
	<table>
		<tr>
			<td>First Name</td>
			<td><input type="text" name="first_name" id="first_name"></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><input type="text" name="last_name" id="last_name"></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type="text" name="email" id="email"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
			<td><input type="password" name="cnf_password" id="cnf_password"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="user_submit" id="user_submit" value="submit"></td>
		</tr>
	</table>
	</form>
</body>
</html>

