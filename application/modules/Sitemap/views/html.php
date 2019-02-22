<?php header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <h1><a href="<?= $link ?>"><?= $title ?></a></h1>
    <ul>
        <?php foreach($data as $item) : ?>
        <li>
            <a href="<?= $item['loc'] ?>"><?= (empty($item['title'])) ? $item['loc'] : $item['title'] ?></a>
            <small>(last updated: <?= $item['lastmod']?>)</small>
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
