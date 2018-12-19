<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>practice</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" media="screen" href="style.css" />

<script>
function showErrorMessage() {
	alert("All fields are mandatory");
}
</script>

</head>

<body>
<h1>REGISTRATION FORM</h1>
<div id="bg">
<div class="module">
<ul>
<li class="tab"><img src="https://i.imgur.com/Fk1Urva.png" alt="" class="icon"/></li>
</ul>

<?php

include 'db_connection.php';
$conn = OpenCon();

$firstname = "";
$lastname = "";
$email = "";


if(isset($_GET["action"]) === true && $_GET["action"] === "edit" && !empty($_GET["id"]) ){
	$sql = "SELECT id, firstname, lastname , email  FROM employeeinfo where id =".$_GET["id"];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$firstname = $row["firstname"];
			$lastname= $row["lastname"];
			$email = $row["email"];
		}
	}
}


if(isset($_GET["action"]) === true && $_GET["action"] === "delete" && !empty($_GET["id"]) ){
	$sql = "DELETE FROM employeeinfo where id =".$_GET["id"];
	if ($conn->query($sql) === TRUE) {
		// echo "<h3>Employee deleted successfully</h3>";
	} else {
		echo "Error deleting record: " . $conn->error;
	}
}


if(isset($_GET["id"]) === true &&  $_GET["action"] === "view" && !empty($_GET["id"]) ){
	$sql = "SELECT * from employeeinfo where id =".$_GET["id"];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$firstname = $row["firstname"];
			$lastname= $row["lastname"];
			$email = $row["email"];
		}
	}
}

?>

<form  method="post">
<input type="text" placeholder="First Name" class="textbox" name="name" value="<?php echo $firstname ?>"/>
<input type="text" placeholder="Last Name" class="textbox" name="lastname" value="<?php echo $lastname ?>"/>
<input type="text" placeholder="Email Address" class="textbox" name="email" value="<?php echo $email ?>" />
<input class="button" type="submit" name="submit" value="Submit">  
</form>
</div>
</div>



<?php

// echo "Connected Successfully";
echo "<br>";



if(isset($_POST["submit"]) === true){
	$firstname = $_POST["name"];
	$lastname= $_POST["lastname"];
	$email = $_POST["email"];
	
	if (empty($firstname) || empty($lastname) || empty($email)) {
		// echo "<h3> All Fields are Mandatory</h3>";
		echo "<script>showErrorMessage();</script>";
	} else {
		
		if(isset($_GET["action"]) === true && $_GET["action"] === "edit" && !empty($_GET["id"]) ){
			
			$sql = "UPDATE employeeinfo SET firstname = '".$firstname."', lastname='".$lastname."', email = '".$email."' WHERE id = ".$_GET["id"];
			
			if ($conn->query($sql) === TRUE) {
				echo "New records UPDATED successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			
			$sql = "INSERT INTO employeeinfo (firstname, lastname, email)
			VALUES ('$firstname', '  $lastname', '$email')";
			
			if ($conn->query($sql) === TRUE) {
				// echo "New records created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
	// header('Location:'.htmlspecialchars($_SERVER["PHP_SELF"]));
}
echo "<br>";
$sql = "SELECT id, firstname, lastname , email  FROM employeeinfo ";
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
		<a href='index.php?action=edit&id=".$row["id"]."'> <input type='submit' value='update' class='update'></a>
		<a href='index.php?action=delete&id=".$row["id"]."'><input type='submit' value='delete' class='delete'></a>
		<a href='list.php?action=view&id=".$row["id"]."'><input type='submit' value='view' class='view'></a>
		</td>";
		echo "</td></tr>";
	}
	echo "</table>";
} else {
	echo "<br>";
}
?>
</body>	
</html>