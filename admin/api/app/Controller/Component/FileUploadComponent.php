<?php
class FileUploadComponent extends Component{
	
	public function doUpload($file){
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		$extension = end(explode(".", $file["name"]));
		if ((($file["type"] == "image/gif")
		|| ($file["type"] == "image/jpeg")
		|| ($file["type"] == "image/png")
		|| ($file["type"] == "image/pjpeg"))
		&& in_array($extension, $allowedExts))
		  {
		  if ($file["error"] > 0)
		    {
		    return -1;
		    }
		  else
		    {
		   		$newName = 'logo'.md5($file['name'].time()).'.'.$extension;
		    if (file_exists("files/uploads/" . $newName))
		      {
		      return -1;
		      }
		    else
		      {
		      move_uploaded_file($file["tmp_name"],"files/uploads/" . $newName);
		      return $newName;
		      }
		    }
		  }
		else
		  {
		  return -1;
	  }
	}
}
