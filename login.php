<?php
require_once('connect.php');
session_start();
if(isset($_POST) && !empty($_POST)){
	
	$email = mysql_real_escape_string($_POST['email']);
	$password = mysql_real_escape_string($_POST['password']);
	
	if($email!='' && $password!=''){
		$is_user_qry = "SELECT id,email,password FROM users WHERE email='".$email."' AND password='".$password."' LIMIT 1";
		$is_user_res = mysql_query($is_user_qry);
		$is_user = mysql_num_rows($is_user_res);


		if($is_user>0){
			$user_row = mysql_fetch_array($is_user_res);

			$_SESSION['user_id'] = $user_row['id'];
			$_SESSION['email'] = $user_row['email'];

			header('location:index.php');
		} 
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog Login</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($){

		$('#user_login').submit(function(){
			var email = $('#email').val();
			var password = $('#password').val();
			
			if(email.trim()==''){
				alert("Please enter email");
				return false;
			}else if(password.trim()==''){
				alert("Please enter password");
				return false;
			}else{
				return true;
			}
		});
	});
</script>
</head>
<body>
	<form method="post" name="user_login" id="user_login">
	<table>
		<tr>
			<td>Email</td>
			<td><input type="text" name="email" id="email"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="user_submit" id="user_submit" value="submit"></td>
		</tr>
	</table>
	</form>
</body>
</html>

