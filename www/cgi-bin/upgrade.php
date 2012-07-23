#!/usr/bin/php-cgi
<?php
echo "upgrade.php";
$fileId="upgradeFile";

#for ($i=0; $i<count($_FILES); $i++){
#  echo "FileNo=" . $i . ": " . $_FILES[$i]["name"];
#}

if ($_FILES[$fileId]["error"] > 0)
  {
  echo "Error: " . $_FILES[$fileId]["error"] . "<br />";
  }
else
  {
    echo "<p>Installing Upgrade....</p>";
    echo "<p>File Type=".$_FILES[$fileId]["type"]."</p>";
    system("sh /www/cgi-bin/installUpgrade.sh ".$_FILES[$fileId]["tmp_name"]);
    echo "<p>Done!</p>";
  }
?>
