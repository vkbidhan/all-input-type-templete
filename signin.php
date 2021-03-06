<?php
	session_start();
	if(isset($_SESSION['userinfo']) && $_SESSION['userinfo'] != ''){
        header ("Location: create.php");
	}

    if(isset($_POST['login'])){
        $error = '';
        $success = '';

        if(empty($_POST['email']) || empty($_POST['password'])){
			$error = "<span style='color:red;font-weight:bold'>Require field can't be empty!</span>";
        }else{
        	$link = mysql_connect("localhost", "root", "");
        	mysql_select_db("crud", $link);

			if(isset($_COOKIE['email']) AND isset($_COOKIE['password'])){
		        $email    = filter_var($_COOKIE['email'], FILTER_SANITIZE_STRING);
		        $email    = mysql_real_escape_string($_COOKIE['email'],$link);
        		$password = mysql_real_escape_string($_COOKIE['password'],$link);
		    }else {
	        	$email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);    		
	        	$email    = mysql_real_escape_string($_POST['email'],$link);
	        	$password = mysql_real_escape_string($_POST['password'],$link);
			}

			$sql = mysql_query("SELECT * FROM users WHERE (email = '$email' OR username = '$email') AND active='0'");
			$match  = mysql_num_rows($sql);

    		if($match > 0){
    			$error = "<span style='color:red;font-weight:bold'>Account not activated yet !</span>";	
    		}else{                
				$sql = mysql_query("SELECT * FROM users WHERE (email = '$email' OR username = '$email')
					") or die(mysql_error()); 
				$row  = mysql_num_rows($sql);
				$userinfo = mysql_fetch_assoc($sql);
				$store_pass = $userinfo['password'];
				$check_password = password_verify($password,$store_pass);				
				if($check_password){
					if (isset($_POST['remember'])) {
						/* Set cookie to last 1 year */
						if(!isset($_COOKIE['email']) AND !isset($_COOKIE['password']) ){
							setcookie('email', $email, time()+60*60*24*365 , '/', null, null , true);//true for http
							setcookie('password', $password, time()+60*60*24*36 , '/', null, null , true);
						}
					}
					session_start();
					$_SESSION['userinfo'] = $userinfo;
					header('Location: create.php');
				}else{
					$error = "<span style='color:red;font-weight:bold'>Username and password invalid !</span>";
				}
    		}
        }
    }

?>

<?php include_once 'inc/admin/header.php'; ?>
	<?php 
		if(isset($success)){ echo $success; }
		if(isset($error)){ echo $error; }
		if(isset($_SESSION['message'])){ echo $_SESSION['message'];unset($_SESSION['message']); }
    ?>
	<form class="form-horizontal" action=""  method="POST">
		<div class="form-group">
			<label for="email" class="control-label">Your Email or Username<span style="color:red;">*</span></label>						
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
				<input type="text" class="form-control" name="email" value="<?php if(isset($_COOKIE['email'])){ echo $_COOKIE['email']; }  ?>"  placeholder="Enter your Email"/>
			</div>						
		</div>
		<div class="form-group">
			<label for="password" class="control-label">Password<span style="color:red;">*</span></label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
				<input type="password" class="form-control" name="password" value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; }?>" placeholder="Enter your Password"/>
			</div>
		</div>	
		<div class="form-group">
			<label class="checkbox-inline"><input type="checkbox" name="remember" value="remember" <?= isset($_COOKIE['email']) ? 'checked' : '' ?> >Remember Me</label>
		</div>
		<div class="form-group ">
			<input class="btn btn-primary btn-lg btn-block login-button" type="submit" name="login" value="Login">
		</div>
	</form>
	<div class="login-register">
		<a style="font-size: 15px;font-weight: bold;" href="signup.php">Create Account</a> <br/>
        <a style="font-size: 15px;font-weight: bold;" href="forgotpass.php"> Forgot your password ? </a>
     </div>
<?php include_once 'inc/admin/footer.php'; ?>