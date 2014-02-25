<?php
	$renderto_subtypes = array_filter(explode(',', elgg_get_plugin_setting('renderto_subtypes','related-items')));
	if(in_array($vars['entity']->getSubtype(),$renderto_subtypes))
	{
		$max_related_items = elgg_get_plugin_setting('max_items','related-items');	
		$related_items = get_related_entities($vars['entity'], intval($max_related_items), false, 0);
		if (!$related_items == false)
		{
		$total_related_items = get_related_entities($vars['entity'], 0, TRUE,0);
		$show_names = elgg_get_plugin_setting('show_names','related-items');
		$show_dates = elgg_get_plugin_setting('show_dates','related-items');
		$show_tags = elgg_get_plugin_setting('show_tags','related-items');
		$show_types = elgg_get_plugin_setting('show_types','related-items');
		$show_icons = elgg_get_plugin_setting('show_icons','related-items');

		$column_count = elgg_get_plugin_setting('column_count','related-items');
		$jquery_height = elgg_get_plugin_setting('jquery_height','related-items');
        $related_items_count = count($related_items);
		$elgg_path = elgg_get_site_url();
          if ($related_items_count< $column_count) // if the amount of related items is less than the amount of columns set in admin
          {
              switch($related_items_count)
              {
                case 2: {$box_width = 47;break;}
                case 3: {$box_width = 30;break;}
                case 1: 
                default: {$box_width = 97;break;}
              }
          }
          else
          {
              switch($column_count)
    		  {
    		  	case 1: {$box_width = 97;break;}
    			case 2: {$box_width = 47;break;}
    			case 3: {$box_width = 30;break;}
    			default: {$box_width = 22;break;}
    		  }
          }
		  if ($jquery_height == 'yes')
	     	echo "<script type=\"text/javascript\" >

	      	$(document).ready(function(){
	      		   	function set_height(item){
	      			var maxHeight = 0;
	      			item = $(item);
	      			item.css(\"height\" , \"auto\");
	      			item.each(function(){
	      				if($(this).height() > maxHeight){
	      					maxHeight = $(this).height();
	      				}
	      			});
	      			item.css(\"height\" , maxHeight);
	      			}
	      		    
	      		    set_height('.elgg-related-item');
	      		      $(window).resize(function(){
	      		      	
	      		      	set_height('.elgg-related-item');
	      		      	});
	      		});      	
	      	</script>";
		  echo '<div class="elgg-related-items">';
	      echo "<div class='elgg-related-items-title'>" . elgg_echo('related-items:title') . "</div>";
	      echo "<div class='elgg-related-items-title-icon'></div>";
          if ($total_related_items > $related_items_count)
          {
    		  echo "<div class='elgg-related-items-all-link'>";
    		  echo elgg_view('output/url', array(
    				'href' => $elgg_path . 'related/' . $vars['entity']->guid,
    				'text' => elgg_echo('related-items:view-all', array($total_related_items)),
    				'is_trusted' => true,));
    	      echo "</div>";
          }
	      echo '<ul class="elgg-related-items-list">';

		  foreach ($related_items as $related_item)
	      {
			if ($related_item instanceof ElggObject) // ensure the item is not a group or other object type
			{
				$owner = $related_item->getOwnerEntity();
				$icon_url = '';
				$icon = null;
				$this_subtype = $related_item->getsubtype();
				echo '<li class="elgg-related-item elgg-related-' . $this_subtype . '"style="width:' . $box_width . '%;" onclick="window.location.href=\''. $related_item->getURL() . '\';">';

				if($show_icons =='yes')
				{		
					switch($this_subtype)
					{
						case 'image':
							$icon_url = $elgg_path . "photos/thumbnail/" . $related_item->getGUID() . "/thumb/";
							break;
						case 'videolist_item':
						case 'izap_videos':
						case 'file':
						case 'au_set':
							$icon_url = $related_item->getIconURL('medium');						
							break;
						case 'blog':
							if ($related_item->icontime) {
								$icon_url = $related_item->getIconURL('medium');
							} else {
								$icon_url = $owner->getIconURL('medium');
							}
							break;
						default: 			break;
					}
					
					if (empty($icon_url))
						$icon_url = $owner->getIconURL('medium');

					$div = "<div style='background-image: url(\"". $icon_url . "\");' class='elgg-related-item-icon elgg-related-" . $this_subtype . "-icon'>&nbsp;</div>";
					echo $div;
				}

                 switch ($this_subtype)
                  {
                    case 'image':
                    case 'album':   
                    case 'au_set':
                        {
                            $type_label = elgg_echo ($this_subtype);
                            break;
                        }
                    case 'page_top':
                    case 'pages':
                    case 'bookmarks':
                    case 'videolist_item':                                             
                        {
                            $type_label = elgg_echo ('related_items:' . $this_subtype);
                            break;
                        }    
                    case 'file':
                    case 'blog':
                        {
                            $type_label = elgg_echo ($this_subtype . ':' . $this_subtype);
                            break;
                        }  
                    default:                
                        {
                            $type_label = elgg_echo('item:object:' . $this_subtype);
                            break;
                        }
                  }
			//	$type_label = substr($type_label,0,strlen($type_label)-1);

				echo "<a href='{$related_item->getURL()}'>" . elgg_get_excerpt($related_item->title, 100) . "</a>";
				if($show_dates =='yes')				 
					echo "<br/><small>" . elgg_view_friendly_time($related_item->time_created) . "</small>";
				if($show_names =='yes')
					echo "<br/><small>" . $owner->name . "</small>";
				if($show_tags =='yes')
					echo "<br/><small>" . elgg_view('output/tags',array('value'=>$related_item->tags)) . "</small>";
				if($show_types == 'yes')
					echo "<div class='elgg-related-item-subtype'><small>" . $type_label . "</small></div>";
				echo "</li>";
			}
		  } // end loop
	      echo '</ul></div>';
		  return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
?>