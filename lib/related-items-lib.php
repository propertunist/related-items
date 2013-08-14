<?php
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
function get_related_entities($thisitem, int $list_count, $count = false, int $offset)
{
	$limit_by_date = elgg_get_plugin_setting('limit_by_date','related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period','related-items');	
	$created_time_lower = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner','related-items');
	$selectfrom_thissubtype = elgg_get_plugin_setting('selectfrom_thissubtype','related-items');
	$dbprefix = elgg_get_config('dbprefix');
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
	    	'order_by' => 'match_count DESC',
			'group_by' => 'e.guid',
	    	'limit' => $list_count,
	    	'offset' => $offset,
	    	'count' => $count,
	    	'metadata_names' => 'tags',
	    	'metadata_case_sensitive' => FALSE,
	    	'metadata_values' => $this_items_tags,
	    	'selects' => array('count(msv.string) as match_count'),
			'wheres' => array('guid <> ' . $thisitem->getGUID()), // exclude this item from list.
		);

		if ($limit_by_date == 'yes')
			$options['created_time_lower'] = $created_time_lower;
		if ($selectfrom_owner <> 'all')
			$options['owner_guids'] = $thisitem->getOwner();		
	    $items = elgg_get_entities_from_metadata($options); //get list of  entities
	    //elgg_dump('count of related items a : ' . count($items));
	  
	    if(count($items,0) > 0)
			 return $items;
		else 
		   return false;
	 }
}

function related_items_page_handler($page) {
	  $entity = get_entity($page[0]);
	  if ($entity instanceof ElggObject){
	  elgg_set_page_owner_guid($entity->guid);
	  $subtype = $entity->getSubtype();
	  $container = $entity->getContainerEntity();
	  $crumbs_title = $container->name;
	  if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, $subtype . "/group/$container->guid/all");
	  } else {
		elgg_push_breadcrumb($crumbs_title,  $subtype . "/owner/$container->username");
	  }
	  elgg_push_breadcrumb(elgg_get_excerpt($entity->title, 75), $entity->getURL());
	  elgg_push_breadcrumb(elgg_echo('related-items:title'));
	  $offset = (int) max(get_input('offset', 0), 0);
	  $limit = 10;
	  $entity_list = get_related_entities($entity, $limit, false, $offset);

	  if ($entity_list){
	  	$title = elgg_echo('related-items:title');
		$content = elgg_view_entity_list($entity_list,array(
			'count' => get_related_entities($entity, 0,true),
			'full_view' => false,
			'list_type' => 'list',
			'pagination' => true),$offset, $limit);
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