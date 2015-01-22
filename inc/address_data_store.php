 <?php
//This file is only to call my fn's 

require_once('filestore.php');

 class AddressDataStore extends Filestore {

// TODO: Remove this, now using parent!
     function __construct($filename = '')   {
        parent::__construct($filename);
   }
//For reading csv
     function readAddressBook()     {
        $this->readCSV(); 
     }
//For saving csv
     function writeAddressBook($addressesArray)     {
        $this->writeCSV();
     }

 }

 ?>