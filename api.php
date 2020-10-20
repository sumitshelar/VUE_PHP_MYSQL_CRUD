<?php
include "connect.php";
if(!empty($_POST['action'])){
    /*Retrieve All Data*/
    if($_POST['action'] == 'retrieve_all'){
//        echo json_encode(['msg'=>'data received']);
        $sql = mysqli_query($db,"SELECT * FROM `user_details`");
        $usrarray = array();
        if($sql){
            if(mysqli_num_rows($sql)==0){
               echo json_encode([false, 'no row retrieved']);
            }
            else {
                while($row = mysqli_fetch_assoc($sql)){
                $usrarray[] = $row;
                } 
                echo json_encode([true, $usrarray]);
            }
        
        } else {
            echo json_encode([false, 'Sql issue']);
        }
        /*Delete Data*/
    }    else if($_POST['action'] == 'delete_user'){
        if(!empty($_POST['user_id'])){
            $id = mysqli_real_escape_string($db,$_POST['user_id']);
//            $sql = "DELETE FROM user_details WHERE `user_id` = `$id`";
            $sql = "DELETE FROM user_details WHERE  user_id = '$id'";
            $result= mysqli_query($db,$sql);
            if($result){
                echo json_encode([true, 'Deleted Successfully']);
            } else {
//                echo json_encode([false, 'something went wrong']);
                echo json_encode([false, mysqli_error($db)]);
            }
        }
        /*Insert Data*/
    } else if($_POST['action'] == 'create_item'){
        if(!empty($_POST['new_item'])){
            
            if(!empty($_POST['new_item']['firstName']) && !empty($_POST['new_item']['lastName']) && !empty($_POST['new_item']['profession']) && !empty($_POST['new_item']['email'])) {
                $fname = mysqli_real_escape_string($db,$_POST['new_item']['firstName']);
                $lname =  mysqli_real_escape_string($db,$_POST['new_item']['lastName']);
                $profession =  mysqli_real_escape_string($db,$_POST['new_item']['profession']);
                $email =  mysqli_real_escape_string($db,$_POST['new_item']['email']);
                
                $sql = "INSERT INTO `user_details`(`first_name`, `last_name`, `profession`, `email_id`) VALUES ('$fname', '$lname', '$profession', '$email')";
                $result = mysqli_query($db,$sql);
//                $esql = $sql;
                if($result){
                     echo json_encode([true,'data inserted successfully']);
                } else {
                     echo json_encode([false,'1insufficient data can not create new data']);
                }
                
        } else {
            echo json_encode([false,'2insufficient data can not create new data']);
//            echo json_encode([false,mysqli_error($db)]);
//            echo json_encode([$esql]);
        }
        }else{
            echo json_encode([false,'no data set can not create new data']);
        }
        
    } else if($_POST['action'] == 'update_item'){
        if(!empty($_POST['edited_item']['user_id']) && !empty($_POST['edited_item']['first_name']) && !empty($_POST['edited_item']['last_name']) && !empty($_POST['edited_item']['profession']) && !empty($_POST['edited_item']['email_id'])) {
            $id = mysqli_real_escape_string($db,$_POST['edited_item']['user_id']);
            $fname = mysqli_real_escape_string($db,$_POST['edited_item']['first_name']);
            $lname =  mysqli_real_escape_string($db,$_POST['edited_item']['last_name']);
            $profession =  mysqli_real_escape_string($db,$_POST['edited_item']['profession']);
            $email =  mysqli_real_escape_string($db,$_POST['edited_item']['email_id']);
            
            $sql = "UPDATE `user_details` SET `first_name`='$fname',`last_name`='$lname',`profession`='$profession',`email_id`='$email' WHERE `user_id` = '$id'";
            
            $result = mysqli_query($db,$sql);
                if($result){
                     echo json_encode([true,'data updated successfully']);
                } else {
//                     echo json_encode([false,'1insufficient data can not update the data']);
                     echo json_encode([false,$sql]);
                }
        } else {
            echo json_encode([false,'insufficient data can not update the data']);
        }
    } else{
        echo json_encode([false,'insufficient data can not update the data']);
    }
}
?>