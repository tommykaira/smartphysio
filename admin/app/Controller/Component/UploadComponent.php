<?php

class UploadComponent extends Component{

	public function execute($file, $path){

		$error = "";
		$new_file = "";
		
		$extensions = array('jpg', 'png', 'jpeg','gif');
		$extension = end(explode(".", $file["name"]));
		if (in_array($extension, $extensions)){
			if ($file["error"] > 0){
				$error = $file['error'];
			}else{
				$new_file = md5($file['name'].time()).'.'.$extension;
				if (file_exists("{$path}/{$new_file}")){
					$error = "already exists ".$file['name'];
				}else{
					move_uploaded_file($file["tmp_name"],"{$path}/{$new_file}");
						print_r("{$path}/{$new_file}");
					
					
				}
			}
		}else{
			$error = "Invalid file";
		}

		if($error){
			return array('check' => 0, 'data' => $error);
		}else{
			return array('check' => 1, 'data' => $new_file);
		}
	}

	public function delete($filename, $path){
		if (file_exists("{$path}/{$filename}")){
			@unlink("{$path}/{$filename}");
		}
	}

}