<html>
<body>


<form action="toDo2.php" method="post">
Task: <input type="text" name="name"><br>
<input type="submit">
</form>

<form action="toDo2.php" method="post">
Remove Task by number: <input type="number" min="1" name="remove" value="Remove"><br>
<input type="submit">
</form>

<?php

//connecting to database
$con = mysqli_connect("localhost", "share", "Password1", "toDo") or die('Not connected : ' . mysqli_connect_error());


//getting data from database
$sql = "SELECT * FROM list;";
$result = mysqli_query($con, $sql);

//inserting data
$task = $_POST["name"];
if($task != "" && $task != null){
	$exists = false;
	while($row = mysqli_fetch_array($result)) {
		if($row['tList'] == $task){
		 	$exists = true;
		}
	}
	if($exists==false){
		$sql2 = "INSERT INTO list (tList) 
			VALUES ('$task');";
		$result2 = mysqli_query($con, $sql2);
		echo "<meta http-equiv='refresh' content='0'>";
	}
	
}

$del = $_POST["remove"];
if($del > 0 && $del != null){
	//if(isset($_POST['remove'])){
	$sqlD = "DELETE FROM list WHERE id = ('$del');";
	$delete = mysqli_query($con, $sqlD);
	//reset the indexes of the remaining rows
	$reset = mysqli_query($con, "ALTER TABLE list AUTO_INCREMENT = 1;");
	$reset = mysqli_query($con, "ALTER TABLE list DROP id;");
	$reset = mysqli_query($con, "ALTER TABLE list ADD id MEDIUMINT NOT NULL AUTO_INCREMENT KEY;");
	echo "<meta http-equiv='refresh' content='0'>";
	//}
}

//use to reset the mysqli_fetch_array
mysqli_data_seek($result, 0);

//display list
echo "<h1>To Do List</h1>";
echo "<ul>";
while($row2 = mysqli_fetch_array($result)) {
	if($row2['tList'] != NULL){
	 	echo "<li>" . $row2['tList'] . "</li>";
	}
}
echo "</ul>";

?>


</body>
</html> 
