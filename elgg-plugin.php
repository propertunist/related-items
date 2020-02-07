<?php
require_once __DIR__ . '/lib/related-items-lib.php';

return [
	'bootstrap' => RelatedItems::class,
	'routes' => [
		'collection:object:related' => [
			'path' => '/related/{guid}',
			'resource' => 'related/default',
		],
	]
];
