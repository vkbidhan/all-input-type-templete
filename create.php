
<?php include 'inc/header.php'; ?>
<?php
	session_start();
	if(empty($_SESSION['userinfo'])){
        header ("Location: signin.php");
	}
?>
<?php
    if(isset($_POST['submit'])){
        $error = '';
        $success = '';

        if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['website']) || empty($_POST['country']) || empty($_POST['subject']) || empty($_POST['gender']) || empty($_FILES['image']) ){			
			$error = "<span style='color:red;font-weight:bold'>Require field can't be empty...</span>";
        }else{
        	$name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        	$email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        	$website  = filter_var($_POST['website'], FILTER_SANITIZE_URL);

        	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error = "<span style='color:red;font-weight:bold'>Email address Invalid.</span>";
        	}else{
        		if(!filter_var($website, FILTER_VALIDATE_URL)){
					$error = "<span style='color:red;font-weight:bold'>Website address Invalid.</span>";
	        	}else{

	        		$allowed      =  array('gif','png' ,'jpg');
					$filename     = $_FILES['image']['name'];
					$templocation = $_FILES['image']['tmp_name'];
					$filesize     = $_FILES['image']['size'];
					$filekb       = ceil($filesize/1024);
                    
                    
                    /*
	                    $info = explode('.',$_FILES['image']['name']);
					    $file_ext = strtolower(end($info));
					    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
					    $uploaded_image = "upload/".$unique_image;
				    */

					$ext            = pathinfo($filename, PATHINFO_EXTENSION);//Find out File extension
                    $fileformate    = strtolower($ext);
                    $unique_image   = substr(md5(time()), 0, 10).'.'.$fileformate;
				    $uploaded_image = "uploads/".$unique_image;
				    
                    if(!in_array($fileformate,$allowed) ) {
					 	$error = "<span style='color:red;font-weight:bold'>Image format must be jpg,png,gif,jpeg.</span>";
					}else{
						if($filekb > 1048576){//1048576 == 2mb
							$error = "<span style='color:red;font-weight:bold'>File size must be content within 2 mb.</span>";
						}else{

							$link = mysql_connect("localhost", "root", "");
							mysql_select_db("crud", $link);

							$name     = mysql_real_escape_string($name, $link);
							$email    = mysql_real_escape_string($email, $link);
							$website  = mysql_real_escape_string($website, $link);
							$country  = $_POST['country'];
                            $subjects = implode(",",$_POST['subject']);
							$gender   = $_POST['gender'];
                            $userId   = $_SESSION['userinfo']['userId'];
                            $date     = date('Y-m-d');

                            move_uploaded_file($templocation, $uploaded_image);
							$sql = "INSERT INTO addstudent (id,userId,name,email,website,country,subject,gender,image,created_at,updated_at,is_deleted) VALUES (null,'$userId','$name','$email','$website','$country','$subjects','$gender','$uploaded_image','$date','',0)";
							$result = mysql_query($sql);
							if($result){
								$error = "<span style='color:green;font-weight:bold'>Student Added Successflly.</span>";
							}else{
								$error = "<span style='color:red;font-weight:bold'>Insertion Failed.</span>";
							}
						}
					}
	        	}
        	}
        }
	}
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Student Information <a class="btn btn-success pull-right" href="view.php">Back</a></h2>
	<?php 
		if(isset($success)){ echo $success; }
		if(isset($error)){ echo $error; }
	?>
	</div>
	<div class="panel-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label for="name">Student Name</label>
				<input class="form-control" type="text" name="name" id="name">
			</div>
			<div class="form-group">
				<label for="email">Student Email</label>
				<input class="form-control" type="email" name="email" id="email">
			</div>			
			<div class="form-group">
				<label for="website">Website</label>
				<input class="form-control" type="website" name="website" id="website">
			</div>
			<div class="form-group">
			  <label for="country">Select Country </label>
			  <select class="form-control" id="country" name="country">
			    <option>Select Country</option>
			    <option value="Bangladesh">Bangladesh</option>
			    <option value="India">India</option>
			    <option value="Canada">Canada</option>
			    <option value="Singapur">Singapur</option>
			    <option value="Australia">Australia</option>
			  </select>
			</div>
			<div class="form-group">
				<label>Subject</label>
				<label class="checkbox-inline"><input type="checkbox" name="subject[]" value="Bangla">Bangla</label>
				<label class="checkbox-inline"><input type="checkbox" name="subject[]" value="English">English</label>
				<label class="checkbox-inline"><input type="checkbox" name="subject[]" value="Mathematic">Mathematic</label>
				<label class="checkbox-inline"><input type="checkbox" name="subject[]" value="Physic">Physic</label>
				<label class="checkbox-inline"><input type="checkbox" name="subject[]" value="Computer">Computer</label>
			</div>
			<div class="form-group">
				<label>Gender</label>
				<label class="radio-inline"><input type="radio" name="gender" value="Male">Male</label>
				<label class="radio-inline"><input type="radio" name="gender" value="Female">Female</label>
				<label class="radio-inline"><input type="radio" name="gender" value="others">Other</label>
			</div>
			<div class="form-group">
				<label>Avatar</label>
				<label class="radio-inline"><input type="file" name="image"/></label>
			</div>
			<div class="form-group">
				<input class="btn btn-primary" type="submit" name="submit" value="Add Student">
				<input class="btn btn-primary" type="reset" name="reset" value="Reset Data">
			</div>			
		</form>
	</div>
</div>

<?php include 'inc/footer.php'; ?>
