<?php

/**
 * @package Form Builder
 * @version 1.0.0
 */
/*
Plugin Name: Forms Builder
Plugin URI: https://www.wordpress.com
Description: This plugin allows admins to create custom forms for their application
Author: Makanaokeakua Edwards | Makri Software Development
*/

add_action('init', 'loadClasses', 0);
add_action('admin_menu', 'add_menu');

function add_menu()
{
	add_menu_page(__('Form Builder'), __('Form Builder'), 'manage_options', 'form-builder-menu-page', 'form_builder_page', '', 0);
	add_submenu_page('form-builder-menu-page', __('Forms'), __('Forms'), 'manage_options', 'edit.php?post_type=forms', '', 0);
}

function form_builder_page()
{
	echo '<h1>Welcome to the Form Builder admin page.</h1>';
}

function loadClasses()
{
	$class_files = glob(__DIR__ . '/Classes/*.php');
	$type_files = glob(__DIR__ . '/Types/*.php');
	$loaded_classes = [];

	foreach ($class_files as $file) {
		if (file_exists($file)) {
			require_once $file;
			$loaded_classes = array_merge($loaded_classes, get_declared_classes());
		}
	}

	foreach ($type_files as $file) {
		if (file_exists($file)) {
			require_once $file;
			$loaded_classes = array_merge($loaded_classes, get_declared_classes());
		}
	}

	foreach ($loaded_classes as $class) {
		if (strpos($class, 'FormBuilder\\') === 0 && class_exists($class)) {
			$instance = new $class();
			$methods = get_class_methods($instance);
			if (in_array('init', $methods)) {
				$instance->init();
			}
		}
	}
}
