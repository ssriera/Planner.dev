<?php

// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
    
}

if (isset($savedFilename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
	$stufftodo = openfile($savedFilename);
	savefile($savedFilename, $stufftodo);
} else {
	$stufftodo = openfile('uploads/list.txt');
}

function openfile($filename) {
	$contentsarray = [];
		if(filesize($filename) > 0) {
			$handle = fopen($filename, 'r');
			$contents = trim(fread($handle, filesize($filename)));
			$contentsarray = explode("\n", $contents);
			fclose($handle);
		}
	return $contentsarray;
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
	savefile('data/list.txt', $stufftodo);
}

//must undo with unset
if(isset($_GET['remove'])) {
	$id = $_GET['remove'];
	unset($stufftodo[$id]);
	// $stufftodo = array_values($stufftodo);
	savefile('data/list.txt', $stufftodo);
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
				if(!empty($stufftodo)) {
					foreach($stufftodo as $key => $value) {
						echo "<li>{$value} | <a href=\"/todo_list.php?remove={$key}\">X</a></li>";
					}
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
		<button type="submit" class="btn btn-default">Add Task</button>
	</form>

	<br>

	 <form method="POST" enctype="multipart/form-data" action="/todo_list.php">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>
</body>
</html>