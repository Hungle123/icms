 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/functions.php');
    include ('../includes/sidebar-admin.php');
 ?>
   	<?php
      if(isset($_GET['pid']) && filter_var($_GET['pid'],FILTER_VALIDATE_INT,array('min_range'=>1))){
        $pid = $_GET['pid'];
      }else{
        redirest_to('admin/admin.php');
      }

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
          $q = "UPDATE pages SET page_name = '{$page_name}', cat_id ={$cat_id},position ={$position},content ='{$content}',post_on = NOW() WHERE  page_id = {$pid} LIMIT 1";
          $r = mysqli_query($dbc,$q);
          confirm_query($r,$q);
          if(mysqli_affected_rows($dbc) ==1){
            $message = "<p class='success'>The update pages is a successfly</p>";
          }else{
            $message = "<p class='warning'>Could not the update page due to the system error</p>";
          }
        }else{
          $message = "<p class='warning'>Please fill all the required fildes</p>";
        }

   		} //END main if 

   	?>
  <div id="content">
  <?php
    $q = "SELECT page_name,cat_id, position, content FROM pages WHERE page_id = {$pid}";
    $r = mysqli_query($dbc,$q);
    confirm_query($r, $q);
    if(mysqli_num_rows($r) > 0){
      $pages = mysqli_fetch_array($r,MYSQL_ASSOC);
    }else{
      $message =  "<p class='warning'>errors</p>";
    }

  ?>
   	<h2>Update a Pages: <?php if(isset($pages['page_name'])) echo $pages['page_name'];?></h2>
   	<?php if(!empty($message)) echo $message ;?>
      <form action="" method="post" id="pages">
        <fieldset>
          <legend>Edit a page</legend>
          <div>
            <label for="page">Page Name: <span class="required">*</span>
              <?php
                if(isset($errors) && in_array('page_name',$errors)){
                  echo "<p class='warning'>Please fill all the page name</p>";
                }
              ?>
            </label>
            <input type="text" name="page_name" id="page_name" value="<?php if(isset($pages['page_name'])) echo strip_tags($pages['page_name']);?>" size="20" maxlength="80" tabindex="1" >
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
                      if(isset($pages['cat_id']) && $pages['cat_id'] == $cats[0]) echo "selected = 'selected'";
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
                       if(isset($pages['position']) && $pages['position']==$i) echo "selected = 'selected'";
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
            <textarea name="content"cols="50" rows="20"><?php if (isset($pages['content'])) echo $pages['content'];?></textarea>
          </div>

        </fieldset>
        <p><input type="submit" name="submit" value="Update Page"></p>
      </form>
  </div><!--end content-->
<?php
    include ('../includes/sidebar-b.php');
    include ('../includes/footer.php');
?>

