<?php require view('static/header') ?>
    <main class="main">
    <div class="container">
        <div class="page-container">
            <div class="page-title"><h1><?=$query['page_title']?></h1></div>
            <div class="page-content"><?=htmlspecialchars_decode($query['page_content'])?></div>
        </div>
    </div><!-- Container -->
</main><!-- Main -->
<?php require view('static/footer') ?>
