<?php
/**
 * related views CSS
 *
*/
?>
.elgg-related-items-list{
	padding-top:1em;
	text-align:center;
	display:flex;
		flex-wrap:wrap;
		width:100%;
}

.elgg-related-item:hover > a{
	color:#555555;
}

.elgg-related-item > a:hover{
	text-decoration: none;
}

.elgg-related-items {
	border-top: 1px solid #777;
	padding-top: 11px;
	padding-bottom: 11px;
	margin-top:10px;
}

.elgg-related-item {
		flex-grow:1;
		flex-shrink:1;
	cursor: hand;
	cursor: pointer;
	position:relative;
	width:100%;
	border-radius:4px;
	margin: 6px;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	-khtml-border-radius:4px;
		text-align:left;
		padding-left:6px;
		padding-top:2px;
<?php
	$show_types = elgg_get_plugin_setting('show_types', 'related-items');
if ($show_types == 'yes') {
?>
padding-bottom:1.4em;
<?php
}
?>
}

.elgg-related-item-title
{
		float:left;
		width:79%;
}

.elgg-related-item > a{
	font-weight:bold;
}

.elgg-related-item:hover{
	background-color:#eeeeee;
}

.elgg-related-item-icon-holder, .elgg-related-items-all-link{
	float:right;
}

.elgg-related-item-subtype{
	position:absolute;
	bottom:1px;
	right:1px;
}

.elgg-related-tags{
	position:absolute;
	bottom:0px;
}

.elgg-related-items-title-icon{
	width:32px;
	height:32px;
	display: inline-block;
	vertical-align: bottom;
	margin-left: 10px;
}

.elgg-related-items-title{
	font-size: 1.4em;
	font-weight:bold;
	display: inline-block;
}

.elgg-related-item-icon-holder{
		max-width: 15%;
		height:auto;
		max-height:100%;
		margin:1px 3px 0px 5px;
}

.elgg-related-item-icon
 {
		width:100%;
		height:auto;
 }

	<?php
	$media_query = elgg_get_plugin_setting('media_query', 'related-items');
	if ($media_query == 'yes') {
?>
			@media only screen and(max-width: 575px) {
				.elgg-related-item{
					width: 100%!important;
				}
			}

	<?php }
