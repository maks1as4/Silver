<?php
for ($i=0; $i < $cnt; $i++)
{
	$class = 'text-center menu-item';
	if ($i == 0)
		$class .= ' menu-item-first';
	if ($menu[$i]['active'])
		$class .= ' active';
	$class .= ' '.$menu[$i]['color'];
	$params = array();
	$params['class'] = $class;
	if (strlen($menu[$i]['id']) > 0)
		$params['id'] = $menu[$i]['id'];
	echo CHtml::link($menu[$i]['title'], $menu[$i]['url'], $params);
}