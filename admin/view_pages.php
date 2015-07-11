 <?php
    include ('../includes/header.php');
    include ('../includes/mysqli_connect.php');
    include ('../includes/functions.php');
    include ('../includes/sidebar-admin.php');
 ?>
 <div class="content">
    <h2>Manager Pages</h2>
    <table>
      <thead>
        <tr>
          <th><a href="view_pages.php?soft=pan">Page Name</a></th>
          <th><a href="view_pages.php?soft=poo">Posted on</a></th>
          <th><a href="view_pages.php?soft=pob">Posted by</a></th>
          <th>Content</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>        
      </thead>
      <tbody>

      <?php
      // sap xep category
      if(isset($_GET['soft'])){
        switch ($_GET['soft']) {
          case 'pan':
            $order_by = 'page_name';
            break;
          case 'pob':
            $order_by = 'name';
            break;
          case 'poo':
            $order_by = 'post_on';
            break;
          default:
            $order_by = 'post_on';
            break;
        }// end switch
      }else{
        $order_by = 'post_on';
      }
      // cau lenh truy van hien thi categoty
      $q = "SELECT p.page_name, p.content, date_format(p.post_on,'%b %d %Y') as date, p.page_id, CONCAT_WS(' ',first_name, last_name) as name FROM pages as p INNER JOIN user USING(user_id) ORDER BY {$order_by} ASC";
      $r = mysqli_query($dbc, $q);
      confirm_query($r, $q);
      if(mysqli_num_rows($r) > 0){
        while ($pages = mysqli_fetch_array($r,MYSQLI_ASSOC)){
          echo"
            <tr>
              <td>{$pages['page_name']}</td>
              <td>{$pages['date']}</td>
              <td>{$pages['name']}</td>
              <td>{$pages['content']}</td>
              <td><a class='edit' href='edit_pages.php?pid={$pages['page_id']}'>Edit</a></td>
              <td><a class='delete' href='delete_pages.php?pid={$pages['page_id']}&page_name={$pages['page_name']}'>Delete</a></td>
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

