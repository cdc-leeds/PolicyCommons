<?php

include_once("../config.php");
include_once("../includes/header.php");
    
include_once("../phplib/importlib.php");

// check that user not already logged in
if(!isset($USER->userid)){
  header('Location: index.php');  
  return; 
}

global $CFG, $USER;
    
echo "<h1>Import from LKIF XML file</h1>";
    
$errors = array();

//if submitted then process the file
if(isset($_POST["import"])) {

  //upload the file
  if ($_FILES["lkifxmlfile"]['name'] != "") {
    $target_path = $CFG->workdir;   
    $dt = time();

    //replace any non alphanum chars in filename 
    $filename = $USER->userid ."_". $dt
    ."_". basename(eregi_replace('[^A-Za-z0-9.]', '',
    $_FILES["lkifxmlfile"]['name']));

    $target_path = $target_path . $filename;
            
    if(!move_uploaded_file($_FILES["lkifxmlfile"]['tmp_name'],
 $target_path)) {
      array_push($errors,"An error occured uploading the file");   
    }
            
    $xml = new DOMDocument();
    if (!@$xml->load($target_path)) {
      array_push($errors,"Not a valid XML file");
    } 
            
    if(empty($errors)) {
      $results = array();
      importLKIFXML($xml,$errors,$results);   
                
      if (empty($errors)) {
	echo "<div class='results'>The file was sucessfully uploaded
	and imported:<ul>";

	foreach ($results as $result){
	  echo "<li>".$result."</li>";
	}
	echo "</ul></div>";
      } 
    }

    //delete the file
    unlink($target_path);
                  
  }
}
     
if(!empty($errors)){
  echo "<div class='errors'>The following problems were found during
  the upload, please try again:<ul>";

  foreach ($errors as $error){
    echo "<li>".$error."</li>";
  }
  echo "</ul></div>";
}
?>
   
<form action="" method="post" enctype="multipart/form-data">
    <div class="formrow">
        <label class="formlabel" for="lkifxmlfile">LKIF XML File:</label>
        <input class="forminput" id="lkifxmlfile" name="lkifxmlfile" type="file" size="40">
    </div>
    <div class="formrow">
        <input class="formsubmit" type="submit" value="Import" id="import" name="import">
    </div>

</form>

<?php
  include_once("../includes/footer.php");
?>