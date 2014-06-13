<div class="related-items-panel">
<?php 
    $select_related = elgg_get_plugin_setting('select_related','related-items');
    if (!$select_related) {
        $select_related = 'related';
        elgg_set_plugin_setting('select_related',$select_related,'related-items');
    }   
	$limit_by_date = elgg_get_plugin_setting('limit_by_date','related-items');
	if (!$limit_by_date) {
		$limit_by_date = 'no';
		elgg_set_plugin_setting('limit_by_date',$limit_by_date,'related-items');
	}	
	$related_date_period = elgg_get_plugin_setting('related_date_period','related-items');
	if (!$related_date_period) {
		$related_date_period = '-1 year';
		elgg_set_plugin_setting('related_date_period',$related_date_period,'related-items');
	}	
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner','related-items');
	if (!$selectfrom_owner) {
		$selectfrom_owner = 'all';
		elgg_set_plugin_setting('selectfrom_owner',$selectfrom_owner,'related-items');
	}	
/*	$selectfrom_group = elgg_get_plugin_setting('selectfrom_group','related-items');
	if (!$selectfrom_group) {
		$selectfrom_group = 'yes';
		elgg_set_plugin_setting('selectfrom_group',$selectfrom_group,'related-items');
	}	 */
	$selectfrom_subtypes = elgg_get_plugin_setting('selectfrom_subtypes','related-items');
	if (!$selectfrom_subtypes) {
		$selectfrom_subtypes = array();
		elgg_set_plugin_setting('selectfrom_subtypes',$selectfrom_subtypes,'related-items');
	}	
	$select_from_this_subtype = elgg_get_plugin_setting('select_from_this_subtype','related-items');
	if (!$select_from_this_subtype) {
		$select_from_this_subtype = 'no';
		elgg_set_plugin_setting('select_from_this_subtype',$select_from_this_subtype,'related-items');
	}		
	$renderto_subtypes = elgg_get_plugin_setting('renderto_subtypes','related-items');
	if (!$renderto_subtypes) {
		$renderto_subtypes = array();
		elgg_set_plugin_setting('renderto_subtypes',$renderto_subtypes,'related-items');
	}	
	$show_names = elgg_get_plugin_setting('show_names','related-items');
	if (!$show_names) {
		$show_names = 'yes';
		elgg_set_plugin_setting('show_names',$show_names,'related-items');
	}	
	$show_dates = elgg_get_plugin_setting('show_dates','related-items');
	if (!$show_dates) {
		$show_dates = 'yes';
		elgg_set_plugin_setting('show_dates',$show_dates,'related-items');
	}	
    $show_timestamps = elgg_get_plugin_setting('show_timestamps','related-items');
    if (!$show_timestamps) {
        $show_timestamps = 'no';
        elgg_set_plugin_setting('show_timestamps',$show_timestamps,'related-items');
    }       
	$show_tags = elgg_get_plugin_setting('show_tags','related-items');
	if (!$show_tags) {
		$show_tags = 'yes';
		elgg_set_plugin_setting('show_tags',$show_tags,'related-items');
	}	
	$show_types = elgg_get_plugin_setting('show_types','related-items');
	if (!$show_types) {
		$show_types = 'yes';
		elgg_set_plugin_setting('show_types',$show_types,'related-items');
	}	
	$show_icons = elgg_get_plugin_setting('show_icons','related-items');
	if (!$show_icons) {
		$show_icons = 'yes';
		elgg_set_plugin_setting('show_icons',$show_icons,'related-items');
	}	
