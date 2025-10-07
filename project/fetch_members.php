<?php

include "./../include/config.php";


if (isset($_GET['leaderId'])) {
  
   

    $query = "SELECT * FROM employee WHERE Company_id = $companyId AND Active = 'active'";

    
    $result = mysqli_query($conn, $query);

 
    if ($result && mysqli_num_rows($result) > 0) {
        
        $members = array();

        
        while ($row = mysqli_fetch_assoc($result)) {
            $members[] = $row;
        }

       
        echo json_encode($members);
    } else {
       
        echo json_encode(array());
    }
} else {
    
    echo json_encode(array());
}
?>
