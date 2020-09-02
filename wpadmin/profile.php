<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Bitscoin Token Admin</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div id="profile">
<b id="welcome">Welcome : <i><?php echo $login_session; ?></i></b>
<b id="logout"><a href="logout.php">Log Out</a></b>

</div>
<?php

// php code to search data in mysql database and set it in input text

if(isset($_POST['search']))
{
    // id to search
    $id = $_POST['id'];
    
    // connect to mysql
    $connect = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
    
    // mysql search query
    $query = "SELECT `id`, `username`, `email` FROM `users` WHERE `id` = $id LIMIT 1";
    
    $result = mysqli_query($connect, $query);
    
    // if id exist 
    // show data in inputs
    if(mysqli_num_rows($result) > 0)
    {
      while ($row = mysqli_fetch_array($result))
      {
        $id = $row['id'];
        $fname = $row['username'];
        $lname = $row['email'];
      }  
    }
    
    // if the id not exist
    // show a message and clear inputs
    else {
        echo "Undifined ID";
            $id = "";
            $fname = "";
            $lname = "";
           
    }
    
    
    mysqli_free_result($result);
    mysqli_close($connect);
    
}

// in the first time inputs are empty
else{
     $id = "";
    $fname = "";
    $lname = "";
   
}


?>
<h2>Input your user id and active his packages</h2>
 <form method="post">
<div class="form-group">

        Id:<input type="text" name="id"><br><br>
<table class="table table-hover">
<tr>
       Id:<input type="text"  value="<?php echo $id;?>"><br>
<br>
        First Name:<input type="text"  value="<?php echo $fname;?>"><br>
<br>

        Last Name:<input type="text"  value="<?php echo $lname;?>"><br><br></tr>
<tr>
      	<td><a class="btn btn-success" href="silver.php?id=<?= $id; ?>">Silver</a></td>
        <td><a class="btn btn-success" href="gold.php?id=<?= $id; ?>">Gold</a></td>
        <td><a class="btn btn-success" href="platinum.php?id=<?= $id; ?>">Platinum</a></td>
        <td><a class="btn btn-success" href="daimond.php?id=<?= $id; ?>">Daimond</a></td>
</tr></table>
</div>
        <input type="submit" name="search" value="Find">

           </form>

<br><br><br>

<?php 

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");

$select = "SELECT * FROM users";                                                                                                                                                                     
$res = mysqli_query($conn, $select);

 ?>
<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql = "SELECT COUNT(*) FROM users";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM users LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
      
        mysqli_close($conn);
    ?>
   

<br>
<h2>Your Users</h2>

<div class="col-md-12">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
       <th scope="col">Silver</th>
      <th scope="col">Gold</th>
      <th scope="col">Platinum</th>
      <th scope="col">Daimond</th>
    </tr>
  </thead>
  <tbody>
      <?php while($data = mysqli_fetch_array($res_data)): ?>

    <tr>
     	<td><?= $data['id']; ?></td>
 		<td><?= $data['username']; ?></td>
 		<td><?= $data['email']; ?></td>
 		<td><a class="btn btn-success" href="silver.php?id=<?= $data['id']; ?>">Silver</a></td>
        <td><a class="btn btn-success" href="gold.php?id=<?= $data['id']; ?>">Gold</a></td>
        <td><a class="btn btn-success" href="platinum.php?id=<?= $data['id']; ?>">Platinum</a></td>
        <td><a class="btn btn-success" href="daimond.php?id=<?= $data['id']; ?>">Daimond</a></td>
    </tr>
    	<?php 
 	endwhile;
 	 ?>
   
    <ul class="pagination">
        <li><a href="?pageno=1" class="btn btn-success">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class="btn btn-success" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul> 
  </tbody>
</table>
</div><br><br><br>
<?php

// php code to search data in mysql database and set it in input text

