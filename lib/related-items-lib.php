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
                $subtypes[$subtype] = $subtype;
        }
        return $subtypes;
    }
}
function get_related_entities($thisitem)
{
	$limit_by_date = elgg_get_plugin_setting('limit_by_date','related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period','related-items');	
	$created_time_lower = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
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

	$this_items_tags = $thisitem->tags;
  	if (isset($this_items_tags)) //if the current item has tags
  	{
  		if (is_array($this_items_tags)) //if the current item has more than 1 tag
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
			'wheres' => array('guid <> ' . $thisitem->getGUID()) // exclude this item from list.
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
		    	if ($item instanceof ElggObject){ 
					$matched_tags = array();
			    	$itemtags = $item->tags;
			    	if (is_array($itemtags))
					{
						$itemtags =  array_unique($itemtags); // ensure unique tags
					}
					else {
						$itemtags = array($itemtags);
					}
					if ($match_tags == 'yes') // if the search is limited to an amount of tags per entity to match
					{
						$i = 0;
						while (($i <= ($match_tags_int -1))&&($i <= (count($itemtags)-1)))
					    {
					    		if ((in_arrayi($itemtags[$i], $this_items_tags)))
					    		{
									$matched_tags[] = $itemtags[$i];
					      		}
								$i++;
					    }
					}
					else  // if the search is unlimited by any amount of tags per entity
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
				}
		    } // end loop of examining items
	      $related_items = subval_sort($related_items,'similarity',arsort);
		  return $related_items;
	      }
		  else {
		   return false;
		  }
	 }
}

function delete_col(&$array, $offset) {
    return array_walk($array, function (&$v) use ($offset) {
        array_splice($v, $offset, 1);
    });
}

function related_items_page_handler($page) {
	  $entity = get_entity($page[0]);
	  if ($entity instanceof ElggObject){
	  elgg_set_page_owner_guid($entity->guid);
	  $subtype = $entity->getSubtype();
	  $container = $entity->getContainerEntity();
	  $crumbs_title = $container->name;
	  //elgg_push_breadcrumb(elgg_echo($subtype . ':' . $subtype . 's'), $subtype . "/all");
	  if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, $subtype . "/group/$container->guid/all");
	  } else {
		elgg_push_breadcrumb($crumbs_title,  $subtype . "/owner/$container->username");
	  }
	  elgg_push_breadcrumb(elgg_get_excerpt($entity->title, 75), $entity->getURL());
	  elgg_push_breadcrumb(elgg_echo('related-items:title'));
	  
	  $related_entities = get_related_entities($entity);

	  if ($related_entities){
	  	$entity_list = array();	  
		  foreach ($related_entities as $related_entity){
		  	$entity_list[] = $related_entity['item'];
		  }
	  	$title = elgg_echo('related-items:title');
		$offset = (int) max(get_input('offset', 0), 0);
		$length = 10;
		$content = elgg_view_entity_list(array_slice($entity_list,$offset,$length),array(
			'count' => count($entity_list),
			'full_view' => false,
			'list_type' => 'list',
			'pagination' => true),$offset, $length);
	  }
	  else {
	  	$title = elgg_echo('related-items:title');
		$content = elgg_echo('related-items:none');
	  }
	  
	  
	  $layout = elgg_view_layout('content', array(
		  'title' => elgg_view_title($title),
		  'content' => $content,
		  'filter' => false,
	  ));
	  
	  echo elgg_view_page($title, $layout);
	  return true;
	  }
	  else  
  		return false;
}

	
?>