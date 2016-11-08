<?php
    session_start();
    
     function checkEmailSetting(){
        include './includes/dbconfig.php';     
        $query="SELECT `emails` FROM `directoremails`";
        $result= mysqli_query($con,$query);
        $count=  mysqli_num_rows($result);
         if($count > 0){
             return 'true';
         }
         else{
             return 'false';
         }
     }

    
?>