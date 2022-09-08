<?php
/** 結果確認画面（テストモード専用） */
$page = new Display( 'メール確認（テストモード） | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );
?>

<?php $page->getHeader(); ?>
<header>
    <div class="centering">
        <h1>メール確認（テストモード）</h1>
        <p><?php echo $form_name; ?></p>
    </div>
</header>
<main>
    <article class="fb-brackets">
        <section>
            <p>現在テストモードです。メールは送信されておらず、メールの内容はこの画面でのみ確認できます。</p>
        </section>
        <section>
            <h2>APP URL</h2>
            <p><?php echo APP_URL; ?></p>
            <h2>リダイレクト先</h2>
            <p><a href="<?php echo $page_thanks; ?>"><?php echo $page_thanks; ?></a></p>
        </section>
        <section>
            <h2>メール（管理者へ送信）</h2>
            <?php $to_admin->getMail(); ?>
            <h2>メール（ユーザへの自動返信）</h2>
            <?php $to_user->getMail(); ?>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter(); ?>