<?php
/**
 * related items English language file
 */

$english = array(
	'related-items:title' => 'Related items',
	'related-items:item-select-options' => 'Options for selection of related items',
	'related-items:limit-date' => 'Show only items created between now and a specific timing period?<br/>(timing format is: <i>negative number</i> followed by <i>time interval</i> e.g. day/week/month/year): ',
	'related-items:current-owner' => 'Owner of current item',
	'related-items:selectfrom-group' => 'Show only related items from the same group if current item is within a group?: ',
	'related-items:selectfrom-owner' => 'Show related items from all users or just from the owner of the current item?: ',
	'related-items:select_from_thissubtype' => 'Show <b>only</b> related items with the same subtype as the current item?: ',	
	'related-items:selectfrom-subtypes' => 'Matching related items will be <b>selected from</b> the following highlighted entity subtypes:<br/>(all subtypes in the system are shown - only subtypes that receive/store comments or discussion replies will be used - others that you check here will be ignored)',
	'related-items:renderto-subtypes' => 'Matching related items will be rendered <b>only on pages for</b> the following highlighted entity subtypes:<br/>(all subtypes in the system are shown - only subtypes that receive/store comments or discussion replies will be used - others that you check here will be ignored)',	
	'related-items:max_tags_to_match' => 'Set a maximum limit to the number of tags to match?: ',
	'related-items:show_names' => 'Display the uploader name for each related item?: ',
	'related-items:show_dates' => 'Display the creation date for each related item?: ',
	'related-items:show_tags' => 'Display the list of tags that match for each related item?: ',
	'related-items:display-options' => 'Options for display of related item list',
	'related-items:max_items' => 'Maximum number of related items to show: ',
	'related-items:column_count' => 'How many columns to split the grid into?: ',
	'related-items:jquery_height' => 'Use jquery to set all boxes the same height?: ',
	'related-items:none' => 'No related items were found',
	'related-items:view-all' => 'View all related items',	
);
					
add_translation("en", $english);
