<?php require view('static/header') ?>
<sub-header class="sub-header">
    <div class="container">
        <div class="sub-header-menu">
            <label>En Popüler</label>
            <ul>
                <li>Günlük</li>
                <li>Haftalık</li>
                <li>Aylık</li>
                <li>Kullanıcı</li>
            </ul>
        </div>
    </div><!-- Container -->
</sub-header>
<main class="main">
    <div class="container">
        <?php foreach (Feed::Tuuts() as $row): ?>
            <div class="tuut-post">
                <div class="tuut-post-header">
                    <div class="tuut-post-author">
                        <h2><a href="<?=site_url('uye/'.$row['user_url'])?>">@<?=$row['user_nick']?></a> • <a href="<?=site_url('kategori/'.$row['category_url'])?>" style="color: #2d2d2d"><?=$row['category_title']?></a></h2>
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
                </div><!-- Tuut-Post-Center -->
                <div class="tuut-post-footer">
                    <div class="tuut-post-comment-count"><i class="far fa-comment-alt"></i> <?=count(Tuut_Comments($row['tuut_id']))?> yorum</div>
                    <div class="tuut-post-date"><i class="fas fa-info"></i> <?=timeConvert($row['tuut_date'])?></div>
                    <div class="rating-bar">
                        <?php if (!session('user_id')): ?>
                            <a href="<?=site_url('giris')?>">
                                <div class="rating-icon rating-icon-down"><i class="fas fa-chevron-down"></i></div>
                            </a>
                        <?php else: ?>
                            <?php if (empty(User_Tuut_Unlike(session('user_id') , $row['tuut_id']))): ?>
                                <div class="rating-icon rating-icon-down addUnlike" user-id="<?=session('user_id')?>" tuut-id="<?=$row['tuut_id']?>"><i class="fas fa-chevron-down"></i></div>
                            <?php else: ?>
                                <div class="rating-icon rating-icon-down removeUnlike" user-id="<?=session('user_id')?>" tuut-id="<?=$row['tuut_id']?>"><i class="fas fa-minus"></i></div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="rating-count"><?=Tuut_Count($row['tuut_id'])?></div>
                        <?php if (!session('user_id')): ?>
                            <a href="<?=site_url('giris')?>">
                                <div class="rating-icon rating-icon-up"><i class="fas fa-chevron-up"></i></div>
                            </a>
                        <?php else: ?>
                            <?php if (empty(User_Tuut_Like(session('user_id') , $row['tuut_id']))): ?>
                                <div class="rating-icon rating-icon-up addLike" user-id="<?=session('user_id')?>" tuut-id="<?=$row['tuut_id']?>"><i class="fas fa-chevron-up"></i></div>
                            <?php else: ?>
                                <div class="rating-icon rating-icon-up removeLike" user-id="<?=session('user_id')?>" tuut-id="<?=$row['tuut_id']?>"><i class="fas fa-minus"></i></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div><!-- Rating-Bar -->
                </div><!-- Tuut-Post-Footer -->
            </div><!-- Tuut-Post -->
        <?php endforeach; ?>
    </div><!-- Container -->
</main><!-- Main -->

<?php require view('static/footer') ?>