if(isset($_POST['silver']))
{
    // id to search
    $id = $_POST['id'];
    
    // connect to mysql
    $connect = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
    
    // mysql search query
    $query = "SELECT * FROM user_balance where referred_to = '$id'";
    
    $result = mysqli_query($connect, $query);
    
    // if id exist 
    // show data in inputs
    if(mysqli_num_rows($result) > 0)
    {
      while ($row = mysqli_fetch_array($result))
      {
        $referred_by = $row['referred_to'];
        $user_id = $row['user_id'];
      
      }  
    }
    
    // if the id not exist
    // show a message and clear inputs
    else {
        echo "Undifined ID";
         

    }
    
    
    mysqli_free_result($result);
    mysqli_close($connect);
    
}

// in the first time inputs are empty
else{
     $id = "";
    $fname = "";
    $lname = "";
   
}


?>
<h2>Input his ref id and show his $</h2>
<h1>"Silver"</h1>
 <form method="post">
<div class="form-group">

        Id:<input type="text" name="id"><br><br>
<table class="table table-hover">
<tr>
<br>
        First Name:<input type="text"  value="<?php echo $user_id;?>"><br>
<br>

<tr>
        <td><a class="btn btn-success" href="silverusd.php?id=<?= $referred_by; ?>">Show Usd</a></td>
</tr></table>
</div>
        <input type="submit" name="silver" value="Find">

           </form>

<br><br>
<?php

// php code to search data in mysql database and set it in input text

if(isset($_POST['gold']))
{
    // id to search
    $id = $_POST['id'];
    
    // connect to mysql
    $connect = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
    
    // mysql search query
    $query = "SELECT * FROM gold where user_id = '$id'";
    
    $result = mysqli_query($connect, $query);
    
    // if id exist 
    // show data in inputs
    if(mysqli_num_rows($result) > 0)
    {
      while ($row = mysqli_fetch_array($result))
      {
        $referred_by = $row['ref_by'];
        $user_id = $row['user_id'];
      
      }  
    }
    
    // if the id not exist
    // show a message and clear inputs
    else {
        echo "Undifined ID";
         

    }
    
    
    mysqli_free_result($result);
    mysqli_close($connect);
    
}

// in the first time inputs are empty
else{
     $id = "";
    $fname = "";
    $lname = "";
   
}


?>
<h2>Input his ref id and show his $</h2>
<h1>"Gold"</h1>
 <form method="post">
<div class="form-group">

        Id:<input type="text" name="id"><br><br>
<table class="table table-hover">
<tr>
<br>
        First Name:<input type="text"  value="<?php echo $referred_by;?>"><br>
<br>

<tr>
        <td><a class="btn btn-success" href="goldusd.php?id=<?= $user_id; ?>">Show Usd</a></td>
</tr></table>
</div>
        <input type="submit" name="gold" value="Find">

           </form>

<br><br>

<?php

// php code to search data in mysql database and set it in input text

if(isset($_POST['plat']))
{
    // id to search
    $id = $_POST['id'];
    
    // connect to mysql
    $connect = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
    
    // mysql search query
    $query = "SELECT * FROM platinum where user_id = '$id'";
    
    $result = mysqli_query($connect, $query);
    
    // if id exist 
    // show data in inputs
    if(mysqli_num_rows($result) > 0)
    {
      while ($row = mysqli_fetch_array($result))
      {
        $referred_by = $row['ref_by'];
        $user_id = $row['user_id'];
      
      }  
    }
    
    // if the id not exist
    // show a message and clear inputs
    else {
        echo "Undifined ID";
         

    }
    
    
    mysqli_free_result($result);
    mysqli_close($connect);
    
}

// in the first time inputs are empty
else{
     $id = "";
    $fname = "";
    $lname = "";
   
}


?>
<h2>Input his ref id and show his $</h2>
<h1>"Platinum"</h1>
 <form method="post">
<div class="form-group">

        Id:<input type="text" name="id"><br><br>
<table class="table table-hover">
<tr>
<br>
        First Name:<input type="text"  value="<?php echo $referred_by;?>"><br>
<br>

