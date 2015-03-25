<?php
	/*
	* **************************************************************************************************
	* Repositorix 
	* @version 1.0
	* @author bronco@warriordudimanche.net
	* @url warriordudimanche.net
	* 
	* gestionnaire simplifié de dépôt de plugin PluXML
	* compatible avec spxplugindownloader de je-evrard (http://forum.pluxml.org/viewtopic.php?id=4934)
	* 
	* - gestion du glisser-déposer d'un zip de plugin
	* - génération automatique d'un fichier repository.xml
	* - génération automatique d'un flux RSS
	* - génération automatique d'une page regroupant tous les plugins avec leur lien de téléchargement
	* 
	* **************************************************************************************************
	*/

	include('INCLUDES/auto_restrict.php');
	include('INCLUDES/functions.php');
	include('INCLUDES/config.php');
	include('INCLUDES/templates.php');
	# Gestion de la régénération 
	if (isset($_GET['regen'])){
		$xml='<?xml version="1.0" encoding="UTF-8"?><document>'."\n";
		$html=$template['header_index'];
		$zipfiles=glob('ZIPFILES/*.zip');
		sort($zipfiles,SORT_NATURAL | SORT_FLAG_CASE);
		foreach ($zipfiles as $zipfile){
			$nom=str_replace('.zip','',basename($zipfile));
			$file=basename($zipfile);
			$dest='REPO/'.$nom;
			rrmdir($dest);
			unzip_file($zipfile, 'REPO/');
			rename ($dest.'/icon.png', $dest.'/'.$nom.'.png');
			
	      	preg_match('#\<document\>([^§]+)\<\/document\>#i',file_get_contents($dest.'/infos.xml'),$infos);
	      	$icon=URL_ROOT.'REPO/'.$nom.'/'.$nom.'.png';
	      	$zip=URL_ROOT.'ZIPFILES/'.$file;
	      	# XML 
	      	$xml.="<plugin>\n";
	      	$xml.=$infos[1];
	      	$xml.='<name>'.$nom.'</name>'."\n";
	      	$xml.='<file>'.$zip.'</file>'."\n";
	      	$xml.='<icon>'.$icon.'</icon>'."\n";
	      	$xml.="</plugin>\n";
	      	# HTML
	      	$html.="<ul class=\"plugin\">\n";
	      	$html.='<img class="icon" src="'.$icon.'"/>';
	      	$html.=info2html($infos[1]);
	      	$html.='<li class="download"><a href="'.$zip .'">'.$file.'</a></li>';
	      	$html.="</ul>\n";

		}
		$xml.='</document>';
		$html.=$template['footer_index'];
		$version=intval(@file_get_contents('repository.version'));
		$version++;
		file_put_contents('repository.version', $version);
		file_put_contents('repository.xml', $xml);
		file_put_contents('index.html', $html);

	}
	

?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
<title><?php echo TITRE; ?></title>
<link rel="icon" href="INCLUDES/IMG/favicon.png" />
<link rel="stylesheet" href="INCLUDES/style.css" media="screen"/>

<body>
<header>
	<h1><?php echo TITRE; ?></h1>
	<h4>Lien vers le XML du dépôt: <a href="<?php echo URL_ROOT.'repository.xml';?>"><?php echo URL_ROOT.'repository.xml';?></a></h4>

</header>
<aside>
<?php 
test_server_config();
	unset($_SESSION['auto_dropzone']);
	$auto_dropzone['auto_refresh_after_upload']=true;
	$auto_dropzone['dropzone_text']="Glisser les ZIP des plugins";
	$auto_dropzone['destination_filepath']='../ZIPFILES/';
	$auto_dropzone['my_filepath']='INCLUDES/auto_dropzone.php';
	$auto_dropzone['allowed_filetypes']='zip';
	$auto_dropzone['use_style']=false;
	include('INCLUDES/auto_dropzone.php');


?>

</aside>

<footer>
	Repositorix by <a href="http://warriordudimanche.net"/>Bronco</a>
</footer>
</body>
</head>
