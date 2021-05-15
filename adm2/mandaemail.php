 <?php
        $mailto="fabianogs@gmail.com"; 
        $subject = "Mail from Enquiry Form";

        $from="presidente@eccentrictravels.org";
        $message_body="Testando";
        
        $success = mail($mailto,$subject,$message_body,"From:".$from);
        if (!$success){
            print_r(error_get_last());
        }
        else
            echo "Mail has been sent";
?>