<div class="related-items-panel">
<?php
	echo "<h3>";
	echo elgg_echo('related-items:item-select-options');
	echo "</h3><br/>";

	echo elgg_echo('related-items:select-related') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[select_related]',
						'value' => $vars['entity']->select_related,
						'options_values' => [
								'related' => elgg_echo('related-items:title'),
								'more' => elgg_echo('related-items:more-items'),
						],
				]);
	echo "<br /><br/>";
	echo elgg_echo('related-items:limit-date') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[limit_by_date]',
						'value' => $vars['entity']->limit_by_date,
						'options_values' => [
								'no' => elgg_echo('option:no'),
								'yes' => elgg_echo('option:yes'),
						],
				]);
	echo elgg_view('input/text', ['name'=>'params[related_date_period]', 'value'=>$vars['entity']->related_date_period]);
	echo "<br /><br/>";
	echo elgg_echo('related-items:selectfrom-owner') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[selectfrom_owner]',
						'value' => $vars['entity']->selectfrom_owner,
						'options_values' => [
								'all' => elgg_echo('all'),
								'current' => elgg_echo('related-items:current-owner'),
						],
				]);
	echo "<br/><br/>";

	echo elgg_echo('related-items:max_items') . ' ';
	echo elgg_view('input/text', ['name'=>'params[max_items]', 'value'=>$vars['entity']->max_items]);
	echo "<br/><br/>";
	echo elgg_echo('related-items:select_from_thissubtype') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[select_from_this_subtype]',
						'value' => $vars['entity']->select_from_this_subtype,
						'options_values' => [
								'no' => elgg_echo('option:no'),
								'yes' => elgg_echo('option:yes'),
						],
				]);
	echo "<br/><br/>";
	echo elgg_echo('related-items:selectfrom-subtypes');
	echo "<br/><br/>";

	$valid_types = get_valid_types(['thewire', 'comment']);

	$content = '<div class="dv_selectfrom_subtypes">';
	$content .= elgg_view('input/checkboxes', [
									'id'=>'in_selectfrom_subtypes',
									'class'=>'in_selectfrom_subtypes',
									'name'=>'params[selectfrom_subtypes]',
									'options_values' => $valid_types,
									'value'=> explode(",", $vars["entity"]->selectfrom_subtypes)
							]);
	$content .= '</div>';
	echo $content;
	echo "<br/>";
	echo elgg_echo('related-items:renderto-subtypes');
	echo "<br/><br/>";

	$content = '<div class="dv_renderto_subtypes">';
	$content .= elgg_view('input/checkboxes', [
											'id'=>'in_renderto_subtypes',
											'class'=>'in_renderto_subtypes',
											'name'=>'params[renderto_subtypes]',
											'options_values' => $valid_types,
											'value'=> explode(",", $vars["entity"]->renderto_subtypes)
					]);
	$content .= '</div>';
	echo $content;
	echo "<br/><h3>";
	echo elgg_echo ('related-items:display-options');
	echo "</h3><br/>";
	echo elgg_echo('related-items:show_names') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[show_names]',
						'value' => $vars['entity']->show_names,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:show_dates') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[show_dates]',
						'value' => $vars['entity']->show_dates,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:show_timestamps') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[show_timestamps]',
						'value' => $vars['entity']->timestamps,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:show_tags') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[show_tags]',
						'value' => $vars['entity']->show_tags,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:show_types') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[show_types]',
						'value' => $vars['entity']->show_types,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:show_icons') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[show_icons]',
						'value' => $vars['entity']->show_icons,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:column_count') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[column_count]',
						'value' => $vars['entity']->column_count,
						'options_values' => [
								'4' => '4',
								'3' => '3',
								'2' => '2',
								'1' => '1',
						],
				]);
	echo "<br/>";
	echo elgg_echo('related-items:media_query') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[media_query]',
						'value' => $vars['entity']->media_query,
						'options_values' => [
								'yes' => elgg_echo('option:yes'),
								'no' => elgg_echo('option:no'),
						],
				]);

	echo "<br/>";
	echo elgg_echo('related-items:comment_position') . ' ';
	echo elgg_view('input/dropdown', [
						'name' => 'params[comment_position]',
						'value' => $vars['entity']->comment_position,
						'options_values' => [
								'top' => elgg_echo('related-items:option:top'),
								'bottom' => elgg_echo('related-items:option:bottom'),
						],
				]);

?>
</div>
