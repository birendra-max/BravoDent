
<?php
	//include connection file 
	include_once("connect.php");
	 
	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	//define index of column
	$columns = array( 
		0 =>'orderid',
		1 =>'fname', 
		2 => 'tduration',
		3 => 'status',
		4 => 'unit',
		5 => 'tooth',
		6 => 'labname',
		7 => 'created_at',
		8 => 'orderid'
	);

	$where = $sqlTot = $sqlRec = "";

	// check search value exist
	if( !empty($params['search']['value']) ) {   
		$where .=" WHERE ";
		$where .=" ( orderid LIKE '".$params['search']['value']."%' ";    
		$where .=" OR fname LIKE '".$params['search']['value']."%' ";
        $where .=" OR created_at LIKE '".$params['search']['value']."%' ";
		$where .=" OR labname LIKE '".$params['search']['value']."%' )";
	}

	// getting total number records without any search
	$sql = "SELECT * FROM `orders` ";
	$sqlTot .= $sql;
	$sqlRec .= $sql;
	//concatenate search sql if value exist
	if(isset($where) && $where != '') {

		$sqlTot .= $where;
		$sqlRec .= $where;
	}


 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

	$queryTot = mysqli_query($bd, $sqlTot) or die("database error:". mysqli_error($bd));


	$totalRecords = mysqli_num_rows($queryTot);

	$queryRecords = mysqli_query($bd, $sqlRec) or die("error to fetch employees data");

	//iterate on results row and create new index array of data
	while( $row = mysqli_fetch_row($queryRecords) ) { 
		$data[] = $row;
	}	

	$json_data = array(
			"draw"            => intval( $params['draw'] ),   
			"recordsTotal"    => intval( $totalRecords ),  
			"recordsFiltered" => intval($totalRecords),
			"data"            => $data   // total data array
			);

	echo json_encode($json_data);  // send data as json format
?>
	