<?php require view('static/header') ?>
    <main class="main">
        <div class="container">
            <div class="user-container">
                <div class="user-container-info">
                    <div class="user-container-info-primary">
                        <div class="user-img">
                            <img src="<?=users_upload_url($query['user_img'])?>" alt="">
                        </div><!-- User-İmg -->
                        <div class="user-author">
                            <div class="user-name"><?=$query['user_name']?></div>
                            <div class="user-nick">@<?=$query['user_nick']?></div>
                        </div><!-- User-Author -->
                        <?php if (session('user_nick') != $query['user_nick']): ?>
                            <a href="<?= site_url('giris')?>"><div class="user-follow"><i class="fas fa-user-plus"></i></div></a>
                        <?php elseif(session('user_nick') == $query['user_nick']):?>
                            <a href="">
                                <div class="user-follow"><i class="fas fa-cogs"></i></div>
                            </a>
                        <?php endif; ?>
                    </div><!-- User-Container-İnfo-Primary -->
                    <div class="user-container-info-secondary">
                        <div class="user-counts">Takipçi: <span><?=count(User_Follower($query['user_id']))?></span></div>
                        <div class="user-counts">Paylaşım: <span><?=count(Feed::User_Tuuts($query['user_url']))?></span></div>
                        <div class="user-counts">Artısı: <span><?=count(Tuut_Likes_User($query['user_id']))?></span></div>
                        <div class="user-counts">Eksisi: <span><?=count(Tuut_Unlikes_User($query['user_id']))?></span></div>
                    </div>
                </div><!-- User-Container-İnfo -->
            </div><!-- User-Container -->
            <?php if (empty(Feed::User_Tuuts($query['user_url']))):?>
                <div class="text-box">Hiç tuut paylaşılmamış.</div>
            <?php else: ?>
                <?php foreach (Feed::User_Tuuts($query['user_url']) as $row): ?>
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
            <?php endif; ?>
        </div><!-- Container -->
    </main><!-- Main -->
<?php require view('static/footer') ?>