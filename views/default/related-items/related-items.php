<?php
	$renderto_subtypes = array_filter(explode(',', elgg_get_plugin_setting('renderto_subtypes','related-items')));
	if(in_array($vars['entity']->getSubtype(),$renderto_subtypes))
	{
		$max_related_items = elgg_get_plugin_setting('max_items','related-items');	
		$related_items = get_related_entities($vars['entity'], intval($max_related_items), false, 0);
		if (!$related_items == false)
		{
		$show_names = elgg_get_plugin_setting('show_names','related-items');
		$show_dates = elgg_get_plugin_setting('show_dates','related-items');
		$show_tags = elgg_get_plugin_setting('show_tags','related-items');

		$column_count = elgg_get_plugin_setting('column_count','related-items');
		$jquery_height = elgg_get_plugin_setting('jquery_height','related-items');
		$elgg_path = elgg_get_site_url();

		  switch($column_count) // this can be moved to a plugin variable
		  {
		  	case 1: {$box_width = 97;break;}
			case 2: {$box_width = 47;break;}
			case 3: {$box_width = 30;break;}
			default: {$box_width = 22;break;}
		  }
		  if ($jquery_height == 'yes')
	      	echo "<script type=\"text/javascript\" >
	      	$(document).ready(function(){
	      		var maxHeight = 0;
	      		var set_height = function(column) {
	      			column = $(column);
	      			column.each(function(){
	      				if($(this).height() > maxHeight){
	      					maxHeight = $(this).height();
	      				}
	      			});
	      			column.height(maxHeight);
	      		}
	      		set_height('.elgg-related-items-col');
	      		});      		$(window).resize(set_height('.elgg-related-items-col'));
	      	</script>";
		  echo '<div class="elgg-related-items">';
	      echo "<div class='elgg-related-items-title'>" . elgg_echo('related-items:title') . "</div>";
	      echo "<div class='elgg-related-items-title-icon'></div>";
		  echo "<div class='elgg-related-items-all-link'>";
		  echo elgg_view('output/url', array(
				'href' => $elgg_path . 'related/' . $vars['entity']->guid,
				'text' => elgg_echo('related-items:view-all'),
				'is_trusted' => true,));
	      echo "</div>";
	      echo '<ul class="elgg-related-items-list">';

		  foreach ($related_items as $related_item)
	      {
			if ($related_item instanceof ElggObject) // ensure the item is not a group or other object type
			{
				$owner = $related_item->getOwnerEntity();
				$this_subtype = $related_item->getsubtype();
				echo '<li class="elgg-related-item elgg-related-' . $this_subtype . '"style="width:' . $box_width . '%;" onclick="window.location.href=\''. $related_item->getURL() . '\';">';
				echo "<div class='elgg-related-items-col'>";
				switch($this_subtype)
				{
					case 'image':
						$item_guid = $related_item->getGUID();
						$title = $related_item->getTitle();
						$icon = "<img src='" . elgg_get_site_url() . "photos/thumbnail/" . $item_guid . "/thumb/' alt='" . $title . "'/>";	
						break;
					case 'videolist_item':
					case 'izap_videos':
					case 'file':
						$icon = elgg_view_entity_icon($related_item, 'small'); break;
					default: 			break;
				}
				$css_tag = $this_subtype;
				if (!empty($icon))
					$css_tag .= '-gfx';
				else
				{
					$icon ="&nbsp;" ;	
				}
				$div = "<div class='elgg-related-item-icon elgg-related-" . $css_tag . "-icon'>" . $icon . "</div>";
				echo $div;
				$icon = null;
				echo "<a href='{$related_item->getURL()}'>" . elgg_get_excerpt($related_item->title, 100) . "</a>";
				if($show_dates =='yes')				 
					echo "<br/><small>" . elgg_view_friendly_time($related_item->time_created) . "</small>";
				if($show_names =='yes')
					echo "<br/><small>" . $owner->name . "</small>";
				if($show_tags =='yes')
					echo "<br/><small>" . elgg_view('output/tags',array('value'=>$related_item->tags)) . "</small>";
				echo "</div></li>";
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