<tr>
        <td><a class="btn btn-success" href="platusd.php?id=<?= $user_id; ?>">Show Usd</a></td>
</tr></table>
</div>
        <input type="submit" name="plat" value="Find">

           </form>

<br><br>

<?php

// php code to search data in mysql database and set it in input text

if(isset($_POST['daim']))
{
    // id to search
    $id = $_POST['id'];
    
    // connect to mysql
    $connect = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
    
    // mysql search query
    $query = "SELECT * FROM daimond where referred_to = '$id'";
    
    $result = mysqli_query($connect, $query);
    
    // if id exist 
    // show data in inputs
    if(mysqli_num_rows($result) > 0)
    {
      while ($row = mysqli_fetch_array($result))
      {
        $referred_by = $row['referred_to'];
        $user_id = $row['user_id'];
      
      }  
    }
    
    // if the id not exist
    // show a message and clear inputs
    else {
        echo "Undifined ID";
         

    }
    
    
    mysqli_free_result($result);
    mysqli_close($connect);
    
}

// in the first time inputs are empty
else{
     $id = "";
    $fname = "";
    $lname = "";
   
}


?>
<h2>Input his user id and show his $</h2>
<h1>"Daimond"</h1>
 <form method="post">
<div class="form-group">

        Id:<input type="text" name="id"><br><br>
<table class="table table-hover">
<tr>
<br>
        First Name:<input type="text"  value="<?php echo $referred_by;?>"><br>
<br>

<tr>
        <td><a class="btn btn-success" href="platusd.php?id=<?= $user_id; ?>">Show Usd</a></td>
</tr></table>
</div>
        <input type="submit" name="plat" value="Find">

           </form>

<br><br>
<h1>"Withdraw Request"</h1>
<h2>JazzCash Request</h2>

<div class="col-md-12">

<?php 

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");

$select1 = "SELECT * FROM jazzcash";                                                                                                                                                                     
$res = mysqli_query($conn, $select1);

 ?>
<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql2 = "SELECT COUNT(*) FROM jazzcash";
        $result = mysqli_query($conn,$total_pages_sql2);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql2 = "SELECT * FROM jazzcash LIMIT $offset, $no_of_records_per_page";
        $res_data2 = mysqli_query($conn,$sql2);
      
        mysqli_close($conn);
    ?>
   

<br>
<h2>Your Users</h2>

<div class="col-md-12">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">User_id</th>
      <th scope="col">Email</th>
      <th scope="col">Amount</th>
      <th scope="col">Jazzcash No</th>
      <th scope="col">Payment Method</th>
    </tr>
  </thead>
  <tbody>
      <?php while($data2 = mysqli_fetch_array($res_data2)): ?>

    <tr>
     	<td><?= $data2['id']; ?></td>
 		<td><?= $data2['user_id']; ?></td>
 		<td><?= $data2['username']; ?></td>
 		<td><?= $data2['amount']; ?></td>
    <td><?= $data2['jazzcashno']; ?></td>

<td><a class="btn btn-success" href="platinum.php?id=<?= $data2['id']; ?>">Confirm</a></td>
    </tr>
    	<?php 
 	endwhile;
 	 ?>
   
    <ul class="pagination">
        <li><a href="?pageno=1" class="btn btn-success">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class="btn btn-success" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul> 
  </tbody>
</table>
</div>
<br><br>
<h2>EasyPaisa Request</h2>

<?php 

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");

$select3 = "SELECT * FROM easypiasa";                                                                                                                                                                     
$res = mysqli_query($conn, $select3);

 ?>
<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql3 = "SELECT COUNT(*) FROM easypiasa";
        $result = mysqli_query($conn,$total_pages_sql3);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql3 = "SELECT * FROM easypiasa LIMIT $offset, $no_of_records_per_page";
        $res_data3 = mysqli_query($conn,$sql3);
      
        mysqli_close($conn);
    ?>
   

<br>
<h2>Your Users</h2>

