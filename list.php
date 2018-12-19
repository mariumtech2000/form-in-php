<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Employees List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" media="screen" href="style.css" />

</head>
<body>

<h1>EMPLOYEE  INFORMATION</h1>


<?php

include 'db_connection.php';
$conn = OpenCon();

if(isset($_GET["action"]) === true && $_GET["action"] === "delete" && !empty($_GET["id"]) ){
	$sql = "DELETE FROM employeeinfo where id =".$_GET["id"];
	if ($conn->query($sql) === TRUE) {
		echo "Employee deleted successfully";
	} else {
		echo "Error deleting record: " . $conn->error;
	}
}
?>

<?php
$id = $_GET['id'];
// echo "Connected Successfully";
echo "<br>";

echo "<br>";
$sql = "SELECT id, firstname, lastname , email  FROM employeeinfo WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border=\"1\" align=\"center\">";
	echo "<tr><th>Id</th>";
	echo "<th>First Name</th>";
	echo "<th>Last Name</th>";
	echo "<th>Email</th>";
	echo "<th>Setting</th></tr>";
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>";
		echo  $row["id"];
		echo "</td><td>";
		echo  $row["firstname"];
		echo "</td><td>";
		echo  $row["lastname"];
		echo "</td><td>";
		echo  $row["email"];
		echo "<td>
		<a href='index.php?action=delete&id=".$row["id"]."'><input type='submit' value='delete' class='delete'></a>
		</td>";
		echo "</td></tr>";
	}
	echo "</table>";
} else {
	echo "0 results";
}

?>

<a href="index.php" class="go-back">GO BACK</a>

</body>
</html>