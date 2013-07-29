<?php

/* ***********************************************************************
 * related-items - elgg plugin
 * 
*******************************************/

function related_items_init()
{
	$lib = elgg_get_plugins_path() . 'related-items/lib/related-items-lib.php';
	elgg_register_library('related-items-lib', $lib);
	elgg_load_library('related-items-lib');
	
   	elgg_extend_view('page/elements/comments', 'related-items/related-items', 0);
	elgg_extend_view('discussion/replies', 'related-items/related-items', 0);
	elgg_extend_view('css/admin', 'related-items/admin', 1);	
	elgg_extend_view('css/elgg', 'related-items/css');
}

elgg_register_event_handler('init', 'system', 'related_items_init');
?>