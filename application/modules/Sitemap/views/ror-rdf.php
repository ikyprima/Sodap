<?php header("Content-type: text/rdf+xml; charset=utf-8"); ?>
<?= '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rdf:RDF xmlns="http://rorweb.com/0.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Resource rdf:about="sitemap">
    <title><?= $title ?></title>
    <url><?= $link ?></url>
    <type>sitemap</type>
</Resource>
<?php foreach($data as $item) : ?>
<Resource>
    <url><?= $item['loc'] ?></url>
    <title><?= $item['title'] ?></title>
    <updated><?= $item['lastmod'] ?></updated>
    <updatePeriod><?php $arr=array("always","hourly","daily","weekly","monthly","yearly","never");$arrand=array_rand($arr,3);echo $arr[$arrand[0]]; ?></updatePeriod>
    <sortorder><?php $arr2=array("0.0","0.1","0.2","0.3","0.4","0.5","0.6","0.7","0.8","0.9","1.0");$arrand2=array_rand($arr2,3);echo $arr2[$arrand2[0]]; ?></sortorder>
    <resource rdf:resource="sitemap"> </resource>
</Resource>
<?php endforeach; ?>
</rdf:RDF>
