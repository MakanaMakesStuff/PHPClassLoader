<?php

/**
 * Menu
 * @package Loader
 * @author Makanaokeakua Edwards | Makri Software Development
 * @copyright 2023 @ Makri Software Development
 * @license Proprietary
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Loader\Settings;

use Loader\Classes\Base;

class Menu extends Base
{
	public function init()
	{
		add_action('admin_menu', [$this, 'addMenu']);
	}

	function add_menu()
	{
		add_menu_page(__('Loader'), __('Loader'), 'manage_options', 'loader-menu-page', 'loader_page', '', 0);
		add_submenu_page('loader-menu-page', __('Hello'), __('Hello'), 'manage_options', 'edit.php?post_type=hello', '', 0);
	}
}
