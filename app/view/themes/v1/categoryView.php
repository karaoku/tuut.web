<?php require view('static/header') ?>
    <sub-title class="sub-title">
        <div class="container">
            <h1>Oyun</h1>
            <p>kategorisine ait tuut'ların tamamı.</p>
        </div><!-- Container -->
    </sub-title>
    <sub-header class="sub-header">
        <div class="container">
            <div class="sub-header-menu">
                <label>En Popüler</label>
                <ul>
                    <li>Günlük</li>
                    <li>Hafta</li>
                    <li>Ay</li>
                    <li>Kullanıcı</li>
                </ul>
            </div>
        </div><!-- Container -->
    </sub-header>
    <main class="main">
        <div class="container">
            <?php foreach ($query as $row): ?>
                <div class="tuut-post">
                    <div class="tuut-post-header">
                        <div class="tuut-post-author">
                            <h2><a href="">@<?=$row['user_nick']?></a> • <a href="<?=site_url('kategori/'.$row['category_url'])?>" style="color: #2d2d2d"><?=$row['category_title']?></a></h2>
                        </div><!-- Tuut-Post-Author -->
                        <div class="tuut-dropdown">
                            <i class="fas fa-caret-down dropdown-item"></i>
                            <div class="tuut-dropdown-menu" id="display-none">
                                <ul>
                                    <li><a href="#">İçeriği Bildir</a></li>
                                    <li><a href="#">Kaydet</a></li>
                                </ul>
                            </div>
                        </div><!-- Tuut-Dropdown -->
                    </div><!-- Tuut_Post-Header -->
                    <div class="tuut-post-center">
                        <a href="<?=site_url('tuut/' . $row['tuut_url'])?>">
                            <div class="tuut-post-title"><h2><?=$row['tuut_title']?></h2></div>
                            <div class="tuut-post-desc"><p><?=$row['tuut_desc']?></p></div>
                        </a>
                        <div class="tuut-post-img">
                            <img src="<?=tuuts_upload_url($row['tuut_img'])?>" alt="">
                        </div>
                    </div>
                    <div class="tuut-post-footer">
                        <div class="tuut-post-comment-count"><i class="far fa-comment-alt"></i> 125 yorum</div>
                        <div class="tuut-post-date"><i class="fas fa-info"></i> 25 dakika önce</div>
                        <div class="rating-bar">
                            <div class="rating-icon rating-icon-down"><i class="fas fa-chevron-down"></i></div>
                            <div class="rating-count">+589</div>
                            <div class="rating-icon rating-icon-up"><i class="fas fa-chevron-up"></i></div>
                        </div><!-- Rating-Bar -->
                    </div><!-- Tuut-Post-Footer -->
                </div><!-- Tuut-Post -->
            <?php endforeach; ?>
        </div><!-- Container -->
    </main><!-- Main -->
<?php require view('static/footer') ?>