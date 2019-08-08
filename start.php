<?php

/* ***********************************************************************
 * related-items - elgg plugin
 *
*******************************************/

function related_items_init() {
	require_once __DIR__ . '/lib/related-items-lib.php';
	$comment_position = elgg_get_plugin_setting('comment_position', 'related-items');
	switch ($comment_position) {
		case 'bottom':
		{
			$comment_position = 501;
			break;
		}
		default:
		case 'top':
		{
			$comment_position = 0;
			break;
		}
	}

		// elgg_register_page_handler('related', 'related_items_page_handler');

	if ((!elgg_in_context('katalists'))&&(!elgg_in_context('pinboards'))) {
		elgg_extend_view('page/elements/comments', 'related-items/related-items', $comment_position);
		elgg_extend_view('discussion/replies', 'related-items/related-items', 0);
	}
		elgg_extend_view('admin.css', 'related-items/admin', 1);
		elgg_extend_view('elgg.css', 'related-items/css');
}

elgg_register_event_handler('init', 'system', 'related_items_init');
