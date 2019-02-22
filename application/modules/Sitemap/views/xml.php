<?php header("Content-type: text/xml; charset=utf-8"); ?>
<?= '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">


<?php foreach($data as $item) : ?>
  <url>
    <loc><?php echo $item['loc'] ?></loc>
    <lastmod><?=  $item['lastmod'] ?></lastmod>
    <changefreq><?php $arr=array("always","hourly","daily","weekly","monthly","yearly","never");$arrand=array_rand($arr,3);echo $arr[$arrand[0]]; ?></changefreq>
    <priority><?php $arr2=array("0.0","0.1","0.2","0.3","0.4","0.5","0.6","0.7","0.8","0.9","1.0");$arrand2=array_rand($arr2,3);echo $arr2[$arrand2[0]]; ?></priority>
  </url>
<?php endforeach; ?>

</urlset>
