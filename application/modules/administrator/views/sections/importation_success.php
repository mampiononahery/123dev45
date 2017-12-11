<?php 
// echo isset($output) ? $output : '';
echo form_open_multipart('administrator/importation/do_upload');
echo "<input type = 'file' name = 'fileupload' >";
echo "<input type='submit' value = 'upload'>";
echo form_close();

 ?>