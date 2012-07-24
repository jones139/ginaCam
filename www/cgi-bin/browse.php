#!/usr/bin/php-cgi
<?php
include('config.php');
$camId = $_GET['camid'];
$subDir = $_GET['subdir'];
$ajax = $_GET['ajax'];

$realDir = $realBaseDir.$camId.'/'.$subDir;
$wwwDir = $wwwBaseDir.$camId.'/'.$subDir;

$retObj = array();



# Scan Directory
if (!is_dir($realDir)) {
   print "ERROR - ".$realDir." is not a directory....";
} else 
{
    $fileList = scandir($realDir);  

    #First list Directories...
    $dirArr = array();
    for($i = 0; $i<count($fileList); $i++) {
    	   $entry = $fileList[$i];
           if ($entry != "." && $entry != "..") {
              if (is_dir($realDir.'/'.$entry)) {
	         $dirURL = $wwwBaseDir.'/cgi-bin/browse.php?camid='.$camId.
		      '&subdir='.$subDir.'/'.$entry;
	         $dirArr[]=$dirURL;
              }
    	   }
    }
    $retObj['directories']=$dirArr;

    #Now list animated gif video files
    $vidArr = array();
    for ($i=0; $i<count($fileList); $i++)
    {
	$fileParts = explode(".",$fileList[$i]);
	$fileExt = $fileParts[count($fileParts)-1];
	$validExts = array('gif','avi','mpg','mpeg','mp4','swf');
	if (in_array($fileExt,$validExts)) {
	   $realFile = $realDir.'/'.$fileList[$i];
	   $wwwFile = $wwwDir . substr($realFile,strlen($realDir));
	   #echo '<a href="'.$wwwFile.'">'.$fileList[$i].'</a><br/>';
	   $vidArr[]=$wwwFile;
	}
    }
    $retObj['videos']=$vidArr;

    #Now list image files
    $imgArr = array();
    for ($i=0; $i<count($fileList); $i++)
    {
	$fileParts = explode(".",$fileList[$i]);
	$fileExt = $fileParts[count($fileParts)-1];
	$validExts = array('jpg','jpeg','png');
	if (in_array($fileExt,$validExts)) {
	   $realFile = $realDir.'/'.$fileList[$i];
	   $wwwFile = $wwwDir . substr($realFile,strlen($realDir));
	   #echo '<a href="'.$wwwFile.'">';
	   #echo '<img class="thumbnail" src="'.$wwwFile.'" alt="Snapshot Image">';
	   #echo '</a>';
	   #echo "&nbsp;&nbsp;";
	   $imgArr[] = $wwwFile;
	}
    }
    $retObj['images']=$imgArr;

    if (isset($ajax)) {
        print json_encode($retObj);
    } else {
      echo '<link rel="stylesheet" type="text/css" href="'
	.$wwwBaseDir.'/css/webcam.css" />';
      echo '<script src="'.$wwwBaseDir.'/js/jquery-1.7.2.min.js"></script>';
      echo '<script src="'.$wwwBaseDir.'/js/jquery-ui-1.8.21.custom.min.js"></script>';
      echo '<script type="text/javascript" src="'.$wwwBaseDir.'/js/jquery.timers-1.2.js"></script>';
      echo '<script type="text/javascript" src="'.$wwwBaseDir
	.'/js/jquery.easing.1.3.js"></script>';
      echo '<script type="text/javascript" src="'.$wwwBaseDir
	.'/js/jquery.galleryview-3.0-dev.js"></script>';
      echo '<link type="text/css" rel="stylesheet" href="'.$wwwBaseDir
	.'/css/jquery.galleryview-3.0-dev.css" />';

      echo '<script type="text/javascript">'
	.'$(function(){'
	.'	$("#imgGallery").galleryView({'
	.'      transition_speed:1000,'
	.'      transition_interval:500,'
	.'      panel_animation:"fade",'
	.'      autoplay:true'
	.'      });'
	.'});'
	.'</script>';


      echo "<h1>Browsing Camera ".$camId."/".$subDir."</h1>";
      echo '<p><a href="'.$wwwBaseDir.'">Home</a>'
	.':<a href="'.$wwwBaseDir.'/cgi-bin/browse.php?camid='.$camId.'">'.$camId.'</a>'
	.'</p>';

      echo "<h2>Directories</h2>";
      echo "<ul>";
      for ($i = 0; $i<count($retObj['directories']); $i++) {
	$dirURL = $retObj['directories'][$i];
	$urlParts = (explode("&subdir=",$dirURL));
	$dirName = $urlParts[1];
	echo '<li><a href="'.$dirURL.'">'.$dirName.'</a></li>';
      }
      echo "</ul>";
      echo "<h2>Videos</h2>";
      echo "<ul>";
      for ($i = 0; $i<count($retObj['videos']); $i++) {
	$vidURL = $retObj['videos'][$i];
	$urlParts = (explode("/",$vidURL));
	$vidFname = $urlParts[count($urlParts)-1];
	echo '<li><a href="'.$vidURL.'">'.$vidFname.'</a></li>';
      }
      echo "</ul>";

      echo "<h2>Images<h2/>";
      echo "<ul id='imgGallery'>";
      for ($i = 0; $i<count($retObj['images']); $i++) {
	$imgURL = $retObj['images'][$i];
	$urlParts = (explode("/",$imgURL));
	$imgFname = $urlParts[count($urlParts)-1];
	echo '<li>'
	  .'<img class="thumbnail" src="'
	  .$imgURL.'" alt="image..."></li>';
      }
      echo "</ul>";

    }

}
?>