<div class="col-md-12">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">User_id</th>
      <th scope="col">Username</th>
      <th scope="col">Amount</th>
      <th scope="col">easypaisa No</th>
      <th scope="col">Payment Method</th>
    </tr>
  </thead>
  <tbody>
      <?php while($data3 = mysqli_fetch_array($res_data3)): ?>

    <tr>
     	<td><?= $data3['id']; ?></td>
 		<td><?= $data3['user_id']; ?></td>
 		<td><?= $data3['email']; ?></td>
 		<td><?= $data3['amount']; ?></td>
    <td><?= $data3['easypaisano']; ?></td>

<td><a class="btn btn-success" href="platinum.php?id=<?= $data3['id']; ?>">Confirm</a></td>
    </tr>
    	<?php 
 	endwhile;
 	 ?>
   
    <ul class="pagination">
        <li><a href="?pageno=1" class="btn btn-success">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class="btn btn-success" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul> 
  </tbody>
</table>
</div><br><br>
<h2>Bitcoin Request</h2>

<?php 

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");

$select4 = "SELECT * FROM bitcoin";                                                                                                                                                                     
$res = mysqli_query($conn, $select4);

 ?>
<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql4 = "SELECT COUNT(*) FROM bitcoin";
        $result = mysqli_query($conn,$total_pages_sql4);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql4 = "SELECT * FROM bitcoin LIMIT $offset, $no_of_records_per_page";
        $res_data4= mysqli_query($conn,$sql4);
      
        mysqli_close($conn);
    ?>
   

<br>
<h2>Your Users</h2>

<div class="col-md-12">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">User_id</th>
      <th scope="col">Email</th>
      <th scope="col">Amount</th>
      <th scope="col">bitcoin address</th>
    </tr>
  </thead>
  <tbody>
      <?php while($data4 = mysqli_fetch_array($res_data4)): ?>

    <tr>
     	<td><?= $data4['id']; ?></td>
 		<td><?= $data4['user_id']; ?></td>
 		<td><?= $data4['email']; ?></td>
 		<td><?= $data4['amount']; ?></td>
    <td><?= $data4['bitcoinadd']; ?></td>

<td><a class="btn btn-success" href="platinum.php?id=<?= $data4['id']; ?>">Confirm</a></td>
    </tr>
    	<?php 
 	endwhile;
 	 ?>
   
    <ul class="pagination">
        <li><a href="?pageno=1" class="btn btn-success">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class="btn btn-success" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul> 
  </tbody>
</table>
<br><br>
<h2>Paypal Request</h2>

<?php 

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");

$select5 = "SELECT * FROM paypal";                                                                                                                                                                     
$res = mysqli_query($conn, $select5);

 ?>
<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

$conn = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql5 = "SELECT COUNT(*) FROM paypal";
        $result = mysqli_query($conn,$total_pages_sql5);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql5 = "SELECT * FROM paypal LIMIT $offset, $no_of_records_per_page";
        $res_data5= mysqli_query($conn,$sql5);
      
        mysqli_close($conn);
    ?>
   

<br>
<h2>Your Users</h2>

<div class="col-md-12">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">User_id</th>
      <th scope="col">Email</th>
      <th scope="col">Amount</th>
      <th scope="col">Paypal id</th>
    </tr>
  </thead>
  <tbody>
      <?php while($data5 = mysqli_fetch_array($res_data5)): ?>

    <tr>
     	<td><?= $data5['id']; ?></td>
 		<td><?= $data5['user_id']; ?></td>
 		<td><?= $data5['email']; ?></td>
 		<td><?= $data5['amount']; ?></td>
    <td><?= $data5['paypalid']; ?></td>

<td><a class="btn btn-success" href="platinum.php?id=<?= $data5['id']; ?>">Confirm</a></td>
    </tr>
    	<?php 
 	endwhile;
 	 ?>
   
    <ul class="pagination">
        <li><a href="?pageno=1" class="btn btn-success">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a class="btn btn-success" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class="btn btn-success" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul> 
  </tbody>
</table>
</body>
</html>