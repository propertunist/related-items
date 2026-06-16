<?php
namespace RelatedItems;

class Events {
  
  public static function PluginSettingSave (\Elgg\Event $event){
    $params = $event->getParams();
    $return = $event->getValue();
    
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
  }
}

 ?>