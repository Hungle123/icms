 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/functions.php');
    include ('../includes/sidebar-admin.php');
 ?>
 <div class="content">
 <?php
  if(isset($_GET['cid'],$_GET['cat_name']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' =>1))){
    $cid = $_GET['cid'];
    $cat_name = $_GET['cat_name'];

    //neu cid va cat_name ton tai thi bat dau xu ly from
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      //xu ly from
      if(isset($_POST['delete']) && ($_POST['delete'] == 'yes')){
        $q = "DELETE FROM categories WHERE cat_id = {$cid} LIMIT 1";
        $r = mysqli_query($dbc,$q);
        confirm_query($r,$q);
        if(mysqli_affected_rows($dbc) ==1){
          $message = "<p class='success'>The categories was delete seccessflly</p>";
        }else{
          $message = "<p class='warning'>The categories was not delete due to the system error</p>";
        }
      }else{
        $message = "<p class='warning'>I thought so to ! shouldn't be deleted</p>";
      }
    }
  }else{
    redirest_to('admin/view_categories.php');
  }
 ?>
    <h2>Delete Category: <?php if(isset($cat_name)) echo $cat_name;?></h2>
    <?php if (isset($message)) echo $message;?>
    <form action="" method="post">
      <fieldset>
        <legend>Delete Categories</legend>
        <label for="delete">Are you sure ?</label>
        <div>
          <input type="radio" name="delete" value="no" checked="checked" /> No
          <input type="radio" name="delete" value="yes"/> Yes 
        </div>
        <div><input type="submit" name="submit" value="Delete"></div>
      </fieldset>
    </form>
 </div> <!-- end content -->
   	
<?php 
    include ('../includes/footer.php');
?>
