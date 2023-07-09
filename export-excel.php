<?php
// Load the Oracle database connection file
include_once 'includes/db_connection.php';

$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM customer";
 $result = oci_parse($connection, $query);
 oci_execute($result);

  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>ID</th>  
                         <th>NAME</th>  
                         <th>EMAIL</th>
                         <th>PASSWORD</th>  
                         <th>PHONE</th>  
                    </tr>
  ';
  while($row = oci_fetch_assoc($result))
  {
   $output .= '
    <tr>  
       <td>'.$row["CUSTOMER_ID"].'</td>  
       <td>'.$row["CUSTOMER_NAME"].'</td>  
       <td>'.$row["EMAIL"].'</td>  
       <td>'.$row["PASSWORD"].'</td>  
       <td>'.$row["PHONE"].'</td>
     </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=carwashdata.xls');
  echo $output;
 }

?>
