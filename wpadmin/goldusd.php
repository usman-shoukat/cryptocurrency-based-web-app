<?php 
 $db = mysqli_connect("localhost", "bitscoin_investor", "j2Pk91L6!jL-tD@", "bitscoin_investor"); 
 if(!$db){
 echo "error";
 }else{
      echo "";
 }

$id = $_GET['id'];


      
    

   
     	$edit = "UPDATE `gold` SET `confirm2`= 1 WHERE `user_id` = ".$id."";
     	
     	 $res = mysqli_query($db , $edit);
     	 if(!$res){
     	     echo "error";
     	 }
     	 else{
     	 header("location:profile.php");
     	 }

       
         
      




 ?>