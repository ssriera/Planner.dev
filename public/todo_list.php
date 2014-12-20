<?php


$stufftodo = openfile('data/list.txt');

function openfile($filename) {
	$contentsarray = [];
		if(filesize($filename) > 0) {
			$handle = fopen($filename, 'r');
			$contents = trim(fread($handle, filesize($filename)));
			$contentsarray = explode("\n", $contents);
			fclose($handle);
		}
		// $contentsarray = array_values($contentsarray);
	// return $contentsarray;
}


 function savefile($filename, $array) {
    $handle = fopen($filename, 'w');
        foreach ($array as $item) {
            fwrite($handle, $item . PHP_EOL);
        }
    fclose($handle);
 }

//need to check if it exists
if(isset($_POST['todo'])) {
	$stufftodo[] = $_POST['todo'];
	echo savefile('data/list.txt', $stufftodo);
}

//must undo with unset
if(isset($_GET['remove'])) {
	$id = $_GET['remove'];
	unset($stufftodo[$id]);
	echo savefile('data/list.txt', $stufftodo);
}


?>


<!DOCTYPE HTML>
<head>
	<title>TO DO LIST</title>
	<center><h1>To Do List</h1></center>
<link rel="stylesheet" type="text/css" href="/css/todocss.css">
<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
</head>

<body>
	<h2>Current To Do List:</h2>
		<ul>
			<?php
				foreach($stufftodo as $key => $value) {
					echo "<li>{$value} | <a href=\"/todo_list.php?remove={$key}\">X</a></li>";
					// echo'<li>' . $value . ;
				}
			?>
		</ul>

<br>

<hr>

	<form method="POST"  action="/todo_list.php">
		<h3>Add a task to the To Do List:</h3>
	    <p>
	        <label for="todo" class="right">New Task</label>
	    <br>
	        <input id="todo" name="todo" type="text" placeholder="Add your task">
	    </p>
	 	
	 	<br>

		<button type="submit" class="btn btn-default">Add Task</button>
	</form>
</body>
</html>