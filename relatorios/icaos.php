 <?php  
 	include('../conecta.php');
   
     $param = $_GET["term"];  
     
     //query the database  
     $query = mysql_query("SELECT * FROM icao WHERE icao REGEXP '^$param'");  
   
     //build array of results  
     for ($x = 0, $numrows = mysql_num_rows($query); $x < $numrows; $x++) {  
         $row = mysql_fetch_assoc($query);  
   
         $icaos[$x] = array("icao" => $row["icao"]);  
     }  
   
     //echo JSON to page  
     $response = $_GET["callback"] . "(" . json_encode($icaos) . ")";  
     echo $response;  
 ?>  