 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/functions.php');
    include ('../includes/sidebar-admin.php');
 ?>
 <div class="content">
    <h2>Manager Category</h2>
    <table>
      <thead>
        <tr>
          <th><a href="view_categories.php?soft=cat">Categories</a></th>
          <th><a href="view_categories.php?soft=pos">Position</a></th>
          <th><a href="view_categories.php?soft=pob">Posted by</a></th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>        
      </thead>
      <tbody>

      <?php
      // sap xep category
      if(isset($_GET['soft'])){
        switch ($_GET['soft']) {
          case 'cat':
            $order_by = 'cat_name';
            break;
          case 'pos':
            $order_by = 'position';
            break;
          case 'pob':
            $order_by = 'name';
            break;
          default:
            $order_by = 'position';
            break;
        }// end switch
      }else{
        $order_by = 'position';
      }
      // cau lenh truy van hien thi categoty
      $q = "SELECT c.cat_name, c.position,c.cat_id,CONCAT_WS(' ',first_name, last_name) as name FROM categories as c INNER JOIN user USING(user_id) ORDER BY {$order_by} ASC";
      $r = mysqli_query($dbc, $q);
      confirm_query($r, $q);
      if(mysqli_num_rows($r) > 0){
        while ($cats = mysqli_fetch_array($r,MYSQLI_ASSOC)){
          echo"
            <tr>
              <td>{$cats['cat_name']}</td>
              <td>{$cats['position']}</td>
              <td>{$cats['name']}</td>
              <td><a class='edit' href='edit_categories.php?cid={$cats['cat_id']}&name={$cats['cat_name']}'>Edit</a></td>
              <td><a class='delete' href='delete_categories.php?cid={$cats['cat_id']}'>Delete</a></td>
            </tr>
            ";
        }
      }

      ?>      

      </tbody>
    </table>
 </div> <!-- end content -->
   	
<?php 
    include ('../includes/footer.php');
?>

