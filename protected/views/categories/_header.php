<?php
if ($category['title_seo'] == '')
	$this->pageTitle = ($root !== null) ? $root->name.', '.$category['name'] : $category['name'];
else
	$this->pageTitle = $category['title_seo'];
$this->pageDescription = ($category['desc_seo'] != '') ? $category['desc_seo'] : '';
$this->pageKeywords = ($category['key_seo'] != '') ? $category['key_seo'] : '';
$this->breadcrumbs = $breadcrumbs;
?>
