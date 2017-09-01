<?php
# Fonction vérifiant les droits d'accès en écriture
# @echo: error message
function test_server_config(){
	$msg='';
	if (!is_writable('REPO')){$msg.='<li>Le dossier <strong>REPO/</strong> n\'est pas accessible en écriture</li>';}
	if (!is_writable('ZIPFILES')){$msg.='<li>Le dossier <strong>ZIPFILES/</strong> n\'est pas accessible en écriture</li>';}
	
	if (!empty($msg)){echo '<div class="error">'.$msg.'</div>';}else{return true;}
}

# Fonction supprimant un dossier et son contenu
# @author http://php.net/manual/fr/function.rmdir.php#98622
function rrmdir($dir) {     
	if (is_dir($dir)) {       
		$objects = scandir($dir);       
		foreach ($objects as $object) {         
			if ($object != "." && $object != "..") {           
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);         
			}       
		}       
		reset($objects);       
		rmdir($dir);     
	}  
}

# Fonction dézippant un zip
# @author http://www.infowebmaster.fr/tutoriel/dezipper-un-fichier-zip-en-php
function unzip_file($file, $destination) {
	// Créer l'objet (PHP 5 >= 5.2)
	$zip = new ZipArchive() ;
	// Ouvrir l'archive
	if ($zip->open($file) !== true) {
		return "Impossible d'ouvrir l'archive";
	}
	// Extraire le contenu dans le dossier de destination
	$zip->extractTo($destination);
	// Fermer l'archive
	$zip->close();
	// Afficher un message de fin
	return true;
}
function info2html($str){
	global $icon;
	$str=str_ireplace('<![CDATA[', '', $str);
	$str=str_ireplace(']]>', '', $str);
	$str=str_ireplace('title>', 'h2>', $str);
	$str=str_ireplace('<h2>', '<h2><img class="icon" src="'.$icon.'"/>', $str);
	$str=str_ireplace('<author>', '<li class="author">Auteur&nbsp;&nbsp;: ', $str);
	$str=str_ireplace('</author>', '</li>', $str);
	$str=str_ireplace('</version>', '</li>', $str);
	$str=str_ireplace('</date>', '</li>', $str);
	$str=str_ireplace('</site>', '}}</li>', $str);
	$str=str_ireplace('<site>', '<site>{{', $str);
	$str=str_ireplace('<compatible>', '<li class="compatible">PluXML&nbsp;&nbsp;: ', $str);
	$str=str_ireplace('</compatible>', '</li>', $str);
	$str=str_ireplace('<version>', '<li class="version">version : ', $str);
	$str=str_ireplace('<date>', '<li class="date">date&nbsp;&nbsp;&nbsp;&nbsp;: ', $str)
;	$str=str_ireplace('<site>', '<li class="site">site&nbsp;&nbsp;&nbsp;&nbsp;: ', $str);
	$str=str_ireplace('description>', 'div>', $str);
	$str = preg_replace_callback('/(?:\{\{)([a-zA-Z0-9\.:\/-_]+)(?:\}\})/i', function($matches) {
		return '<a href="'.$matches[1].'">'.$matches[1].'</a>';
	}, $str);
	return $str;
}
function full_url() {     $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";     $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;     $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);     return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI']; }
?>