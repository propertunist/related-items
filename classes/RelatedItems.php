<?php
use Elgg\DefaultPluginBootstrap;

class RelatedItems extends DefaultPluginBootstrap {

  public function init() {
  	$comment_position = elgg_get_plugin_setting('comment_position', 'related-items');
  	$comment_position = ($comment_position == 'bottom') ? 501 : 0;

 		elgg_extend_view('page/elements/comments', 'related-items/related-items', $comment_position);
 		elgg_extend_view('discussion/replies', 'related-items/related-items', $comment_position);
 		elgg_extend_view('admin.css', 'related-items/admin', 1);
 		elgg_extend_view('elgg.css', 'related-items/css');
    
    elgg_register_event_handler("action:validate", "plugins/settings/save", function(\Elgg\Hook $hook){
      $params = $hook->getParams();
      $return = $hook->getValue();
      
      $request = $params["request"];
      if($request->getParam('plugin_id') == "related-items") {
        $data = $request->getParam('params');
        if(is_array($data['selectfrom_subtypes'])) {
          $data['selectfrom_subtypes'] = implode(",", $data['selectfrom_subtypes']);
        }
        if(is_array($data['renderto_subtypes'])) {
          $data['renderto_subtypes'] = implode(",", $data['renderto_subtypes']);
        }
        $request->setParam('params', $data);
      }
      
      return $return;
            
    });
  }
}