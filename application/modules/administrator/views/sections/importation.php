<?php 
// echo isset($output) ? $output : '';
echo 'le fichier excel contient: un column utilisateur, un column client et un colomn entitee <br/><br/>';
echo form_open_multipart('administrator/importation/do_upload');
echo "<input type = 'file' id = 'fileupload' name = 'fileupload'><br/>";
echo "<button type='submit' id = 'import_submit' class = 'btn primary'>Importer</button>";

echo form_close();

 ?>