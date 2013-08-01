<?php

function in_arrayi($needle, $haystack)
{
    for($h = 0 ; $h < count($haystack) ; $h++)
    {
        $haystack[$h] = strtolower($haystack[$h]);
    }
    return in_array(strtolower($needle),$haystack);
}

function subval_sort($a,$subkey,$sort) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	$sort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

if (!function_exists('get_valid_types'))
{
    function get_valid_types($invalid_types) { // return object entity types in the system
        $registered_entities = elgg_get_config('registered_entities');
        $subtypes = array();
        foreach ($registered_entities['object'] as $subtype) {
            if (!in_array($subtype,$invalid_types))
                $subtypes[] = $subtype;
        }
        return $subtypes;
    }
}

function get_related_entities($thisitem)
{
	$limit_by_date = elgg_get_plugin_setting('limit_by_date','related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period','related-items');	
	$created_time_lower = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
	$show_names = elgg_get_plugin_setting('show_names','related-items');
	$show_dates = elgg_get_plugin_setting('show_dates','related-items');
	$show_tags = elgg_get_plugin_setting('show_tags','related-items');
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner','related-items');
	$selectfrom_thissubtype = elgg_get_plugin_setting('selectfrom_thissubtype','related-items');
	if ($selectfrom_thissubtype == 'no')
	{
	    $selectfrom_subtypes = array_filter(explode(',', elgg_get_plugin_setting('selectfrom_subtypes','related-items')));
	}
	else
	{
		$selectfrom_subtypes = $thisitem->getSubtype();	
	}
	$match_tags = elgg_get_plugin_setting('match_tags','related-items');	
	$match_tags_int = elgg_get_plugin_setting('match_tags_int','related-items');
	$max_related_items = elgg_get_plugin_setting('max_items','related-items');	
	$column_count = elgg_get_plugin_setting('column_count','related-items');
	$jquery_height = elgg_get_plugin_setting('jquery_height','related-items');
	$this_items_tags = $thisitem->tags;

  	if (isset($this_items_tags)) //if the current item has tags
  	{
  		if (count($this_items_tags) > 1) //if the current item has more than 1 tag
		{	
			$this_items_tags = array_unique($this_items_tags); // create unique list
		}
		else {
			$this_items_tags = array($this_items_tags);
		}
		$options = array(
	    	'type' => 'object', 
	    	'subtypes' => $selectfrom_subtypes,
	    	'limit' => 0,
	    	'metadata_names' => 'tags',
	    	'metadata_values' => $this_items_tags,
			'wheres' => array('guid <> ' . $thisitem->getGUID() // exclude this item from list.
		)
	);
	
	if ($limit_by_date == 'yes')
		$options['created_time_lower'] = $created_time_lower;
	if ($selectfrom_owner <> 'all')
		$options['owner_guids'] = $thisitem->getOwner();		
    $items = elgg_get_entities_from_metadata($options); //get list of  entities
  //  elgg_dump('count of related items a : ' . count($items));
    if(count($items,0) > 0)
    {
	    foreach($items as $item) // loop all returned items
	    {
			$matched_tags = array();
	    	$itemtags = $item->tags;
	    	if (count($itemtags) > 1)
			{
				$itemtags =  array_unique($itemtags); // ensure unique tags
			}
			else {
				$itemtags = array($itemtags);
			}

			if ($match_tags == 'yes')
			{
			    foreach($itemtags as $itemtag)
			    {
			    	if (count($matched_tags) <= $match_tags_int)
					{
			    		if ((in_arrayi($itemtag, $this_items_tags)))
			    		{
							$matched_tags[] = $itemtag;
			      		}
					}
					else
						break;
			    }
			}
			else 
			{
				 foreach($itemtags as $itemtag)
				 {
			   		if ((in_arrayi($itemtag, $this_items_tags)))
			   		{
						$matched_tags[] = $itemtag;
			   		}
				 }
			}
			$related_items[] = array('similarity' => count($matched_tags), 'item' => $item, 'matched_tags' => $matched_tags);	    
			//elgg_dump('count of related items b : ' . count($related_items) . '; matched_tags: ' . count($matched_tags));
	    } // end loop of examining items
	
	      $related_items = subval_sort($related_items,'similarity',arsort);
		  
		  switch($column_count) // this can be moved to a plugin variable
		  {
		  	case 1: {$box_width = 97;break;}
			case 2: {$box_width = 47;break;}
			case 3: {$box_width = 30;break;}
			default: {$box_width = 22;break;}
		  }
		  if ($jquery_height == 'yes')
	      	echo "<script type=\"text/javascript\" >
	      	$(document).ready(function(){
	      		var maxHeight = 0;
	      		var set_height = function(column) {
	      			column = $(column);
	      			column.each(function(){
	      				if($(this).height() > maxHeight){
	      					maxHeight = $(this).height();
	      				}
	      			});
	      			column.height(maxHeight);
	      		}
	      		set_height('.elgg-related-items-col');
	      		});      		$(window).resize(set_height('.elgg-related-items-col'));
	      	</script>";
		  echo '<div class="elgg-related-items">';
	      echo "<div class='elgg-related-items-title'>" . elgg_echo('related-items:title') . "</div><div class='elgg-related-items-title-icon'></div>";
	      echo '<ul class="elgg-related-items-list">';
		  $i = 1;
		  while ($i <= $max_related_items)
	      {
			$thisitem = $related_items[$i]['item'];
			if ($thisitem instanceof ElggObject) // ensure the item is not a group or other object type
			{
				$owner = $thisitem->getOwnerEntity();
				$this_subtype = $thisitem->getsubtype();
				echo '<li class="elgg-related-item elgg-related-' . $this_subtype . '"style="width:' . $box_width . '%;" onclick="window.location.href=\''. $thisitem->getURL() . '\';">';
				echo "<div class='elgg-related-items-col'>";
		
				switch($this_subtype)
				{
					case 'image':
						$item_guid = $thisitem->getGUID();
						$title = $thisitem->getTitle();
						$icon = "<img src='" . elgg_get_site_url() . "photos/thumbnail/" . $item_guid . "/thumb/' alt='" . $title . "'/>";	
						break;
					case 'videolist_item':
					case 'izap_videos':
					case 'file':
						$icon = elgg_view_entity_icon($thisitem, 'small'); break;
					default: 			break;
				}
				$css_tag = $this_subtype;
				if (!empty($icon))
					$css_tag .= '-gfx';
				else
				{
					$icon ="&nbsp;" ;	
				}
		
				$div = "<div class='elgg-related-item-icon elgg-related-" . $css_tag . "-icon'>";
				$div .= $icon;
				$div .= "</div>";
				echo $div;
				$icon = null;
				echo "<a href='{$thisitem->getURL()}'>" . elgg_get_excerpt($thisitem->title, 100) . "</a>";
				if($show_dates =='yes')				 
					echo "<br/><small>" . elgg_view_friendly_time($thisitem->time_created) . "</small>";
				if($show_names =='yes')
					echo "<br/><small>" . $owner->name . "</small>";
				if($show_tags =='yes')
					$related_item_tags = elgg_view('output/tags',array('value'=>$related_items[$i]['matched_tags']));
				echo "<br/><small>" . $related_item_tags . "</small>";
				echo "</div></li>";
			}
			$i++;
		  }
	      echo '</ul></div>';
	    }
	}  
}
?>