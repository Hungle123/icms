 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/sidebar-admin.php');
 ?>
   	<?php
   		// xu ly form
   		if($_SERVER['REQUEST_METHOD'] == 'POST'){ // gia tri toi tai xu ly form
   		   $errors = array();
        //page name
        if(empty($_POST['page_name'])){
          $errors[] = 'page_name';
        }else{
          $page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page_name']));
        }

        //cactegory
        if(isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT,array('min_range' =>1))){
          $cat_id = $_POST['category'];
        }else{
          $errors[] = 'category';
        }

        //position.
        if(isset($_POST['position']) && filter_var($_POST['position'],FILTER_VALIDATE_INT,array('min_range' =>1))){
          $position = $_POST['position'];
        }else{
          $errors[] = 'position';
        }

        //content
        if(empty($_POST['content'])){
          $errors[] = 'content';
        }else{
          $content = $_POST['content'];
        }

        if(empty($errors)){
          $q = "INSERT INTO pages (user_id, cat_id, page_name, content, position, post_on)
                  VALUES (1,{$cat_id },'{$page_name}','{$content}',{$position},NOW())";
          $r = mysqli_query($dbc,$q) or die ('Query: {$q} \n<br/>'.mysqli_error($dbc));
          if(mysqli_affected_rows($dbc) ==1){
            $message = "<p class='success'>The add pages is a successfly</p>";
          }else{
            $message = "<p class='warning'>Could not the add page due to the system error</p>";
          }
        }else{
          $message = "<p class='warning'>Please fill all the required fildes</p>";
        }

   		} //END main if 

   	?>
  <div id="content">
   	<h2>Create a Pages</h2>
   	<?php if(!empty($message)) echo $message ;?>
      <form action="" method="post" id="login">
        <fieldset>
          <legend>Add a page</legend>
          <div>
            <label for="page">Page Name: <span class="required">*</span>
              <?php
                if(isset($errors) && in_array('page_name',$errors)){
                  echo "<p class='warning'>Please fill all the page name</p>";
                }
              ?>
            </label>
            <input type="text" name="page_name" id="page_name" value="<?php if(isset($_POST['page_name'])) echo strip_tags($_POST['page_name']);?>" size="20" maxlength="80" tabindex="1" >
          </div>

          <div>
            <label for="category">All Categories: <span class="required">*</span>
              <?php
                if(isset($errors) && in_array('category',$errors)){
                  echo "<p class='warning'>Please fill all the category</p>";
                }
              ?>
            </label>
            <select name="category">
              <?php
                $q = "SELECT cat_id, cat_name FROM categories ORDER BY position ASC ";
                $r = mysqli_query($dbc,$q) or die ('Query: {$q} \n<br/>'.mysqli_error($dbc));
                if(mysqli_num_rows($r) > 0){
                  while($cats = mysqli_fetch_array($r,MYSQLI_NUM)){
                    echo "<option value='{$cats[0]}'";
                      if(isset($_POST['category']) && $_POST['category'] == $cats[0]) echo "selected = 'selected'";
                    echo ">".$cats[1]."</option>";
                  }
                }
              ?>
            </select>
          </div>
          
          <div>
            <label for="position">Position: <span class="required">*</span>
              <?php
                if(isset($errors) && in_array('position',$errors)){
                  echo "<p class='warning'>Please fill all the position</p>";
                }
              ?>
            </label>
            <select name="position">
              <?php 
                  $q = "SELECT count(cat_name) as count from categories";
                  $r = mysqli_query($dbc, $q) or die ('Query: {$q} \n<br/>'.mysqli_error($dbc));
                  if(mysqli_num_rows($r) ==1){
                    list ($num) = mysqli_fetch_array($r,MYSQL_NUM);
                    for($i = 1;$i <= $num+1;$i++){
                      echo "<option value='{$i}'";
                        if(isset($_POST['position']) && $_POST['position'] ==$i) echo "selected = 'selected'";
                      echo ">".$i."</option>";
                    }
                  } 
              ?>
            </select>
          </div>

          <div>
            <label for="content">Page Content: <span class="required">*</span>
              <?php
                if(isset($errors) && in_array('content',$errors)){
                  echo "<p class='warning'>Please fill all the content</p>";
                }
              ?>
            </label>
            <textarea name="content"cols="50" rows="20"></textarea>
          </div>

        </fieldset>
        <p><input type="submit" name="submit" value="Add Page"></p>
      </form>
  </div><!--end content-->
<?php
    include ('../includes/sidebar-b.php');
    include ('../includes/footer.php');
?>

