<?php
//get a list of all the fields
require_once'list.php';
$col_list = get_col_list(); //maybe this should be in the DB but its not really that big so...
//connect to the db
require_once'mysql.php';
$conn = new mysqli($hn,$un,$pw,$db);
if($conn->connect_error) die($conn->connect_error);

//TODO insert styles and such
echo "<style>
table, th, td {
   border: 1px solid black;
}</style> ";

//escapes the input for sql injections.
function clean_input($conn, $var){
    //echo $var;
    return $conn->real_escape_string($var);
}

//Builds the SQL select part of the SQL statement
function get_search_string($conn, $arr)
{
    $searchString ='';
    for ($i=1; $i <= sizeOf($arr); $i++) { 
     
     $searchString .= $conn->real_escape_string($arr[$i]);   
     if($i !== (sizeOf($arr)) ){
         $searchString .= ',';
     }   
    }
    return $searchString;
}

//Builds the SQL where STRING
function get_where_string($conn, $arr)
{
    $returnString = $whereString;
    for ($i=1; $i <= sizeOf($arr); $i++) { 
    $whereString = '';
    if($i > 1){
        $whereString = " OR ";
    }

     $whereString .= "region_id = '";
     $whereString .= $conn->real_escape_string($arr[$i]); 
     $whereString .= '\'';
     $returnString .= $whereString;
       
    }
    return $returnString;
}

if(isset($_POST['fieldsArr']) && isset($_POST['colname'])){

    $fields = explode(',', $_POST['fieldsArr']); 

    $cols = [];
    foreach ($_POST['colname'] as $key => $value) {
        array_push($cols, $value);
    };

    $resolution = $fields[0];
    //echo $fields[0] . "this is the resolution of the map ie SA1 or SSC or STE or AUST etc

    //These are the regions of the user selection.
    for ($i = 1; $i < sizeOf($fields); $i++){
        $regions[$i] = $fields[$i];
    }
    //echo "<br><hr><br>";
    $table = $cols[0];

    
    //echo "these are the fields to be looked up in each of the tables.<br>";
    for ($i = 1 ; $i < sizeOf($cols); $i++){
        $columns[$i] = $cols[$i];

    }

    build_query($resolution, $table, $columns, $regions);

}


function build_query($resolution, $table, $columns, $regions)
{
    //build querey/
    global $conn;
    $table = strtolower($table);
    $colString = get_search_string($conn, $columns);
    $regionString = get_where_string($conn, $regions);
    $query = "SELECT name," . $colString  . " FROM " . $table ." NATURAL JOIN b00 WHERE " . $regionString . ";";
    $queryRegions = "SELECT * FROM b00 WHERE " . $regionString . ";" ;
    

    buildTable($query, $columns);

}



function buildTable($q, $columns)
{
    global $conn;
    global $col_list;
    $result = $conn->query($q);
    //echo $q;
    if(!$result) echo "Lookup Failed! Did you select an area?: $query<br>" . $conn->error . "<br><br>";   
    
    // column names
    echo 'Just a note: Theres a 1000 row limit on the application. If your need more just grab the raw files for yourself.';
    echo '<br><hr><br>';
    echo '<table style="text-align: center; border: 1px"';
    
    
    echo '<tr>';
    echo '<th>Area names</th>';
    for ($i=1; $i <= sizeOf($columns); $i++) { 
        echo '<th>';
        echo $col_list[$columns[$i]];
        echo '</th>';      
    }
    echo '</tr>'; 
    
    
    echo '<tr>';
    echo '<td>name</td>';
    for ($i=1; $i <= sizeOf($columns); $i++) { 
        echo '<td>';
        echo $columns[$i];
        echo '</td>';      
    }
    echo '</tr>';
    
    // data from here down   
    
    $rows = $result->num_rows;
    for ($i=0; $i < $rows; $i++) { 
        
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_NUM);      
        $columns = sizeOf($row);
        echo '<tr>';
        for ($j=0; $j < $columns; $j++) { 
            echo '<td>';            
            echo $row[$j];
            if($j != ($columns - 1)){
                echo "";
            }  
            echo '</td>';     
        }
        echo '</tr>';
    }   
}
?>