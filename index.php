<?php

//turn on debugging msgs
ini_set('display_errors', 'On');
error_reporting(E_ALL);

class Manage{
	public static function autoload($class){
		include $class . '.php';
	}
}

spl_autoload_register(array('Manage', 'autoload'));

$obj = new main();

class main{

	public function __construct(){
		
		$pageRequest = 'uploadForm';
		if(isset($_REQUEST['page'])){
			$pageRequest = $_REQUEST['page'];
		}
		$page = new $pageRequest;

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$page->get();
		}
		else{
			$page->post();
		}
	}
}

abstract class page{
	protected $html;

	public function __construct(){
		$this->html .= '<html>';
		$this->html .= '<link rel="stylesheet" href="styles.css">';
		$this->html .= '<body>';
	}

	public function __destruct(){
		$this->html .= '</body></html>';
		stringFunctions::printThis($this->html);
	}

	public function get(){
		echo 'default get message';
	}

	public function post(){
		print_r($_POST);	
	}
}

/*class homepage extends page{
	
	public function get(){
		$form = '<form action="index.php" method="post">';
		$form .= 'First name:<br>';
		$form .= '<input type="text" name="firstname" value="Mickey">';
		$form .= '<br>';
		$form .= 'Last name:<br>';
		$form .= '<input tyoe="text" name="lastname" value="Mouse">';
		$form .= '<input type="submit" value="Submit">';
		$form .= '</form>';
		$this->html .= 'homepage';
		$this->html .= $form;
	}
}*/

class uploadForm extends page{
	
	public function get(){
		$form = '<form enctype="multipart/form-data" action="upload.php"  method="post">';
		$form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
		$form .= '<input type="submit" value="Upload File" name="submit">';
		$form .= '</form>';
		$this->html .= '<h1>Upload Form</h1>';
		$this->html .= $form;
	}

	public function post(){
		//print_r($_FILES);
	}
}

class htmlTable extends page{
	
	public function get(){
		
		$fileName = $_REQUEST['file'];

		$f = fopen("uploads/$fileName",'r');
		$data = fgetcsv($f);
		echo '<html><body><table>';
		while(($data =	fgetcsv($f)) !== FALSE){
			//generate HTML
			echo '<tr>';
			foreach($data as $cell){
				echo '<td>' . htmlspecialchars($cell) . '</td>';
			}
			echo '</tr>';
		}
		fclose($f);
		echo '</table></body></html>';

	}

	/*public function post(){
		$fileName = $_REQUEST['filename'];
		
		$f = fopen($fileName, 'r');
		$data = fgetcsv($f);
		echo('<table>');
		while(($data = fgetcsv($f)) !== FALSE){
			//generate HTML
			echo '<tr>';
			foreach($data as $cell){
				echo '<td>' . htmlspecialchars($cell) . '</td>';
			}
			echo '</tr>\n';
		}
		fclose($f);
		echo '\n</table></body></html>';
 
	}*/
}


?>
