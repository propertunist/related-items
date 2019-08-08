<?php
use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\OrderByClause;

/* function: get_related_entities
 * 
 * inputs:  $thisitem (object entity) = the entity for which related entities will be retrieved
 *          $list_count (int) = size of list to be retrieved
 *          $count (bool) = return a count of the list or not
 *          $offset (int) = the offset position from which the returned list will begin
 * 
 * returns: array of entities that are related to the inputted entity by similarity of keyword tags
 * 
 * author: ura soul
 */

if (!function_exists('get_valid_types')) {
	function get_valid_types($invalid_types) {
 // return object entity types in the system
		$registered_entities = elgg_get_config('registered_entities');
		$subtypes = [];
		foreach ($registered_entities['object'] as $subtype) {
			if ($subtype == 'page') {
				if (!in_array('page_top', $invalid_types)) {
					 $nice_name = get_nice_name_for_subtype('page_top');
					 $subtypes[$nice_name] = 'page_top';
				}
			}

			if (!in_array($subtype, $invalid_types)) {
				$nice_name = get_nice_name_for_subtype($subtype);
				$subtypes[$nice_name] = $subtype;
			}
		}
		return $subtypes;
	}
}

if (!function_exists('get_nice_name_for_subtype')) {
	function get_nice_name_for_subtype($subtype) {
		switch ($subtype) {
			case 'image':
			case 'album':
			case 'au_set':
			case 'page_top':
			case 'pages':
			case 'bookmarks':
			case 'videolist_item':
			{
				$type_label = elgg_echo ($subtype);
				break;
			}
			case 'file':
			{
				$type_label = elgg_echo ($subtype . ':' . $subtype);
				break;
			}
			default:
			{
				$type_label = elgg_echo('item:object:' . $subtype);
				break;
			}
		}
		return $type_label;
	}
}

function get_related_entities($thisitem, $list_count, $count = false, $offset) {
	$select_related = elgg_get_plugin_setting('select_related', 'related-items');
	$limit_by_date = elgg_get_plugin_setting('limit_by_date', 'related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period', 'related-items');
	$created_time_lower = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner', 'related-items');
	$selectfrom_thissubtype = elgg_get_plugin_setting('select_from_this_subtype', 'related-items');
	$dbprefix = elgg_get_config('dbprefix');
	if ($selectfrom_thissubtype === 'no') {
		$selectfrom_subtypes = array_filter(explode(',', elgg_get_plugin_setting('selectfrom_subtypes', 'related-items')));
	} else {
		$selectfrom_subtypes = $thisitem->getSubtype();
	}
	if ($select_related === 'related') {
		$match_tags = elgg_get_plugin_setting('match_tags', 'related-items');
		$match_tags_int = elgg_get_plugin_setting('match_tags_int', 'related-items');

		$this_items_tags = $thisitem->tags;
		if ($this_items_tags) { //if the current item has tags
			if (is_array($this_items_tags)) { //if the current item has more than 1 tag
				$this_items_tags = array_unique($this_items_tags); // create unique list
			} else {
				$this_items_tags = [$this_items_tags];
			}
			$options = [
			  'type' => 'object',
			  'subtypes' => $selectfrom_subtypes,
			  'order_by' => [
				  new OrderByClause('match_count', 'DESC'),
				  new OrderByClause('e.time_created', 'DESC'),
					  ],
			  'group_by' => 'e.guid',
				  'limit' => $list_count,
				  'offset' => $offset,
				  'count' => $count,
				  'metadata_names' => 'tags',
				  'metadata_case_sensitive' => false,
				  'metadata_values' => $this_items_tags,
				  'selects' => ['count(*) as match_count'],
			  'wheres' => [
					function(QueryBuilder $qb) use ($thisitem) {
							  return $qb->compare('e.guid', '<>', $thisitem->getGUID()); // exclude this item from list.
					},
				  ],
			];
		}
	} else {
		$options = [
			'type' => 'object',
			'subtypes' => $selectfrom_subtypes,
			'group_by' => 'e.guid',
			'limit' => $list_count,
			'offset' => $offset,
			'count' => $count,
			'wheres' => [
				function(QueryBuilder $qb) use ($thisitem) {
					return $qb->compare('e.guid', '<>', $thisitem->getGUID()); // exclude this item from list.
				},
			  ],
		];
	}

	if ($limit_by_date === 'yes') {
		$options['created_time_lower'] = $created_time_lower;
	}
	if ($selectfrom_owner <> 'all') {
		$options['owner_guids'] = $thisitem->getOwner();
	}
	if ($options) {
		$items = elgg_get_entities($options); //get list of  entities
	} else {
		return false;
	}

	if (count($items, 0) > 0) {
		 return $items;
	} else {
		return false;
	}
}
