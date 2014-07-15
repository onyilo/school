<?php
include ('includes/connections.php');

$term = mysql_real_escape_string( $_GET['term'] );

$results = mysql_query( "SELECT staff_id, concat(Surname,' ', firstname,' ', othername) as staffname FROM staff WHERE concat(Surname,' ', firstname,' ', othername) LIKE '%$term%' "); // Grab your data

$output_array =array();

while ( $row = mysql_fetch_assoc( $results ) ) {
    $output_array[] = array( 
        'id' => $row['staff_id']
        , 'value' => $row['staffname']
    );
}

// Print out JSON response
echo json_encode( $output_array );
?>