/*	$match_tags = elgg_get_plugin_setting('match_tags','related-items');
	if (!$match_tags) {
		$match_tags = 'no';
		elgg_set_plugin_setting('match_tags',$match_tags,'related-items');
	}	
	$match_tags_int = elgg_get_plugin_setting('match_tags_int','related-items');
	if (!$match_tags_int) {
		$match_tags_int = 1;
		elgg_set_plugin_setting('match_tags_int',$match_tags_int,'related-items');
	}
 */	
	$max_items = elgg_get_plugin_setting('max_items','related-items');
	if (!$max_items) {
		$max_items = 8;
		elgg_set_plugin_setting('max_items',$max_items,'related-items');
	}	
	$column_count = elgg_get_plugin_setting('column_count','related-items');
	if (!$column_count) {
		$column_count = 4;
		elgg_set_plugin_setting('column_count',$column_count,'related-items');
	}	
	$jquery_height = elgg_get_plugin_setting('jquery_height','related-items');
	if (!$column_count) {
		$column_count = 'yes';
		elgg_set_plugin_setting('jquery_height',$jquery_height,'related-items');
	}	

    $comment_position = elgg_get_plugin_setting('comment_position','related-items');
    if (!$comment_position) {
        $comment_position = 'top';
        elgg_set_plugin_setting('comment_position',$comment_position,'related-items');
    }       
    
	echo "<h3>";
	echo elgg_echo('related-items:item-select-options');
	echo "</h3><br/>";
    
    echo elgg_echo('related-items:select-related') . ' ';
    echo elgg_view('input/dropdown', array(
                        'name' => 'params[select_related]',
                        'value' => $select_related,
                        'options_values' => array(
                                'related' => elgg_echo('related-items:title'),
                                'more' => elgg_echo('related-items:more-items'),
                        ),
                ));    
    echo "<br /><br/>";
	echo elgg_echo('related-items:limit-date') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[limit_by_date]',
                        'value' => $limit_by_date,
                        'options_values' => array(
                                'no' => elgg_echo('option:no'),
                                'yes' => elgg_echo('option:yes'),
                        ),
                ));
	echo elgg_view('input/text', array('name'=>'params[related_date_period]', 'value'=>$related_date_period));
	echo "<br /><br/>";
	echo elgg_echo('related-items:selectfrom-owner') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[selectfrom_owner]',
                        'value' => $selectfrom_owner,
                        'options_values' => array(
                                'all' => elgg_echo('all'),
                                'current' => elgg_echo('related-items:current-owner'),
                        ),
                ));
	echo "<br/><br/>";
	/*
	echo elgg_echo('related-items:selectfrom-group');
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[selectfrom_group]',
                        'value' => $selectfrom_group,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/><br/>";	
	echo elgg_echo('related-items:max_tags_to_match') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[match_tags]',
                        'value' => $match_tags,
                        'options_values' => array(
                                'no' => elgg_echo('option:no'),
                                'yes' => elgg_echo('option:yes'),                                
                        ),
                ));
	echo elgg_view('input/text', array('name'=>'params[match_tags_int]', 'value'=>$match_tags_int));
	echo "<br/><br/>"; */	
	echo elgg_echo('related-items:max_items') . ' ';
	echo elgg_view('input/text', array('name'=>'params[max_items]', 'value'=>$max_items));
	echo "<br/><br/>";
	echo elgg_echo('related-items:select_from_thissubtype') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[select_from_this_subtype]',
                        'value' => $select_from_this_subtype,
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

   // $vars["entity"]->selectfrom_subtypes = $checked_subtypes;
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

	$active_to_subtypes = array_filter(explode(',', $vars["entity"]->renderto_subtypes));
	$content .= elgg_view('input/checkboxes',array(
										'name'=>'to_subtypes',
										'value'=>$active_to_subtypes,
										'options'=>$valid_types,
										'default' => false));
	$content .= '</div>';
	$content .= elgg_view('input/hidden',array(	
											'id'=>'in_renderto_subtypes',
											'class'=>'in_renderto_subtypes',
											'name'=>'params[renderto_subtypes]',
											'value'=>$vars["entity"]->renderto_subtypes)
					);
	echo $content;
	echo "<br/><h3>";
	echo elgg_echo ('related-items:display-options');
	echo "</h3><br/>";
	echo elgg_echo('related-items:show_names') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_names]',
                        'value' => $show_names,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";
	echo elgg_echo('related-items:show_dates') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_dates]',
                        'value' => $show_dates,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));	
	echo "<br/>";	
    echo elgg_echo('related-items:show_timestamps') . ' ';
    echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_timestamps]',
                        'value' => $timestamps,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                )); 
    echo "<br/>";       			
	echo elgg_echo('related-items:show_tags') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_tags]',
                        'value' => $show_tags,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";		
	echo elgg_echo('related-items:show_types') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_types]',
                        'value' => $show_types,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";	
	echo elgg_echo('related-items:show_icons') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[show_icons]',
                        'value' => $show_icons,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),
                        ),
                ));
	echo "<br/>";		
	echo elgg_echo('related-items:column_count') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[column_count]',
                        'value' => $column_count,
                        'options_values' => array(
                                '4' => 4,
                                '3' => 3,
                                '2' => 2,
                                '1' => 1,                                
                        ),
                ));		
	echo "<br/>";				
	echo elgg_echo('related-items:jquery_height') . ' ';
	echo elgg_view('input/dropdown', array(
                        'name' => 'params[jquery_height]',
                        'value' => $jquery_height,
                        'options_values' => array(
                                'yes' => elgg_echo('option:yes'),
                                'no' => elgg_echo('option:no'),                         
                        ),
                ));		
                
    echo "<br/>";               
    echo elgg_echo('related-items:comment_position') . ' ';
    echo elgg_view('input/dropdown', array(
                        'name' => 'params[comment_position]',
                        'value' => $comment_position,
                        'options_values' => array(
                                'top' => elgg_echo('related-items:option:top'),
                                'bottom' => elgg_echo('related-items:option:bottom'),                         
                        ),
                ));                 
                
?>	
</div>
<script type="text/javascript">

	$(document).ready(function(){
		
		// each time you click a checkbox to update; loops through all the hidden
		$('.dv_selectfrom_subtypes input[type=checkbox]').click(function(){
			
			$('#in_selectfrom_subtypes').val("");
			$('.dv_selectfrom_subtypes input[type=checkbox]').each(function(){
				if ( $(this).is(':checked') ){
					// ugly hack to not render the first comma
					if ( $('#in_selectfrom_subtypes').val() == ""){
						$('#in_selectfrom_subtypes').val( $(this).val() );
					}else{
						$('#in_selectfrom_subtypes').val( $('#in_selectfrom_subtypes').val() + ',' + $(this).val() );
					}
				}
			});
		});	
		$('.dv_renderto_subtypes input[type=checkbox]').click(function(){
			
			$('#in_renderto_subtypes').val("");
			$('.dv_renderto_subtypes input[type=checkbox]').each(function(){
				if ( $(this).is(':checked') ){
					// ugly hack to not render the first comma
					if ( $('#in_renderto_subtypes').val() == ""){
						$('#in_renderto_subtypes').val( $(this).val() );
					}else{
						$('#in_renderto_subtypes').val( $('#in_renderto_subtypes').val() + ',' + $(this).val() );
					}
				}
			});
		});	
	});
</script>