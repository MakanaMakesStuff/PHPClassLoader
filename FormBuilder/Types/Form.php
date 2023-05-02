<?php

/**
 * Custom Form Type
 * @package Form Builder Form Type
 * @author Makanaokeakua Edwards | Makri Software Development
 * @copyright 2023 @ Makri Software Development
 * @license Proprietary
 * @link https://makrisoftwaredevelopment.com
 */

declare(strict_types=1);

namespace FormBuilder\Types;

use FormBuilder\Classes\Base;

class Form extends Base
{
	public function init()
	{
		add_action('init', [$this, 'registerTypes']);
		add_action('add_meta_boxes', [$this, 'doMetaBoxes']);
	}

	public function registerTypes()
	{
		$id = "forms";
		$singular = "Form";
		$plural = "Forms";
		$supports = ['title', 'author'];

		$options = [
			'labels' => [
				'name' => $plural,
				'singular_name' => $singular,
				'menu_name' => $plural,
				'name_admin_bar' => $singular,
				'add_new' => sprintf(__('New %s'), $singular),
				'add_new_item' => sprintf(__('Add New %s'), $singular),
				'new_item' => sprintf(__('New %s'), $singular),
				'edit_item' => sprintf(__('Edit %s'), $singular),
				'view_item' => sprintf(__('View %s'), $singular),
				'all_items' => sprintf(__('%s'), $plural),
				'search_items' => sprintf(__('Search %s'), $plural)
			],
			'show_in_rest' => true,
			'show_ui' => true,
			'show_in_menu' => false,
			'menu_position' => 1,
			'map_meta_cap' => true,
			'capabilities' => [
				'edit_posts' => 'edit_users',
				'edit_others_posts' => 'edit_users',
				'edit_published_posts' => 'edit_users',
				'publish_posts' => 'edit_users',
				'read_posts' => 'edit_users',
				'delete_posts' => 'edit_users',
				'create_posts' => 'edit_users',
				'read_private_posts' => 'edit_users'
			],
			'supports' => $supports,
			'taxonomies' => []
		];

		register_post_type($id, $options);
	}

	public function doMetaBoxes($post_type)
	{
		add_meta_box('form_editor_meta_box', __('Form Editor'), [$this, 'doEditor'], $post_type, 'advanced', 'high');
	}

	public function doEditor($post)
	{
		$input_types = [
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'phone_number' => 'Phone Number',
			'email' => 'Email',
			'number' => 'Number',
			'text_area' => 'Text Area',
			'generic' => 'Generic Input'
		];
?>
		<section class="form-builder">
			<table class="form-table">
				<tbody>
					<tr id="inputs_0" class="inputs">
						<td>
							<label for="label_0">Label</label>
							<input id="label_0" type="text" name="form_inputs[0][label]" placeholder="Input Label">
						</td>

						<td>
							<label for="type_0">Type</label>
							<select id="type_0" name="form_inputs[0][type]">
								<?php foreach ($input_types as $value => $label) { ?>
									<option value="<?php echo $value ?>"><?php echo $label ?></option>
								<?php } ?>
							</select>
						</td>

						<td id="placeholder_wrap_0">
							<label for="placeholder_0">Placeholder</label>
							<textarea id="placeholder_0" name="form_inputs[0][placeholder]" type="text" placeholder="Placeholder" rows="1"></textarea>
						</td>

						<td id="text_wrap_0">
							<label for="text_0">Text</label>
							<textarea id="text_0" name="form_inputs[0][text]" type="text" placeholder="Placeholder"></textarea>
						</td>

						<td>
							<label for="required_0">Required</label>
							<input id="required_0" name="form_inputs[0][required]" type="checkbox" />
						</td>
					</tr>

					<tr>
						<td class="custom-dropdown">
							<a href="#" onclick="javascriptFunction1()" class="button button-primary">Add Input</a>
							<a href="#" onclick="javascriptFunction2()" class="button button-primary">Add Text</a>
						</td>
					</tr>
				</tbody>
			</table>
		</section>
		<script>
			jQuery(document).ready(function($) {
				const inputs = $('.inputs');

				for (let i = 0; i < inputs.length; i++) {
					let placeholder = $(`#placeholder_wrap_${i}`, inputs[i]);
					let text = $(`#text_wrap_${i}`, inputs[i]);
					let type = $(`#type_${i}`).val();

					if (type === 'text') {
						placeholder.html('');
					} else {
						text.html('');
					}

					$(`#type_${i}`).on('change', function(event) {
						if (event.target.value === 'text') {
							placeholder.html('');
						} else {
							text.html('');
						}
					})
				}
			})
		</script>

		<style>
			.form-table tr {
				display: flex;
				flex-direction: row;
				justify-content: flex-start;
				align-items: flex-start;
			}

			.form-table tr.inputs td {
				display: flex;
				flex-direction: column;
				justify-content: flex-start;
				align-items: flex-start;
			}
		</style>
<?php
	}
}
