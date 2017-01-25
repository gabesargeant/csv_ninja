<?php
require_once'list.php';
require_once'mysql.php';

$conn = new mysqli($hn,$un,$pw,$db);
if($conn->connect_error) die($conn->connect_error);

//"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'my_database' AND TABLE_NAME = 'my_table';
function get_table($conn, $var){
    //echo $var;
    return $conn->real_escape_string($_GET[$var]);
}
$table;
$result;
if(isset($_GET['table'])){
    $table = get_table($conn, 'table');  
    $table = strtolower($table);
    $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'Census11AA' AND TABLE_NAME = '$table'";
    $result = $conn->query($query);
    if(!$result) echo "Lookup Failed : $query<br>" . $conn->error . "<br><br>";   
}

$rows = $result->num_rows;
//returns the defined list in list.php. assoc array db col names to descriptive names.
$col_list = get_col_list();
//echo '<form id="fieldForm">';
echo '<input type="hidden" name="colname[]" value="'.$table.'">';
echo '<input type="hidden" name="colname[]" value="region_id">';

echo '<select id="fieldList" name="colname[]" size="20" multiple="multiple">';

for ($i=1; $i < $rows; $i++) { 
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_NUM);
    $colname = $row[0];
    if($i === 1)
    {
         echo '<option value="'.$colname.'"  selected="selected">'. $col_list[$colname].'</option>';
    }else{
         echo '<option value="'.$colname.'">'. $col_list[$colname].'</option>';
    }
   

}

if($result ==! null) $result->close();
if($conn ==! null) $conn->close();
?>
