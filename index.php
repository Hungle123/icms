 <?php
    include ('includes/header.php');
    include ('includes/mysqli_connect.php');
    include ('includes/functions.php');
    include ('includes/sidebar-a.php');  

 ?>
  <div id="content">
 <?php
    if(isset($_GET['cid']) && filter_var($_GET['cid'],FILTER_VALIDATE_INT,array('min_range' =>1))){
        $cid = $_GET['cid'];
        $q = "SELECT p.page_name, p.page_id,p.content,";
        $q .= " DATE_FORMAT(p.post_on, '%b %d %Y') AS date, ";
        $q .= " CONCAT_WS(' ',u.first_name, u.last_name) AS name,u.user_id ";
        $q .= " FROM pages as p INNER JOIN user AS u ";
        $q .= " USING(user_id) WHERE p.cat_id = {$cid} ";
        $q .= " ORDER BY date ASC LIMIT 0,10 ";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if(mysqli_num_rows($r) > 0){
            while ($pages = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
                echo "
                    <div class='post'>
                        <h2><a href='single.php?pid={$pages['page_id']}'>{$pages['page_name']}</a></h2>
                        <p>".the_excerpt($pages['content'])." ... <a href='single.php?pid={$pages['page_id']}'>Read more</a></p>
                        <p class='meta'><strong>Posted by: </strong>{$pages['name']} | <strong>On: </strong>{$pages['date']}</p>

                    </div>
                ";
            }
        }
    }

 ?>
   
        <h2>Welcome To izCMS</h2>
        <div>
            <p>
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
            </p>
            
            <p>
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
            </p>
            
            <p>
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus
            </p>
        </div>

    </div><!--end content-->
<?php
        include ('includes/sidebar-b.php');
        include ('includes/footer.php');
?>