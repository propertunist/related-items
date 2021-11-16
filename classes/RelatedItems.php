<?php
use Elgg\DefaultPluginBootstrap;

class RelatedItems extends DefaultPluginBootstrap {

  public function init() {
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

 		elgg_extend_view('page/elements/comments', 'related-items/related-items', $comment_position);
 		elgg_extend_view('discussion/replies', 'related-items/related-items', 0);
 		elgg_extend_view('admin.css', 'related-items/admin', 1);
 		elgg_extend_view('elgg.css', 'related-items/css');
  }
}