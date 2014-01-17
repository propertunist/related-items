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
function get_related_entities($thisitem, $list_count, $count = false, $offset)
{
	$limit_by_date = elgg_get_plugin_setting('limit_by_date','related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period','related-items');	
	$created_time_lower = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner','related-items');
	$selectfrom_thissubtype = elgg_get_plugin_setting('select_from_this_subtype','related-items');
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
  	if ($this_items_tags) //if the current item has tags
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
			'wheres' => array('e.guid <> ' . $thisitem->getGUID()), // exclude this item from list.
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
	  elgg_set_page_owner_guid($entity->getContainerGUID());
	  $subtype = $entity->getSubtype();
	  $container = $entity->getContainerEntity();
	  $owner = elgg_get_page_owner_entity();
	  switch ($subtype)
	  {
	  	case 'image':
			elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
			elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
			$subtype = 'photos';
			break;
		case 'page_top':
			elgg_push_breadcrumb(elgg_echo('pages'), 'pages/all');
			$subtype = 'pages';
			break;
		case 'videolist_item':
			elgg_push_breadcrumb(elgg_echo('videolist'), 'videolist/all');
			$subtype = 'videolist';
			break;		
		case 'bookmarks':
			elgg_push_breadcrumb(elgg_echo('bookmarks'), 'bookmarks/all');
			break;
		case 'file':
			elgg_push_breadcrumb(elgg_echo('file'), 'file/all');
			break;	
		case 'blog':
			elgg_push_breadcrumb(elgg_echo('blog:blogs'), 'blog/all');
			break;	
		case 'au_set':
			elgg_push_breadcrumb(elgg_echo('au_set'), 'pinboards/all');
			break;
		default: break;
	  }

	  if (elgg_instanceof($container, 'group')) { //container
		elgg_push_breadcrumb($owner->name, $subtype . "/group/$owner->guid/all");
	  } else {
		elgg_push_breadcrumb($owner->name,  $subtype . "/owner/$owner->username");
	  } 
	  if ($subtype == 'photos'){ // album
			elgg_push_breadcrumb($container->getTitle(), $container->getURL());
	  }

	  elgg_push_breadcrumb(elgg_get_excerpt($entity->title, 75), $entity->getURL()); // item
	  elgg_push_breadcrumb(elgg_echo('related-items:title'));
	  $offset = (integer) max(get_input('offset', 0), 0);
	  $limit = 10;
	  $entity_list = get_related_entities($entity, $limit, false, $offset);

	  if ($entity_list){
	  	$title = elgg_echo('related-items:title');
		$content = elgg_view_entity_list($entity_list,array(
			'count' => get_related_entities($entity, 0,true,0),
			'full_view' => false,
			'list_type' => 'list',
			'pagination' => true),$offset, $limit);
	  }
	  else {
	  	$title = elgg_echo('related-items:title');
		$content = elgg_echo('related-items:none');
	  }
	  
	  $layout = elgg_view_layout('content', array(
		  'title' => $title,
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