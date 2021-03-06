<?php
/**
 * Footer for main page
 */

namespace Elgg\CommunityPlugins;

use PluginProject;

// Note: Not using elgg_extract because these are potentially expensive database queries.
if (!isset($vars['newest'])) {
	$vars['newest'] = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'plugin_project',
		'pagination' => false,
		'order_by' => 'e.last_action DESC',
		'preload_owners' => true,
	));
}

if (!isset($vars['popular'])) {
	$vars['popular'] = elgg_list_entities(array(
			'pagination' => false,
			'preload_owners' => true,
		),
		[PluginProject::class, 'getPluginsByDownloads']
	);
}

if (!isset($vars['recommended'])) {
	$vars['recommended'] = elgg_list_entities_from_annotation_calculation(array(
		'types' => array('object'),
		'subtypes' => array('plugin_project'),
		'annotation_names' => array('plugin_digg'),
		'calculation' => 'count',
		'pagination' => false,
		'preload_owners' => true,
	));
}

?>

<div class="elgg-grid elgg-community-plugins">
<?php

// Newest
echo '<div class="elgg-col elgg-col-1of3">';
	echo '<div class="elgg-inner">';
	echo elgg_view_module('info', elgg_echo('plugins:listing:newest'), $vars['newest'], array(
		'footer' => elgg_view('output/url', array(
			'href' => '/plugins/list/newest',
			'text' => elgg_echo('plugins:browse_more:newest'),
			'class' => 'elgg-widget-more',
		)),
	));
	echo '</div>';
echo '</div>';

echo '<div class="elgg-col elgg-col-1of3">';
	echo '<div class="elgg-inner">';
	
	// Most downloaded
	echo elgg_view_module('info', elgg_echo('plugins:listing:popular'), $vars['popular'], array(
		'footer' => elgg_view('output/url', array(
			'href' => '/plugins/list/popular',
			'text' => elgg_echo('plugins:browse_more:popular'),
			'class' => 'elgg-widget-more',
		)),
	));
	
	echo '</div>';
echo '</div>';

echo '<div class="elgg-col elgg-col-1of3 elgg-col-last">';
	echo '<div class="elgg-inner">';
	
	// Most recommended
	echo elgg_view_module('info', elgg_echo('plugins:listing:dugg'), $vars['recommended'], array(
		'footer' => elgg_view('output/url', array(
			'href' => '/plugins/list/recommended',
			'text' => elgg_echo('plugins:browse_more:dugg'),
			'class' => 'elgg-widget-more',
		)),
	));
	
	echo '</div>';
echo '</div>';
?>
</div>
