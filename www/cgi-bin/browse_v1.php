#!/usr/bin/php-cgi
<?php
$camId = $_GET['camid'];
$subDir = $_GET['subdir'];
#echo 'subdir='.$subDir;
$realBaseDir = "/tmp/".$camId;
$wwwBaseDir = "/".$camId;

$realDir = $realBaseDir.'/'.$subDir;
$wwwDir = $wwwBaseDir.'/'.$subDir;

echo "<h1>Browsing Camera ".$camId."/".$subDir."</h1>";
echo '<p><a href="/">Home</a>'
      .':<a href="/cgi-bin/browse.php?camid='.$camId.'">'.$camId.'</a>'
      .'</p>';
#First list Directories...
if ($handle = opendir($realDir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
#        	echo $entry.'<br/>';
            if (is_dir($realDir.'/'.$entry)) {
               echo '<a href="/cgi-bin/browse.php?camid='.$camId.'&subdir='.$subDir.'/'.$entry.'">'.$entry.'</a><br/>';
            }
        }
    }
    closedir($handle);
}
$files = glob($realDir."/*.jpg");
for ($i=1; $i<count($files)-1; $i++)
{
	$realFile = $files[count($files)-$i];
	$wwwFile = $wwwDir . substr($realFile,strlen($realDir));
	echo '<img src="'.$wwwFile.'" alt="random image">'."&nbsp;&nbsp;";
	}
	?>
