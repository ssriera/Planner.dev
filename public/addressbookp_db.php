<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'address_book');
define('DB_USER', 'codeup');
define('DB_PASS', 'codeup');

require('../db_connect.php');
require_once('abdb_people.php');
require_once('abdb_address.php');





$people = new People($dbc);

if (!empty($_POST['fname']) &&
    !empty($_POST['lname']) &&
    !empty($_POST['phone'])) {

    $people->fnameAdd = htmlspecialchars(strip_tags($_POST['fname']));
    $people->lnameAdd = htmlspecialchars(strip_tags($_POST['lname']));
    $people->phoneAdd = htmlspecialchars(strip_tags($_POST['phone']));


    $people->insert();
}


//Remove logic
  if (!empty($_GET['remove'])) {
    // $people
    $people->contactRemove = $_GET['remove'];
    $people->deleteFK();
    $people->delete();
  }


// Pagination
if (!isset($_GET['page'])) {
    $page = 1;
    // $previous = 1;
    $offset = 0;
  } else {
    $page = $_GET['page'];
    // $previous = $_GET['page'] - 1;
    $offset = ($page-1) * 10;
};





$stmt = $dbc->prepare('SELECT * FROM people LIMIT 10 OFFSET :offset');
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$stmts = $stmt->fetchAll(PDO::FETCH_ASSOC);




?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>DB Address Book</title>
 
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
  </head>
 
  <body>
    <div class="jumbotron">
      <div class="container">
        <h1 class="text-center">DB Address Book</h1>
      </div>
    </div>

	<h4 class="text-center"><?= "Today is ". '' . date('l \t\h\e jS');?></h4>

  <div class="container bordered img-rounded">
    <h2 class="page-header"><span id="book-icon" class="glyphicon glyphicon-book"></span> Contacts</h2>
    <div class="panel panel-default">
        <table class="table table-striped table-bordered">
		    <tr>
          <!-- <th>#</th> -->
          <th>First Name</th>
          <th>Last Name</th> 
          <th>Phone</th>    
			    <th width="70px"></th>
		    </tr>
    <!-- Loop through each of the contacts and output -->
    <?php foreach($stmts as $key => $row): ?>
        <tr>
            <!-- Loop through each value, in each address -->
            <?php foreach ($row as $value): ?>
                <td>
                    <?= $value ?>
                </td>
            <?php endforeach ?>
            <td>
                <a href="?remove=<?=$row['id'] ?>" class="btn btn-default btn-danger btn-center">X</a>

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
        <div class="col-md-10 no-pad-left">
  			<form action="/addressbookp_db.php" method="POST" enctype="multipart/form-data">
  				<h3><span class="glyphicon glyphicon-plus-sign"></span> Add a New Contact</h3>
  					<input type="text" name="fname" placeholder="First Name">
  					<input type="text" name="lname" placeholder="Last Name">
            <input type="text" name="phone" placeholder="Phone">
  					<input type="submit" value="Save">
  			</form>	
  			<br>
  			<p>
				<hr>
  			</p>
        <form method="post" enctype="multipart/form-data" action="/addressbookp_db.php">
      		<h3><span class="glyphicon glyphicon-upload"></span> Upload a File</h3>
          	<p>
              <label for="file1">File to upload: </label>
              <input type="file" id="file1" name="file1">
              <input type="submit" value="Upload">
          	</p>
        </form>
        </div>
      </div>
    </div>
 	<br>
<hr>


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