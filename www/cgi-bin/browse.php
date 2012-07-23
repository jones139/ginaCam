#!/usr/bin/php-cgi
<?php
include('config.php');
$camId = $_GET['camid'];
$subDir = $_GET['subdir'];

$realDir = $realBaseDir.$camId.'/'.$subDir;
$wwwDir = $wwwBaseDir.$camId.'/'.$subDir;

echo '<link rel="stylesheet" type="text/css" href="/webcam/webcam.css" />';

echo "<h1>Browsing Camera ".$camId."/".$subDir."</h1>";
echo '<p><a href="'.$wwwBaseDir.'">Home</a>'
      .':<a href="/cgi-bin/browse.php?camid='.$camId.'">'.$camId.'</a>'
      .'</p>';


# Scan Directory
if (!is_dir($realDir)) {
   print "ERROR - ".$realDir." is not a directory....";
} else 
{
    $fileList = scandir($realDir);  

    #First list Directories...
    echo "<h2>Directories</h2>";
    for($i = 0; $i<count($fileList); $i++) {
    	   $entry = $fileList[$i];
           if ($entry != "." && $entry != "..") {
              if (is_dir($realDir.'/'.$entry)) {
               	 echo '<a href="/cgi-bin/browse.php?camid='.$camId.
		      '&subdir='.$subDir.'/'.$entry.'">'.$entry.'</a><br/>';
              }
    	   }
    }


    #Now list animated gif video files
    echo "<h2>Videos</h2>";

    for ($i=0; $i<count($fileList); $i++)
    {
	$fileParts = explode(".",$fileList[$i]);
	$fileExt = $fileParts[count($fileParts)-1];
	$validExts = array('gif','avi','mpg','mpeg','mp4','swf');
	if (in_array($fileExt,$validExts)) {
	   $realFile = $realDir.'/'.$fileList[$i];
	   $wwwFile = $wwwDir . substr($realFile,strlen($realDir));
	   echo '<a href="'.$wwwFile.'">'.$fileList[$i].'</a><br/>';
	}
    }

    #Now list image files
    echo "<h2>Images<h2/>";
    for ($i=0; $i<count($fileList); $i++)
    {
	$fileParts = explode(".",$fileList[$i]);
	$fileExt = $fileParts[count($fileParts)-1];
	$validExts = array('jpg','jpeg','png');
	if (in_array($fileExt,$validExts)) {
	   $realFile = $realDir.'/'.$fileList[$i];
	   $wwwFile = $wwwDir . substr($realFile,strlen($realDir));
	   echo '<a href="'.$wwwFile.'">';
	   echo '<img class="thumbnail" src="'.$wwwFile.'" alt="Snapshot Image">';
	   echo '</a>';
	   echo "&nbsp;&nbsp;";
	}
    }

}
?>
