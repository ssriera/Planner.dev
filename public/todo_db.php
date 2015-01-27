<?php
//make a migration + seeder

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'todo_db');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require'../db_connect.php';

if (!isset($_GET['page'])) {
		$page = 1;
		$previous = 1;
		$offset = 0;
	} else {
		$page = $_GET['page'] + 1;
		$previous = $_GET['page'] - 1;
		$offset = ($page-1) * 4;
};

$offset = 0;

//To delete item
if(isset($_GET['remove'])) {
		$id = $_GET['remove'];
	$delete = "DELETE FROM to_do WHERE id = :id";
	$stmt = $dbc->prepare($delete);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}

if(isset($_POST)) {
	if (!empty($_POST)) {

		$post = 'INSERT INTO to_do (things_todo) VALUES (:things_todo)';
		$stmt = $dbc->prepare($post);
		$stmt->bindValue(':things_todo', $_POST['things_todo'], PDO::PARAM_STR);
		$stmt->execute();
	}
}


$todos = $dbc->prepare('SELECT * FROM to_do LIMIT 10 OFFSET :offset');
$todos->bindValue(':offset', $offset, PDO::PARAM_INT);
$todos->execute();
$stufftodo = $todos->fetchAll(PDO::FETCH_ASSOC);

// Get out data from database

//pagination for the pages


// //This is where I instantiate
// class todoStore extends Filestore{

// 	public $filename = '';
// 	// public $stufftodo = [];

// 	function __construct($filename) {
// 		parent::__construct(strtolower($filename));
// 	}
// }



//Need to instantiate the Filestore here
// $upload = new Filestore('uploads/list.txt');
// $stufftodo = $upload->read();


require_once('../inc/filestore.php');

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

// if (isset($savedFilename)) {
//     // If we did, show a link to the uploaded file
//     echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
// }


// Need to check if it exists

?>

<!DOCTYPE HTML>
<head>
	<title>TO DO LIST</title>
	<center><h1>To Do List</h1></center>
    <!-- For jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
						echo "<li>{$value['things_todo']} | <a href=\"?remove={$value['id']}\">X</a></li>";
					}
				}
			?>
		</ul>
<br>
	<p>
	  <a href="?page=<?=$page?>" role="button" class="btn btn-default btn-sm pull-right glyphicon glyphicon-chevron-right">Next</a>
  	  <a href="?page=<?=$previous?>" role="button" class="btn btn-default btn-sm glyphicon glyphicon-chevron-left">Previous</a>
	</p>
<hr>

	<form method="POST" action="/todo_db.php">
		<h3>Add a task to the To Do List:</h3>
	    <p>
	        <label for="todo" class="right">New Task</label>
	    <br>
	        <input id="todo" name="things_todo" type="text" placeholder="Add your task">
	    </p>
		<button type="submit" class="btn btn-default">Add Task</button>
	</form>

	<br>

	 <form method="POST" enctype="multipart/form-data" action="/todo_db.php">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>