<?php
/** 送信確認画面 */
$page = new Display( '送信確認 | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );
?>

<?php $page->getHeader(); ?>
<header>
    <div class="centering">
        <h1>送信確認</h1>
        <p><?php echo $form_name; ?></p>
    </div>
</header>
<main>
    <article class="fb-brackets">
        <section>
            <p>以下の内容で間違いがなければ、「送信する」ボタンを押してください。</p>
        </section>
        <section class="confirm-box">
            <?php $input->confirm( '送信する' ); ?>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter(); ?>