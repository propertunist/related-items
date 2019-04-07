<div class="related-items-panel">
<?php
	echo "<h3>";
	echo elgg_echo('related-items:item-select-options');
	echo "</h3><br/>";

    echo elgg_echo('related-items:select-related') . ' ';
    echo elgg_view('input/dropdown', array(
                        'name' => 'params[select_related]',
                        'value' => $vars['entity']->select_related,
                        'options_values' => array(
                                'related' => elgg_echo('related-items:title'),
                                'more' => elgg_echo('related-items:more-items'),
                        ),
                ));
    echo "<br /><br/>";
	echo elgg_echo('related-items:limit-date') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[limit_by_date]',
                        'value' => $vars['entity']->limit_by_date,
                        'options_values' => array(
                                'no' => elgg_echo('option:no'),
                                'yes' => elgg_echo('option:yes'),
                        ),
                ));
	echo elgg_view('input/text', array('name'=>'params[related_date_period]', 'value'=>$vars['entity']->related_date_period));
	echo "<br /><br/>";
	echo elgg_echo('related-items:selectfrom-owner') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[selectfrom_owner]',
                        'value' => $vars['entity']->selectfrom_owner,
                        'options_values' => array(
                                'all' => elgg_echo('all'),
                                'current' => elgg_echo('related-items:current-owner'),
                        ),
                ));
	echo "<br/><br/>";

	echo elgg_echo('related-items:max_items') . ' ';
	echo elgg_view('input/text', array('name'=>'params[max_items]', 'value'=>$vars['entity']->max_items));
	echo "<br/><br/>";
	echo elgg_echo('related-items:select_from_thissubtype') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[select_from_this_subtype]',
                        'value' => $vars['entity']->select_from_this_subtype,
                        'options_values' => array(
                                'no' => elgg_echo('option:no'),
                                'yes' => elgg_echo('option:yes'),
                        ),
                ));
	echo "<br/><br/>";
	echo elgg_echo('related-items:selectfrom-subtypes');
	echo "<br/><br/>";

	$content = '<div class="dv_selectfrom_subtypes">';
	$valid_types = get_valid_types(array('thewire', 'comment'));

	$active_from_subtypes = array_filter(explode(',', $vars["entity"]->selectfrom_subtypes));
  $checked_subtypes = array();
  foreach ($valid_types as $valid_type)
  {
      if (in_array($valid_type, $active_from_subtypes))
      {
          $checked_subtypes[] = $valid_type;
      }
  }
	$content .= elgg_view('input/checkboxes',array(
                                    'name'=>'from_subtypes',
                                    'value'=>$checked_subtypes,
                                    'options'=>$valid_types,
                                    'default' => false));
	$content .= '</div>';
	$content .= elgg_view('input/hidden',array(
                                    'id'=>'in_selectfrom_subtypes',
                                    'class'=>'in_selectfrom_subtypes',
                                    'name'=>'params[selectfrom_subtypes]',
                                    'value'=>$vars["entity"]->selectfrom_subtypes)
                            );
	echo $content;
	echo "<br/>";
	echo elgg_echo('related-items:renderto-subtypes');
	echo "<br/><br/>";

	$content = '<div class="dv_renderto_subtypes">';

	$content .= elgg_view('input/checkboxes',array(
										'name'=>'to_subtypes',
										'value'=> array_filter(explode(',', $vars["entity"]->renderto_subtypes)),
										'options'=>$valid_types,
										'default' => false));
	$content .= '</div>';
	$content .= elgg_view('input/hidden',array(
											'id'=>'in_renderto_subtypes',
											'class'=>'in_renderto_subtypes',
											'name'=>'params[renderto_subtypes]',
											'value'=> $vars["entity"]->renderto_subtypes)
					);
	echo $content;
	echo "<br/><h3>";
	echo elgg_echo ('related-items:display-options');
	echo "</h3><br/>";
	echo elgg_echo('related-items:show_names') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_names]',
                        'value' => $vars['entity']->show_names,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";
	echo elgg_echo('related-items:show_dates') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_dates]',
                        'value' => $vars['entity']->show_dates,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";
    echo elgg_echo('related-items:show_timestamps') . ' ';
    echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_timestamps]',
                        'value' => $vars['entity']->timestamps,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
    echo "<br/>";
	echo elgg_echo('related-items:show_tags') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_tags]',
                        'value' => $vars['entity']->show_tags,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";
	echo elgg_echo('related-items:show_types') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_types]',
                        'value' => $vars['entity']->show_types,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";
	echo elgg_echo('related-items:show_icons') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_icons]',
                        'value' => $vars['entity']->show_icons,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";
	echo elgg_echo('related-items:column_count') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[column_count]',
                        'value' => $vars['entity']->column_count,
                        'options_values' => array(
                                '4' => '4',
                                '3' => '3',
                                '2' => '2',
                                '1' => '1',
                        ),
                ));
	echo "<br/>";
	echo elgg_echo('related-items:media_query') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[media_query]',
                        'value' => $vars['entity']->media_query,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));

    echo "<br/>";
    echo elgg_echo('related-items:comment_position') . ' ';
    echo elgg_view('input/dropdown', array(
                        'name' => 'params[comment_position]',
                        'value' => $vars['entity']->comment_position,
                        'options_values' => array(
                                'top' => elgg_echo('related-items:option:top'),
                                'bottom' => elgg_echo('related-items:option:bottom'),
                        ),
                ));

?>
</div>
