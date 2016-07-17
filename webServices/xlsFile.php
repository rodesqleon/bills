<?php
include_once('connection_bills.php');
    //Call object of class connection and create a new connection to my localhost database
    $connection = new createConnection(); 
    $connection->connectToDatabase();
    $connection->selectDatabase();

$select = "SELECT day as DIA, initial_bill as BOLETA_INICIO, end_bill as BOLETA_TERMINO, bill_value as SUBTOTAL FROM bills";

$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );

$fields = mysql_num_fields ( $export );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysql_field_name( $export , $i ) . "\t";
}

while( $row = mysql_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Bills.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";

?>