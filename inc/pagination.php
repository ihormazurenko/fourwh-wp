<?php
global $new_query;
$array = [];

if ($new_query)
    $array['query'] = $new_query;
?>
<div class="pagenavi-block"><?php wp_pagenavi($array); ?></div>