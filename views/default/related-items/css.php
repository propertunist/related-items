<?php
/**
 * related views CSS
 *
*/
?>
.elgg-related-items-list{
	width:100%;
	padding-top:1em;
	text-align:center;
	column-gap:0;
    -webkit-column-gap:0;
    -moz-column-gap:0;
    -khtml-column-gap:0;
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
	cursor: pointer;
	position:relative;
	width:95%;
	border-radius:4px;
	margin: 0.7%;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	-khtml-border-radius:4px;
	display:inline-block;
    *display:inline; /*IE7*/
    *zoom:1; /*IE7*/
    text-align:left;
    padding-left:6px;
    padding-top:2px;	
<?php
	$show_types = elgg_get_plugin_setting('show_types','related-items');
	if($show_types == 'yes')
	{
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
     width: 15%;
     height:auto;
     max-height:4em;
     margin:1px 3px 0px 5px;
}

.elgg-related-item-icon
 {
    width:100%;
    height:auto;
 }