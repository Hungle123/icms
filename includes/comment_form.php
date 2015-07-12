<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){	
		// khoi tao bien error chua loi.
		$errors = array();

		//validate name
		if(!empty($_POST['name'])){
			$name = mysqli_real_escape_string($dbc,strip_tags($_POST['name']));
		}else{
			$errors[] = "name";
		}

		// validate email
		if(isset($_POST['email']) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL,array('min_range' =>1))){
			$email = mysqli_real_escape_string($dbc,strip_tags($_POST['email']));
		}else{
			$errors[] = 'email';
		}

		// validate comment
		if(empty($_POST['comment'])){
			$errors[] = 'comment';
		}else{
			$comment = mysqli_real_escape_string($dbc,strip_tags($_POST['comment']));
		}

		// validate captcha
		if(isset($_POST['captcha']) && trim($_POST['captcha'] !=5)){
			$errors[]= 'captcha';
		}

		if(empty($errors)){
			$q = "INSERT INTO comments (page_id, author, email, comment, comment_date) VALUES ({$pid}, '{$name}', '{$email}', '{$comment}', NOW())";
			$r = mysqli_query($dbc,$q);
			confirm_query($r, $q);
			if(mysqli_affected_rows($dbc) == 1){
				$message = "<p class='success'>Thank you for your comment.</p>";
			}else{
				$message = "<p class='error'>The post comment due to the system error.</p>";
			}
		}else{
			$message = "<p class='error'>Please try again</p>";
		}
	}// End main if
?>
<?php 
	// hien thi comment tu csdl
	$q = "SELECT author,comment, DATE_FORMAT(comment_date, '%b %d, %Y') as date FROM comments WHERE page_id = {$pid}";
	$r = mysqli_query($dbc,$q);
	confirm_query($r,$q);
	if(mysqli_num_rows($r) > 0){
		echo "<ol id='disscuss'>";
		while (list($author, $comment, $date) = mysqli_fetch_array($r, MYSQLI_NUM)) {
			echo "
				<li>
					<p class='author'>{$author}</p>
					<p class='comment-sec'>{$comment}</p>
					<p class='date'>{$date}</p>
				</li>
				";
		}
		echo "</ol>";
	}else{
		echo "<h2>Be the first to leave a comment.</h2>";
	}
 ?>
<?php if(!empty($message)) echo $message ;?>
<form action="" method="post" id="comment_form">
	<fieldset>
		<legend>Leave a comment</legend>
		<div>
            <label for="name">Name: <span class="required">*</span>
            	<?php 
            		if(isset($errors) && in_array('name',$errors)) {
            		 echo "<span class='warning'>Please enter your name.</span>";
            		 }
            	?>
            </label>
            <input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) {echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8');} ?>" size="20" maxlength="80" tabindex="1" />
        </div>
		<div>
			<label for="email">Email: <span class="required">*</span>
				<?php 
					if(isset($errors) && in_array('email',$errors)){
						echo "<span class='warning'>Please enter your email.</span>";

					}
				 ?>
			</label>
			<input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" size="20" maxlength="80" tabindex="2">
		</div>
		<div>
			<label for="comment">Your comment: <span class="required">*</span>
				<?php 
					if(isset($errors) && in_array('comment',$errors)){
						echo "<span class='warning'>Please enter your comment.</span>";
					}
				?>
			</label>
			<div id="comment"><textarea name="comment" cols="70" rows="10" tabindex="3"><?php if(isset($_POST['comment'])) echo $_POST['comment']; ?></textarea></div>
		</div>
		<div>
			<label for="captcha">Answer questions: one plus two <span class="required">*</span>
				<?php 
					if(isset($errors) && in_array('captcha',$errors)){
						echo "<span class='warning'>Please enter your captcha.</span>";
					}
				?>
			</label>
			<input type="text" name="captcha" id="captcha" size="20" maxlength="80" tabindex="4">
		</div>
	</fieldset>
	<input type="submit" name="submit" id="submit" value="Post comment">
</form>