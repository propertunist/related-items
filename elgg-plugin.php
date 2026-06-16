<?php
require_once __DIR__ . '/lib/related-items-lib.php';

return [
	'plugin' => [
		'name' => 'Related Items',
		'version' => '7.0',
	],
	'routes' => [
		'collection:object:related' => [
			'path' => '/related/{guid}',
			'resource' => 'related/default',
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'related-items/css' => [],
		],
		'page/elements/comments' => [
			'related-items/related-items' => [
				'priority' => elgg_get_plugin_setting('comment_position', 'related-items') == 'bottom' ? 501 : 0,
			],
		],
		'discussion/replies' => [
			'related-items/related-items' => [
				'priority' => elgg_get_plugin_setting('comment_position', 'related-items') == 'bottom' ? 501 : 0,
			],
		],
	],
	'events' => [
		"action:validate" => [
			"plugins/settings/save" => [
				'\RelatedItems\Events::PluginSettingSave' => [],
			],
		],
	],
];
