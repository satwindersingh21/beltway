<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

if(isset($_COOKIE['fredomfest'])) {
	header("Location: https://www.celebrium.com/freedomfest-download/");	
} else {
	setcookie('fredomfest', 'downloaded', time()+(3600 * 24 * 10 ), "/");
	
	$wp_upload_dir = wp_upload_dir();
	
	$celebPath = $wp_upload_dir['basedir'] . '/celebriums/';
	$storePath = $wp_upload_dir['basedir'].'/store/';
	$sentPath = $wp_upload_dir['basedir'].'/sent/';
	$storeUrl = $wp_upload_dir['baseurl'].'/store/';
	$sentUrl = $wp_upload_dir['baseurl'].'/sent/';
	$array = []; 
	if ($handle = opendir($storePath)) {
		
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				
				$file = $storePath.$entry;
				
				$array[] = $entry;
				
				$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
				$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
				$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
				
				if($iPod || $iPhone || $iPad ){
					copy($file,  $sentPath.basename($file));
					unlink($file);
					?>
					<img src="<?= $sentUrl. $entry ?>"  />
				<?php 	
					
				}  else {
					$fileContent = @file_get_contents($file);
					 
					copy($file,  $sentPath.basename($file));
					sleep(2);	
					unlink($file);
					
					#setting headers
					header('Content-Description: File Transfer');
					header('Cache-Control: public');
					header('Content-Type: image/jpeg');
					//header('Content-Description: File Download');
					header('Content-Type: application/octet-stream');
					header("Content-Transfer-Encoding: binary");
					header('Content-Disposition: attachment; filename=' . basename($file));
					//header("Content-Type: application/force-download");
					//header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					//header('Pragma: public');
					header('Content-length: ' . filesize($file));
		  
					echo $fileContent;
				}
				break; 
			}
		}

		closedir($handle);
	}
	if(empty($array)){
		header("Location: https://www.celebrium.com/freedomfest-finished/");	
	}
}
?>

