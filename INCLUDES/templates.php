<?php
	$template=array(
		# Templates Index.html #
		'plugin_html' => '',


		'header_index' => '
			<!DOCTYPE html>
			<html lang="fr">
			<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
			<title>'.TITRE.'</title>
			<link rel="icon" href="INCLUDES/IMG/favicon.png" />
			<link rel="stylesheet" href="INCLUDES/style.css" media="screen"/>

			<body class="index">
			<header>
				<h1>'.TITRE.'</h1>
			</header>
			<aside>
		',


		'footer_index' => '
			</aside>
			<footer>
				<a href="'.URL.'">Page de plugins de '.AUTEUR.'</a> générée par <a href="https://github.com/broncowdd/repositorix">Repositorix</a> 
			</footer>
			</body>
			</html>
		',


		);
	
?>