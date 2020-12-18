<?php require view('static/header') ?>
    <main class="main" id="single-main">
    <div class="container">
        <?php foreach (Feed::Tuut($query['tuut_url']) as $row): ?>
            <div class="tuut-post">
                <div class="tuut-post-header">
                    <div class="tuut-post-author">
                        <h2><a href="<?=site_url('uye/'.$row['user_url'])?>">@<?=$row['user_nick']?></a> • <a href="<?=site_url('kategori/'.$row['category_url'])?>" style="color: #2d2d2d"><?=$row['category_title']?></a></h2>
                    </div><!-- Tuut-Post-Author -->
                    <i class="fas fa-caret-down"></i>
                </div>
                <div class="tuut-post-center">
                    <div class="tuut-post-title"><h2 style="font-size: 1.2rem"><?=$row['tuut_title']?></h2></div>
                    <div class="tuut-post-desc"><p style="font-size: .9rem"><?=$row['tuut_desc']?></p></div>
                    <div class="tuut-post-img">
                        <img src="<?=tuuts_upload_url($row['tuut_img'])?>" alt="">
                    </div>
                </div>
                <div class="tuut-post-footer">
                    <div class="tuut-post-comment-count"><i class="far fa-comment-alt"></i> 125 yorum</div>
                    <div class="tuut-post-date"><i class="fas fa-info"></i> 25 dakika önce</div>
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
                <div class="tuut-post-comments">
                    <div class="title">Yorumlar</div>
                    <ul>
                        <?php if (empty(Tuut_Comments($row['tuut_id']))): ?>
                            <div class="text-box" style="background: #343a40">İlk yorumu siz yapın.</div>
                        <?php else: ?>
                            <?php foreach (Tuut_Comments($row['tuut_id']) as $query): ?>
                        <li class="tuut-post-comment">
                            <div class="tuut-post-comment-img">
                                <img src="<?=users_upload_url($query['user_img'])?>" alt="">
                            </div>
                            <div class="tuut-post-comment-author">
                                <a href="<?=site_url('uye/'.$query['user_url'])?>">@<?=$query['user_nick']?></a>
                                <span><?=timeConvert($query['comment_date'])?></span>
                            </div>
                            <div class="tuut-post-comment-content">
                                <p><?=$query['comment_text']?></p>
                            </div>
                            <div class="tuut-post-comment-rating-bar">
                                <?php if (!session('user_id')): ?>
                                    <a href="<?=site_url('giris')?>">
                                        <div class="tuut-post-comment-rating-icon"><i class="fas fa-chevron-up"></i></div>
                                    </a>
                                <?php else: ?>
                                    <?php if (empty(User_Tuut_Comment_Like(session('user_id') , $query['comment_id']))): ?>
                                        <div class="tuut-post-comment-rating-icon comment_addLike" user-id="<?=session('user_id')?>" comment-id="<?=$query['comment_id']?>"><i class="fas fa-chevron-up"></i></div>
                                    <?php else: ?>
                                        <div class="tuut-post-comment-rating-icon comment_removeLike" user-id="<?=session('user_id')?>" comment-id="<?=$query['comment_id']?>"><i class="fas fa-chevron-up" style="color: #5e5e5e"></i></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="tuut-post-comment-rating-count"><?=Tuut_Comment_Count($query['comment_id'])?></div>
                                <?php if (!session('user_id')): ?>
                                    <a href="<?=site_url('giris')?>">
                                        <div class="tuut-post-comment-rating-icon"><i class="fas fa-chevron-down"></i></div>
                                    </a>
                                <?php else: ?>
                                    <?php if (empty(User_Tuut_Comment_Unlike(session('user_id') , $query['comment_id']))): ?>
                                        <div class="tuut-post-comment-rating-icon comment_addUnlike" user-id="<?=session('user_id')?>" comment-id="<?=$query['comment_id']?>"><i class="fas fa-chevron-down"></i></div>
                                    <?php else: ?>
                                        <div class="tuut-post-comment-rating-icon comment_removeUnlike" user-id="<?=session('user_id')?>" comment-id="<?=$query['comment_id']?>"><i class="fas fa-chevron-down" style="color: #5e5e5e"></i></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div><!-- Comment-Rating-Bar -->
                        </li><!-- Tuut-Post-Comment (li) -->
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </ul><!-- (ul) -->
                </div><!-- Tuut-Post-Comments -->
                <div class="tuut-post-do-comment">
                    <div class="title">Yorum Yap</div>
                    <?php if (session('user_id')): ?>
                    <form method="post">
                        <textarea name="comment-text" maxlength="255" cols="20" rows="1"></textarea>
                        <input type="hidden" name="submit-comment-tuut" value="1">
                        <button type="submit">Gönder</button>
                    </form>
                    <?php else: ?>
                    <a href="<?=site_url('giris')?>">
                        <div class="text-box">Yorum yapabilmek için giriş yapınız.</div>
                    </a>
                    <?php endif; ?>
                </div>
                <?php if (isset($error_comment)):?>
                <div class="text-box"><?=$error_comment?></div>
                <?php endif; ?>
            </div><!-- Tuut-Post -->
        <?php endforeach; ?>
    </div><!-- Container -->
</main><!-- Main -->
<?php require view('static/footer') ?>
