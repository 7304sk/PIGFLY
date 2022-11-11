<?php
/** 送信確認画面 */
if ( $input->isJP() ):
// JAPANESE View
$page = new Display( '送信確認 | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );

$page->getHeader(); ?>
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
            <?php $input->getConfirm( '送信する', '前の画面に戻る' ); ?>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter();

else:
// ENGLISH View
$page = new Display( 'Confirmation | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );

$page->getHeader(); ?>
<header>
    <div class="centering">
        <h1>Confirmation</h1>
        <p><?php echo $form_name; ?></p>
    </div>
</header>
<main>
    <article class="fb-brackets">
        <section>
            <p>If the information below is correct, please click the "Submit" button.</p>
        </section>
        <section class="confirm-box">
            <?php $input->getConfirm( 'Submit', 'Back' ); ?>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter(); endif; ?>