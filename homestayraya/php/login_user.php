<?php
if (!isset($_POST)){
	$response = array('status' => 'failed', 'data' => null);
	sendJsonResponse($response);
	die();
}

include_once('dbconnect.php');

$email = $_POST['email'];
$password = sha1($_POST['password']);

$sqllogin = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_password = '$password'";
$result = $conn->query($sqllogin);

try{
if($result->num_rows >0){
	while($row = $result->fetch_assoc()){
		$userlist = array();
		$userlist['id'] = $row['user_id'];
		$userlist['name'] = $row['user_name'];
		$userlist['email'] = $row['user_email'];
		$userlist['password'] = $row['user_password'];
		$userlist['address'] = $row['user_address'];
		$userlist['phone'] = $row['user_phone'];
		$userlist['regdate'] = $row['user_datereg'];
		$userlist['otp'] = $row['otp'];
	$response = array('status' => 'success', 'data' => $userlist);
	sendJsonResponse($response);
	}
}else{
	$response = array('status' => 'failed', 'data' => null);
	sendJsonResponse($response);
}
}
catch(Exception $e){
	$response = array('status' => 'failed', 'data' => null);
	sendJsonResponse ($response);
}
$conn->close();
function sendJsonResponse($sentArray)
{
	header ('Content-Type: application/json');
	echo json_encode($sentArray);
}
?>
