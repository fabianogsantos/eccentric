<?php
    function mandaEmail($to, $subject, $body){
        $from = "presidente@eccentrictravels.org";
        
        $headers  = "From: $from\r\n"; 
        $headers .= "Content-type: text/html\r\n";

        //options to send to cc+bcc 
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 

        // now lets send the email. 
        if (mail($to, $subject, $body, $headers))
            return true;    
        else
            return false;
    }
?>