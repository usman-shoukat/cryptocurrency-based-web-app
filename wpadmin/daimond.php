<?php 
 $db = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor"); 
 if(!$db){
 echo "error";
 }else{
      echo "";
 }

$id = $_GET['id'];


      $sql = "SELECT * FROM users WHERE `id` = $id";
      $result = mysqli_query($db , $sql);
      while ($row = mysqli_fetch_array($result)) {
      	echo $row['confirm4'] ;
      	$app = $row['confirm4'];
    }

    $one = '4';
     	 if($app == $one){	
     	$edit = "UPDATE `users` SET `confirm4`= 0 WHERE `id` = $id";
     	
     	 $res = mysqli_query($db , $edit);
     	 header("location:profile.php");
     }

       
         
      

else{

   echo "error for insert";

}


 ?>