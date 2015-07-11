 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/sidebar-admin.php');


 ?>
   	<?php
   		// xu ly form
   		if($_SERVER['REQUEST_METHOD'] == 'POST'){ // gia tri toi tai xu ly form
   			$errors =array();
   			if(empty($_POST['category'])){
   				$errors[]= "category";
   			}else{
   				$cat_name = $_POST['category'];
   			}
   			if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' =>1))){
   				$position = mysqli_real_escape_string($dbc,strip_tags($_POST['position']));
   			}else{
   				$errors[]= "position";
   			}
   			if(empty($errors)){
   				// neu ko co loi thi chen vao csdl
	   			$q = "INSERT INTO categories (user_id, cat_name, position) values (1, '{$cat_name}', {$position})";
	   			$r = mysqli_query($dbc, $q) or die ('Query: {$q} \n<br/>'.mysqli_error($dbc));
	   			if(mysqli_affected_rows($dbc) == 1){
	   				$message = "<p class='success'> The categories was add successfly</p>";
	   			}else{
	   				$message = "<p class='warning'>Could not add Categories to the database due to the system error</p>";
	   			}
	   		}else{
	   			$message =  "<p class='warning'>Please fill all the required flieds</p>";
	   		}
   		} //END main if 

   	?>
   	 <div id="content">
   	<h2>Create a Categories</h2>
   	<?php if(!empty($message)) echo $message ;?>
   	<form action="" id="add_cat" method="post">
   		<fieldset>
   			<legend>Add Categories</legend>
   			<div>
   				<label for="category">Category name: <span class="required">*</span>
					<?php
							if(isset($errors) && in_array('category',$errors)){
								echo "<p class='warning'>Please fill all the category</p>";
							}
					 ?>
   				</label>
				<input type="text" id="category" name="category" maxlength="80" value="<?php if(isset($_POST['category'])) echo strip_tags($_POST['category']);?>" size="20" tabindex="1">
   			</div>
			
			<div>	
   				<label for="position">Position: <span class="required">*</span>
					<?php
							if(isset($errors) && in_array('position',$errors)){
								echo "<p  class='warning'>Please fill all the position</p>";
							}
					 ?>
   				</label>
				<select name="position" tabindex="2">
					<?php
						$q = "SELECT count(cat_name) as count from categories";
						$r = mysqli_query($dbc, $q) or die("Query: {$q} \n MySQLi error:".mysql_error($dbc));
						if(mysqli_num_rows($r) ==1){
							list($num) = mysqli_fetch_array($r,MYSQLI_NUM);
							for($i =1 ;$i <=$num+1;$i++){
								echo "<option value='{$i}'";
								if(isset($_POST['position']) && $_POST['position'] == $i) echo "selected = 'selected'";
								echo ">".$i."</option>";
							}
						}

					?>
				</select>
   			</div>

   		</fieldset>
   		<p><input type="submit" name="submit" value="Add Category"></p>
   	</form>   
 </div><!--end content-->
<?php
        include ('../includes/sidebar-b.php');
        include ('../includes/footer.php');
?>

