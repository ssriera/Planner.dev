<?php

require_once('../inc/filestore.php');

//This is where I instantiate
class todoStore extends Filestore{

	public $filename = '';
	// public $stufftodo = [];

	function __construct($filename) {
		parent::__construct(strtolower($filename));
	}
}


//Need to instantiate the Filestore here
$upload = new Filestore('uploads/list.txt');
$stufftodo = $upload->read();



// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
    // Set the destination directory for uploads
    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDir . $filename;

    $uploadFile = 'uploads/' . $filename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
    
    $upload2 = new Filestore($uploadFile);

    $newListItems = $upload2->read();

    $stufftodo = array_merge($stufftodo, $newListItems);

    $upload->write($stufftodo);
}

if (isset($savedFilename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}


//need to check if it exists
if(isset($_POST['todo'])) {
	$stufftodo[] = $_POST['todo'];
	$upload->write($stufftodo);
}

//must undo with unset
if(isset($_GET['remove'])) {
	$id = $_GET['remove'];
	unset($stufftodo[$id]);
	// $stufftodo = array_values($stufftodo);
	$upload->write($stufftodo);
}


//THIS IS EXCERCISE 9.2.1

// if(empty($stufftodo)) {
// 	throw new Exception('Your file is empty, upload something else.');
// } elseif (strlen($stufftodo) > 240) {
// 	throw new Exception('Your file is too large, upload something else.');
// }

//THIS IS EXCERCISE 9.2.2
// try {
// 	if(empty($filename)) {
// 	echo "Your file is empty, upload something else.";
// 	} elseif (strlen($filename) > 240) {
// 		throw new Exception('Your file is too large, upload something else.');
// 	}
// } catch (Exception $e) {
// 	echo $e->getMessage();
// }


?>
<!DOCTYPE HTML>
<head>
	<title>TO DO LIST</title>
	<center><h1>To Do List</h1></center>
<link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
    <!-- For jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>