<?php
        include './includes/dbconfig.php';
        $upload_path = './uploads/';
        $newname = rand(0000, 9999) . basename($_FILES["importInputFile"]["name"]);
        $target_file = $upload_path . $newname;

        $filename = $newname;
        $filenameArray = explode(".", $filename);
        $extension = end($filenameArray);
        if ($extension == 'csv') {
            if (move_uploaded_file($_FILES["importInputFile"]["tmp_name"], $target_file)) {               
                $csvfile = fopen($target_file , 'r');
                $i = 0;
                while (($data = fgetcsv($csvfile,",")) !== FALSE) {
                    if ($i > 0) {                        
                        $getDataQuery="select * from users where member_id='$data[0]' OR fname='$data[2]' AND lname='$data[1]'";    
                        $result=mysqli_query($con,$getDataQuery);                        
                        $rowcount=mysqli_num_rows($result);                       
                        $records=  mysqli_fetch_row($result);
                        if($rowcount > 0){
                            $updateDataQuery = "UPDATE `users` SET member_id='$data[0]', fname='$data[2]',lname='$data[1]',mname='$data[3]',sex='$data[4]',rating='$data[5]',expiration='$data[6]',last_played='$data[7]',email='$data[8]' WHERE `users`.`user_id` = '$records[0]'";
                            mysqli_query($con,$updateDataQuery);                        
                        }
                        else{
                            $sql[] = '("'.($data[0]).'","'.$data[2].'","'.$data[1].'","'.$data[3].'","'.$data[4].'","'.$data[5].'","'.$data[6].'","'.$data[7].'","'.$data[8].'")';                       
                        }
                    }
                    $i++;
                }                   
                if(!empty($sql)){
                    $query=mysqli_query($con,'INSERT INTO users (member_id, fname,lname,mname,sex,rating,expiration,last_played,email) VALUES '.implode(',', $sql));
                    if($query){
                        fclose($csvfile);
                        echo json_encode(array('error' => 'false', 'msg' => 'The file '.$newname . ' has been uploaded.'));
                        die();
                    }
                    else{
                        fclose($csvfile);
                        echo json_encode(array('error' => 'true', 'msg' => mysqli_error($con)));
                        die();
                    }
                }
                else{
                        fclose($csvfile);
                        echo json_encode(array('error' => 'false', 'msg' => 'The file '.$newname . ' has been uploaded.'));
                        die();
                }
            } else {
                echo json_encode(array('error' => 'true', 'msg' => 'Sorry, there was an error uploading your file.'));
                die();
            }
        } else {
            echo json_encode(array('error' => 'true', 'msg' => 'Only CSV files are allowed.'));
            die();
        }
        
?>

