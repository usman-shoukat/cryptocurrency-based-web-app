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
      	echo $row['confirm3'] ;
      	$app = $row['confirm3'];
    }

    $one = '2';
     	 if($app == $one){	
     	$edit = "UPDATE `users` SET `confirm3`= 0 WHERE `id` = $id";
     	
     	 $res = mysqli_query($db , $edit);
     	 header("location:profile.php");
     }

       
         
      

else{

   echo "error for insert";

}


 ?>