<?php
        include './dbconfig.php';
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
                        $sql[] = '("'.($data[0]).'","'.$data[2].'","'.$data[1].'","'.$data[3].'","'.$data[4].'","'.$data[5].'","'.$data[6].'","'.$data[7].'","'.$data[8].'")';                       
                    }
                    $i++;
                }                
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
            } else {
                echo json_encode(array('error' => 'true', 'msg' => 'Sorry, there was an error uploading your file.'));
                die();
            }
        } else {
            echo json_encode(array('error' => 'true', 'msg' => 'only CSV is allowed extension'));             
            die();
        }
        
?>

