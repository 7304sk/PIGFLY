<?php
/** エラー画面 */
$page = new Display( '入力エラー | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );
?>

<?php $page->getHeader(); ?>
<header>
    <div class="centering">
        <h1>入力内容エラー</h1>
        <p><?php echo $form_name; ?></p>
    </div>
</header>
<main>
    <article class="fb-brackets">
        <section>
            <p>入力内容に誤りがあります。下記をご確認の上「戻る」より訂正ください。</p>
        </section>
        <section class="error-box">
            <?php $input->getError( '前の画面に戻る' ); ?>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter(); ?>