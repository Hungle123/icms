 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/functions.php');
    include ('../includes/sidebar-admin.php');


 ?>
   	<?php
      if(isset($_GET['cid']) && filter_var($_GET['cid'],FILTER_VALIDATE_INT,array('min_range'=>1))){
        $cid = $_GET['cid'];
      }else{
        redirest_to('admin/admin.php');
      }
   		// xu ly form
   		if($_SERVER['REQUEST_METHOD'] == 'POST'){ // gia tri toi tai xu ly form
   			$errors =array();

        // kiem tra ten cua categories
   			if(empty($_POST['category'])){
   				$errors[]= "category";
   			}else{
   				$cat_name = $_POST['category'];
   			}

        // kiem tra position cua categories
   			if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' =>1))){
   				$position = mysqli_real_escape_string($dbc,strip_tags($_POST['position']));
   			}else{
   				$errors[]= "position";
   			}
   			if(empty($errors)){
   				// neu ko co loi thi chen vao csdl
	   			$q = "UPDATE categories SET cat_name = '{$cat_name}', position = {$position} WHERE cat_id ={$cid} LIMIT 1";
	   			$r = mysqli_query($dbc, $q);
          confirm_query($r,$q);
	   			if(mysqli_affected_rows($dbc) == 1){
	   				$message = "<p class='success'> The categories was updated successfly</p>";
	   			}else{
	   				$message = "<p class='warning'>COuld not the update categories due to the systom error</p>";
	   			}
	   		}else{
	   			$message =  "<p class='warning'>Please fill all the required flieds</p>";
	   		}
   		} //END main if 

   	?>
   	 <div id="content">
   	<h2>Edit a Categories: <?php if(isset($_GET['name'])) echo $_GET['name']?></h2>
   	<?php if(!empty($message)) echo $message ;?>
    <?php
          $q = "SELECT cat_name, positon, cat_id FROM categories WHERE cat_id={$cid}";
          $r = mysqli_query($dbc, $q);
          confirm_query($r,$q);
          if(mysqli_num_rows($r) > 0){
              list($cats) = mysqli_fetch_array($r,MYSQLI_ASSOC);
          } 

    ?>
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
				<input type="text" id="category" name="category" maxlength="80" value="<?php        
          if(isset($_POST['category'])) echo strip_tags($_POST['category']);?> " size="20" tabindex="1">
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

