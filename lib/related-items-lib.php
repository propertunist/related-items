<?php
use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\OrderByClause;

function type_not_allowed() {
	return [
		'thewire',
		'comment',
		'plugin',
		'elgg_upgrade',
		'widget',
		'user',
		'group',
		'site'
	];
}

function get_valid_types() {
	$invalid_types = type_not_allowed();
	$registered_entities = elgg_get_entity_statistics();
	$subtypes = [];
	foreach ($registered_entities['object'] as $subtype => $counter) {
		if (!in_array($subtype, $invalid_types)) {
			$subtypes[$subtype] = elgg_echo('item:object:' . $subtype);
		}
	}
	return $subtypes;
}

function get_related_entities($thisitem, $list_count, $count = false, $offset = 0) {
	$options = [];
	$select_related = elgg_get_plugin_setting('select_related', 'related-items');
	$limit_by_date = elgg_get_plugin_setting('limit_by_date', 'related-items');
	$related_date_period = elgg_get_plugin_setting('related_date_period', 'related-items');
	$created_after = strtotime($related_date_period) ? strtotime($related_date_period) : strtotime('-1 year');
	$selectfrom_owner = elgg_get_plugin_setting('selectfrom_owner', 'related-items');
	$selectfrom_thissubtype = elgg_get_plugin_setting('select_from_this_subtype', 'related-items');
	$dbprefix = elgg_get_config('dbprefix');
	if ($selectfrom_thissubtype === 'no') {
		$selectfrom_subtypes = array_filter(explode(',', elgg_get_plugin_setting('selectfrom_subtypes', 'related-items')));
	} else {
		$selectfrom_subtypes = $thisitem->getSubtype();
	}
	if ($select_related === 'related') {
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
		$options['created_after'] = $created_after;
	}
	if ($selectfrom_owner <> 'all') {
		$options['owner_guids'] = $thisitem->getOwner();
	}
	if ($options) {
		$items = elgg_get_entities($options); //get list of  entities
	} else {
		return false;
	}

	if (is_array($items)) {
		 return count($items) > 0 ? $items : false;
	} else {
		return false;
	}
}
