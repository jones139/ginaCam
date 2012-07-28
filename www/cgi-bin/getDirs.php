#!/usr/bin/php-cgi
<?php
###############################################
# Returns the directory tree as a json object 
# Parameters are camId and subDir.
# Starts its directory tree search at
# $realBaseDir/$camID/$subDir
#
# Graham Jones, July 2012.
#
include('config.php');
$camId = $_GET['camid'];
$subDir = $_GET['subdir'];

# Return an array which contains all of the subdirectories contained in
#  the directory $realDir (ignoring . and ..)
function getSubDirs($realDir) {
  if (!is_dir($realDir)) {
    print "ERROR - ".$realDir." is not a directory....";
    return null;
  } 
  else {
    $retObj = array();
    $retObj['data'] = $realDir;
    $fileList = scandir($realDir);      
    $dirArr = array();
    for($i = 0; $i<count($fileList); $i++) {
      $entry = $fileList[$i];
      if ($entry != "." && $entry != "..") {
	if (is_dir($realDir.'/'.$entry)) {
	  $dirArr[] = getSubDirs($realDir.'/'.$entry);
	}
      }
    }
    if (count($dirArr)>0)
      $retObj['children']=$dirArr;
    return $retObj;
  }
}


# The actual directory on the server.
$realDir = $realBaseDir.$camId.'/'.$subDir;

# The directory as it appears in a URL
$wwwDir = $wwwBaseDir.$camId.'/'.$subDir;

$retObj = array();
if (!is_dir($realDir)) {
   print "ERROR - ".$realDir." is not a directory....";
} else 
{
  $retObj = getSubDirs($realDir);
  var_dump(json_encode($retObj));
}
?>
