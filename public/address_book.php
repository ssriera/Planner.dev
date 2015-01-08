<?php

class AddressInfo {

	public $filename = '';

	function __construct($filename = 'address_book.csv') {
		$this->filename = $filename;
	}

	public function read_file() {
		 $handle = fopen($this->filename, 'r');

		 $addressBook = [];

		while(!feof($handle)) {
		     $row = fgetcsv($handle);

		    if (!empty($row)) {
		        $addressBook[] = $row;
		    }
		}

		fclose($handle);
		return $addressBook;
	}

	public function save_file($array) {
		 $handle = fopen($this->filename, 'w');

		foreach ($array as $row) {
	    	fputcsv($handle, $row);
		}

		fclose($handle);
	}
}

$AddressInst = new AddressInfo();
// $AddressInst->filename = 'address_book.csv';
$addressBook = $AddressInst->read_file();

if($_POST) {
	$addressBook[] = $_POST;
	$AddressInst->save_file($addressBook);
}

if(isset($_GET['delete'])) {
	$id = $_GET['delete'];
	unset($addressBook[$id]);
	$addressBook = array_values($addressBook);
	$AddressInst->save_file($addressBook);	
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
 
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-12">
          <h2>Running the List... Checking it twice...</h2>

          <table class="table table-striped">
						<? foreach($addressBook as $key => $row): ?>
							<tr>
								<? foreach($row as $value): ?>
									<td colspan="1"> <?= $value ?></td>
								<? endforeach; ?>
									<td id="delete">
								<a href="?delete=<?= $key; ?>">X</a>
							</td>
							</tr>
						<? endforeach; ?>
					</table>
 
					<form action="/address_book.php" method="POST" enctype="multipart/form-data">
						<input type="text" name="name" placeholder="Name">
						<input type="text" name="address" placeholder="Address">
						<input type="text" name="city" placeholder="City">
						<input type="text" name="state" placeholder="State">
						<input type="text" name="state" placeholder="Zip">
						<input type="submit" value="Save">
					</form>
 
		
        </div>
      </div>
 
      <hr>
 
      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->
 
 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>