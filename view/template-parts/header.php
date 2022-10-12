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
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&family=Noto+Serif+JP:wght@200;300;400;500;600;700;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
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