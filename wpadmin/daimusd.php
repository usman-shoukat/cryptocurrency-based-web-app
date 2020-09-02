<?php 
 $db = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor"); 
 if(!$db){
 echo "error";
 }else{
      echo "";
 }

$id = $_GET['id'];


      
    

   
     	$edit = "UPDATE `user_balance` SET `confirm`= 1 WHERE `referred_to` = ".$id."";
     	
     	 $res = mysqli_query($db , $edit);
     	 if(!$res){
     	     echo "error";
     	 }
     	 else{
     	 header("location:profile.php");
     	 }

       
         
      




 ?>