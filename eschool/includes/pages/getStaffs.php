<?php
include ('include/connections.php');

$term = mysql_real_escape_string( $_GET['staffname'] );

$results = mysql_query( "SELECT staff_id, concat(Surname,' ', firstname,' ', othername) as staffname FROM staff WHERE concat(Surname,' ', firstname,' ', othername) LIKE '%$term%' "); // Grab your data

$output_array = new array();

while ( $row = mysql_fetch_assoc( $results ) ) {
    $output_array[] = array( 
        'id' => $row['staff_id']
        , 'label' => $row['staffname']
        , 'value' => $row['staffname']
    );
}

// Print out JSON response
echo json_encode( $output_array );
?>