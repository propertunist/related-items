<?php
/**
 * related views CSS
 *
*/
?>
.elgg-related-items-list{
	display:inline-block;
	width:100%;
}

.elgg-related-item:hover > div > a{
	color:#555555;
}

.elgg-related-item > div > a:hover{
	text-decoration: none;
}

.elgg-related-items {
	border-top: 1px solid #777;
	padding-top: 11px;
	padding-bottom: 11px;
	margin-top:10px;
}

.elgg-related-item {
	cursor: hand; 
	cursor: pointer;
	margin: 3px;
	padding: 1%; 
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	-khtml-border-radius:4px;
	border-radius:4px;
	float:left;
	overflow:auto;
}

.elgg-related-item > div > a{
	font-weight:bold;
}

.elgg-related-item:hover{
	background-color:#eeeeee;
}

.elgg-related-item-icon{
	float:right;
}

.elgg-related-items-col
{
	overflow:hidden;
	position:relative;
}

.elgg-related-tags{
	position:absolute;
	bottom:0px;
}
