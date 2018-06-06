<?php 
session_start();

if(!isset($_SESSION['sessionid']))
{
header("location: login.php");
}
else {
     require_once("inc/config.inc.php");
     require_once("inc/database.inc.php");

     $db=new Database();
     $db->open();

if( isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE from model where id = '$id' ";
    $query= $db->query($sql);

}

if( isset($_POST['model_id'])) {
    $model_id = $_POST['model_id'];
    $sql = "SELECT color, manufacturing_year,registration_number,note from model where id = '$model_id' ";
    $query= $db->query($sql);
    $rows = $db->fetchArray();
    $array1 = array($rows['color'],$rows['manufacturing_year'],$rows['registration_number'] ,$rows['note']);
    echo json_encode($array1);
    exit;
}
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    0 =>'modelID', 
    1 =>'ManufacturerName', 
    2 => 'modelName',
    3=> 'TotalC',
    4=> 'Update'
);

$sql = "SELECT manufacturer.manufacturer_name AS ManufacturerName, model.name AS modelName, count(*) as TotalC, model.id as modelID from model INNER JOIN manufacturer on model.manufacturer_id=manufacturer.id GROUP BY model.name";

$query = $db->query($sql);
$totalData = $db->numRows();
$totalFiltered = $totalData;  

$sql = "SELECT manufacturer.manufacturer_name AS ManufacturerName, model.name AS modelName, count(*) as TotalC, model.id as modelID from model INNER JOIN manufacturer on model.manufacturer_id=manufacturer.id GROUP BY model.name";

$query = $db->query($sql);
$totalFiltered = $db->numRows();
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$data = array();
$query = $db->query($sql);

while( $row= $db->fetchArray() ) {  // preparing an array
    $nestedData=array(); 
    $nestedData[] = $row["modelID"];
    $nestedData[] = $row["ManufacturerName"];
    $nestedData[] = $row["modelName"];
    $nestedData[] = $row["TotalC"];
    $nestedData[] = "<button>Update</button>"; 
    $data[] = $nestedData;
}

$json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format
}
?>
