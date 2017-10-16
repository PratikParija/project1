<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
//Check if file is a csv file or not
if($fileType != "csv"){
	echo "Sorry, only CSV files are allowed.";
	$uploadOk = 0;
}

//Check if $uploadOk is set to 0 by an error
if($uploadOk == 0){
	echo "Sorry, your file was not uploaded.";
//if everything is ok, try to upload file
}
else{
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
		echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$file = ($_FILES["fileToUpload"]["name"]);
	}
	else{
		echo "Sorry, there was an error uploading your file.";
	}
}

header("Location: https://web.njit.edu/~pp285/project1/index.php?page=htmlTable&file=$file");


?>
