<?php
/** エラー画面 */
if ( $input->isJP() ):
// JAPANESE View
$page = new Display( '入力エラー | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );

$page->getHeader(); ?>
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
<?php $page->getFooter();

else:
// ENGLISH View
$page = new Display( 'Input error | ' . $form_name );
$page->setFavicon( 'assets/favicon.ico' );
$page->addCSS( 'assets/style.css' );

$page->getHeader(); ?>
<header>
    <div class="centering">
        <h1>Input error</h1>
        <p><?php echo $form_name; ?></p>
    </div>
</header>
<main>
    <article class="fb-brackets">
        <section>
            <p>There is some errors in the information you entered. Please check the following and correct the information by clicking "Back".</p>
        </section>
        <section class="error-box">
            <?php $input->getError( 'Back' ); ?>
        </section>
    </article>
</main>
<footer>
    PIGFLY
</footer>
<?php $page->getFooter(); endif; ?>