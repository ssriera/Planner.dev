<?php


$stufftodo = openfile('data/list.txt');

function openfile($filename) {
	$handle = fopen($filename, 'r');
	$contents = fread($handle, filesize($filename));
	$stufftodo = explode("\n", $contents);
	fclose($handle);
	return $stufftodo;
}


 function savefile($filename, $array) {
    $handle = fopen($filename, 'w');
        foreach ($array as $item) {
            fwrite($handle, $item . PHP_EOL);
        }
    fclose($handle);
 }


if(isset($_POST['todo'])) {
	//grab post add to array above
	$stufftodo[] = $_POST['todo'];
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
				echo "<li>{$value}</li>";
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
 <button type="submit" class="right">Add Task</button>
</body>
</html>