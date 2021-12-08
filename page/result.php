<?php
/** 結果確認画面（テストモード専用） */
$page = new Display( 'メール確認（テストモード） | ' . $form_name );
$page->setCSS( 'css/radix.min.css' );
$page->setCSS( 'css/style.css' );
$page->setJS( 'js/radix.min.js' );
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
            <h2>APP URL</h2>
            <p><?php echo APP_URL; ?></p>
            <h2>リダイレクト先</h2>
            <p><?php echo $page_thanks; ?></p>
        </section>
        <section>
            <h2>メール（管理者へ送信）</h2>
            <p><?php var_pre( $to_admin->mail ); ?></p>
            <h2>メール（ユーザへの自動返信）</h2>
            <p><?php var_pre( $to_user->mail ); ?></p>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter(); ?>