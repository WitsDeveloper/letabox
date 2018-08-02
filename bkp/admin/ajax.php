<?php
//fetch.php
$connect = mysqli_connect("localhost", "letabox_letabox_sys", "letabox_letabox_sys", "letabox_letabox_sys");
$columns = array('OrderId', 'lbs_bill_shipping_id', 'shipping_cost', 'Status', 'OrderTotal','sellCostTotal','orderRemarks','OrderDate');

$query = "SELECT * FROM lbs_order WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'OrderDate BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (OrderId LIKE "%'.$_POST["search"]["value"].'%" 
  OR lbs_bill_shipping_id LIKE "%'.$_POST["search"]["value"].'%" 
  OR shipping_cost LIKE "%'.$_POST["search"]["value"].'%" 
  OR Status LIKE "%'.$_POST["search"]["value"].'%")
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY OrderId DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["OrderId"];
 $sub_array[] = $row["lbs_bill_shipping_id"];
 $sub_array[] = $row["shipping_cost"];
 $sub_array[] = $row["OrderDate"];
 $sub_array[] = $row["OrderTotal"];
  $sub_array[] = $row["OrderDate"];
 $sub_array[] = $row["OrderTotal"];
  $sub_array[] = $row["OrderTotal"];
  $sub_array[] = $row["OrderDate"];
 $sub_array[] = $row["OrderTotal"];
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM lbs_order";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>

