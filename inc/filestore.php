<?php

//Transferring my fn's here
class Filestore {
   public $filename = '';
   protected $isCSV = false;

function __construct($filename)     {
        $this->filename = $filename;
         var_dump($this->filename);

        if (!file_exists($filename))
            touch ($filename);

        if (substr($filename, -3) == 'csv')
            $this->isCSV = true;
     }

     public function read() {
        if ($this->isCSV) {
            return $this->readCSV();
        } else {
            return $this->readLines();
        }
     }

     public function write($array) {
        if ($this->isCSV) {
            return $this->writeCSV($array);
        } else {
            return $this->writeLines($array);
        }
}


   // Returns array of lines in $this->filename
   private function readLines()   {

        $todo_array = [];

        if (filesize($this->filename) == 0) {
            return $todo_array;
        } else {
            $handle = fopen($this->filename, 'r');
            $contents = trim(fread($handle, filesize($this->filename)));
            $contentsarray = explode("\n", $contents);
            fclose($handle);

            return $contentsarray;
        }
   }

   // Writes each element in $array to a new line in $this->filename    
   private function writeLines($array)   {
    var_dump($array);
    $handle = fopen($this->filename, 'w');
        foreach ($array as $item) {
            fwrite($handle, $item . PHP_EOL);
        }
    fclose($handle);
   }

    // Reads contents of csv $this->filename, returns an array
   private function readCSV()   {
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

   // Writes contents of $array to csv $this->filename
   private function writeCSV($array)   {
     $handle = fopen($this->filename, 'w');

        foreach ($array as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }

    public function uploadFile() {

    //Set the destination directory for uploads on object creation
    $uploadDestination = '/vagrant/sites/planner.dev/public/uploads/';

    // Grab the filename from the uploaded file by using basename
    $basename = basename($this->filename);

    // Create the saved filename using the file's original name and our upload directory
    $savedFilename = $uploadDestination . $basename;

    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

    // Sets the object's property $filename.
    $this->filename = $savedFilename;
    }
}

?>