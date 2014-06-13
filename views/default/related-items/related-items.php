<?php
	$renderto_subtypes = array_filter(explode(',', elgg_get_plugin_setting('renderto_subtypes','related-items')));
	if(in_array($vars['entity']->getSubtype(),$renderto_subtypes))
	{
		$max_related_items = elgg_get_plugin_setting('max_items','related-items');	
		$related_items = get_related_entities($vars['entity'], intval($max_related_items), false, 0);
		if (!$related_items == false)
		{
		$total_related_items = get_related_entities($vars['entity'], 0, TRUE,0);
        $select_related = elgg_get_plugin_setting('select_related','related-items');
		$show_names = elgg_get_plugin_setting('show_names','related-items');
		$show_dates = elgg_get_plugin_setting('show_dates','related-items');
        $show_timestamps = elgg_get_plugin_setting('show_timestamps','related-items');
		$show_tags = elgg_get_plugin_setting('show_tags','related-items');
		$show_types = elgg_get_plugin_setting('show_types','related-items');
		$show_icons = elgg_get_plugin_setting('show_icons','related-items');

		$column_count = elgg_get_plugin_setting('column_count','related-items');
		$jquery_height = elgg_get_plugin_setting('jquery_height','related-items');
        $related_items_count = count($related_items);
		$elgg_path = elgg_get_site_url();

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
	      echo "<div class='elgg-related-items-title'>";
	      if ($select_related == 'related')
          {
	           echo elgg_echo('related-items:title');
               echo "<div class='elgg-related-items-title-icon'></div>";
          }
          else
              echo elgg_echo('related-items:more-items');
          echo "</div>";

          if (($total_related_items > $related_items_count)&&($select_related == 'related'))
          {
    		  echo "<div class='elgg-related-items-all-link'>";
    		  echo elgg_view('output/url', array(
    				'href' => $elgg_path . 'related/' . $vars['entity']->guid,
    				'text' => elgg_echo('related-items:view-all', array($total_related_items)),
    				'is_trusted' => true,));
    	      echo "</div>";
          }
	      echo '<div class="elgg-related-items-list" style="column-count:' . $column_count . ';-khtml-column-count:' . $column_count . ';-webkit-column-count:' . $column_count . ';-moz-column-count:' . $column_count . '; ">';

		  foreach ($related_items as $related_item)
	      {
			if ($related_item instanceof ElggObject) // ensure the item is not a group or other object type
			{
				$owner = $related_item->getOwnerEntity();
				$icon_url = '';
				$icon = null;
				$this_subtype = $related_item->getsubtype();
				echo "<div class=\"elgg-related-item elgg-related-" . $this_subtype . "\" onclick=\"location.href='". $related_item->getURL() . "';\">";

				if($show_icons =='yes')
				{		
					switch($this_subtype)
					{
						case 'image':
							$icon_url = $elgg_path . "photos/thumbnail/" . $related_item->getGUID() . "/small/";
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

					$img = "<div class=\"elgg-related-item-icon-holder\"><a href=\"" . $related_item->getURL() . "\"><img src=\"". $icon_url . "\" class=\"elgg-related-item-icon elgg-related-" . $this_subtype . "-icon\"/ width=\"10\" height=\"20\"></a></div>";
					echo $img;
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
			    echo '<div class="elgg-related-item-title">';
                if ($related_item->title)
                {
				    echo '<a href="' . $related_item->getURL() . '">' . elgg_get_excerpt($related_item->title, 100);
                    echo "</a><br/>";
                }
                if($show_names =='yes')
                    echo "<small>" . elgg_echo ('by') . ' ' . $owner->name . "</small>";

				if($show_dates =='yes')		
                {
                    if ($show_timestamps == 'yes')
                        $time = date("D, d M y H:i:s",$related_item->time_created);
                    else
                        $time = elgg_view_friendly_time($related_item->time_created);	 
					echo "<br/><small>" . $time . "</small>";
                }

				if($show_tags =='yes')
					echo "<br/><small>" . elgg_view('output/tags',array('value'=>$related_item->tags)) . "</small>";
 
				if($show_types == 'yes')
					echo "<div class='elgg-related-item-subtype'><small>" . $type_label . "</small></div>";

				echo "</div>";
                echo '<div class="clearfloat"></div>';
                echo "</div>";
			}
		  } // end loop
	      echo '</div></div>';
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