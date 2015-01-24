<?php

require_once('../inc/address_data_store.php');

//These are the two exceptions' classes
class UnexpectedTypeException extends Exception {};
class InvalidInputException extends Exception {};

class AddressInfo extends AddressDataStore{

	public $filename = '';
	public $addressBook = [];
	public $localPath = '';

	function __construct($filename = 'address_book.csv') {
		parent::__construct(strtolower($filename));
		$this->contacts = $this->read();
		$this->localPath = 'uploads/' . $this->filename;
	}


	public function readFile() {
		$this->readCSV();
	}

	public function writeFile() {
			$this->writeCSV();	
	}
}


//Instantiate the Addressbook
$AddressInst = new AddressInfo('address_book.csv');
$addressBook = $AddressInst->read();

//To add new item
//Plus added Exception to check for Invalid Input before adding item
if(!empty($_POST)) {

	try {
		
		foreach ($_POST as $key => $value) {
			if (empty($value) || strlen($value) > 240) {
				throw new InvalidInputException('Invalid Input');
			}
		}
		$addressBook[] = $_POST;
		$AddressInst->write($addressBook);

	} catch (InvalidInputException $e) {
		$e->getMessage();
	}	
}

//To remove Items
if(isset($_GET['remove'])) {
	$id = $_GET['remove'];
	unset($addressBook[$id]);
	$addressBook = array_values($addressBook);
	$AddressInst->write($addressBook);	
}

//Excercise 6.3.2
	function __destructor () {
		echo "Class Dismissed!";
	}

//Fix this file upload- refer to TODO List
if (!empty($_FILES['file_upload']['name'])) {
	$file_upload = $_FILES['file_upload']['name'];

	$uploadedFileToRead = $AddressInst->uploadFile($file_upload);

	$uploadedFiles = new AddresInfo($uploadedFileToRead);
	$uploadedFiles->items = $uploadedFiles->read();

	// foreach ($uploadedFiles->items as $item) {
	// 	$AddressInst->items[] = $item;
	// }

	$AddressInst->write($AddressInst->items);
}


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
    
    $upload2 = new AddressDataStore($uploadFile);
    // var_dump($upload2);

    $newListItems = $upload2->read();

    // var_dump($newListItems);
    $addressBook = array_merge($addressBook, $newListItems);
    // var_dump($stufftodo);

    $AddressInst->write($addressBook);
}


//This exception checks for Unexpected Type 
	try {
		if(empty($filename)) {
		echo "Your file is empty, upload something else.";
		} elseif (strlen($filename) > 240) {
			throw new UnexpectedTypeException('Your file is too large, upload something else.');
		}
	} catch (UnexpectedTypeException $e) {
		echo $e->getMessage();
	}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>Estefi's Address Book</title>
 
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">


  </head>
 
  <body>

 
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1 class="text-center">Estefi's Address Book</h1>
      </div>
    </div>

	<h4><?= "Today is ". '' . date('l \t\h\e jS');?></h4>

  <div class="container bordered img-rounded">
    <h2 class="page-header"><span id="book-icon" class="glyphicon glyphicon-book"></span> Contacts</h2>
    <div class="panel panel-default">
        <table class="table table-striped table-bordered">
		    <tr>
			    <th>Name</th>	    
			    <th>Address</th>
			    <th>City</th>
			    <th>State</th>
			    <th>Zip</th>
			    <th width="70px"></th>
		    </tr>
    <!-- Loop through each of the contacts and output -->
    <?php foreach($addressBook as $key => $row): ?>
        <tr>
            <!-- Loop through each value, in each address -->
            <?php foreach ($row as $value): ?>
                <td>
                    <?= $value ?>
                </td>
            <?php endforeach ?>
            <td>
                <a href="/address_book.php?remove=<?= $key ?>" class="btn btn-default btn-danger btn-center">X</a>
            </td>
        </tr>
    <?php endforeach ?>
  </table>
</div>

<br>
<hr>
<br>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4 no-pad-left">
			<form action="/address_book.php" method="POST" enctype="multipart/form-data">
				<h3>Add a New Contact</h3>
					<input type="text" name="name" placeholder="Name">
					<input type="text" name="address" placeholder="Address">
					<input type="text" name="city" placeholder="City">
					<input type="text" name="state" placeholder="State">
					<input type="text" name="zip" placeholder="Zip">
					<input type="submit" value="Save">
			</form>	
			<br>
			<p>
				<hr>
			</p>
		<h3>Upload a File</h3>
			 <form method="post" enctype="multipart/form-data" action="/address_book.php">
        	<p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        	</p>
        	<p>
            <input type="submit" value="Upload">
        	</p>
    </form>
        </div>
      </div>
 	<br>
<hr>


<!-- /*/*/ -->

<br>
<footer class="text-center">
<p>&copy; S.Riera 2015</p>
</footer>
    </div> 
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