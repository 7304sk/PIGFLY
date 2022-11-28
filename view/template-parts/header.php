<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- meta information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <!-- page title -->
    <?php if( ! empty( $favicon ) ): ?>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo $favicon; ?>">
    <?php endif; ?>
    <title><?php echo $page_title; ?></title>
    <!-- user`s stylesheets -->
    <?php foreach( $css_links as $link ) : ?>
    <link href="<?php echo $link; ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>
    <!-- user`s javascript -->
    <?php foreach( $js_links as $link ) : ?>
    <script src="<?php echo $link; ?>"></script>
    <?php endforeach; ?>
</head>
<body>