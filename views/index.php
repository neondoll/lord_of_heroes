<?php
/* @var $breadcrumbs array */

$count = count($breadcrumbs);
foreach ($breadcrumbs as $i => $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
    if ($i == $count - 1) {
        $this->title = $breadcrumb;
    }
}
?>

<div id="app"></div>
