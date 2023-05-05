<?php

/**
 * @package Loader
 * @version 1.0.0
 */
/*
Plugin Name: Loader
Plugin URI: https://github.com/MakanaMakesStuff/PHPClassLoader
Description: This is an example plugin using a class loader
Author: Makanaokeakua Edwards | Makri Software Development
*/

add_action('init', 'loadClasses', 0);

function loader_page()
{
	echo '<h1>Welcome to the Loader Plugin page!</h1>';
}

function loadClasses()
{
	$base = "Loader\\";
	$class_files = glob(__DIR__ . '/Classes/*.php');
	$settings_files = glob(__DIR__ . '/Settings/*.php');
	$type_files = glob(__DIR__ . '/Types/*.php');
	$loaded_classes = [];

	foreach ($class_files as $file) {
		if (file_exists($file)) {
			require_once $file;
		}
	}

	foreach ($settings_files as $file) {
		if (file_exists($file)) {
			require_once $file;
			$loaded_classes = $base . "Settings\\" . basename($file, '.php');
		}
	}

	foreach ($type_files as $file) {
		if (file_exists($file)) {
			require_once $file;
			$loaded_classes = $base . "Types\\" . basename($file, '.php');
		}
	}

	foreach ($loaded_classes as $class) {
		if (class_exists($class)) {
			$instance = new $class();
			$methods = get_class_methods($instance);
			if (in_array('init', $methods)) {
				$instance->init();
			}
		}
	}
}
