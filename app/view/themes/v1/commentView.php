<?php if (session('user_id')): ?>
    <div class="widget-title">
        <h3>Yapıma Yorum Yap</h3>
    </div>
    <div class="comment-up col-sm-12">
        <form class="" method="post">
            <?php if (isset($error)): ?>
                <div class="row"><div class="alert alert-danger" role="alert"><?=$error?></div></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-6 pl-0">
                    <div class="alert alert-success" role="alert">
                        <h6 class="alert-heading">Lütfen dikkat edin!</h6>
                        <p>Yapımlara puan verip yorum yaparken, olabildiğince objektif olunuz.</p>
                        <p>Noktalama işaretleri ve imla kurallarına uyunuz.</p>
                        <p>Yapacağınız yorumlarda, toplumun herhangi bir kesmini rahatsız etmekten kaçınınız.</p>
                        <p>Heveskıran içeren cümleleri, [heveskıran]örnek[/heveskıran] içerisinde belirtiniz.</p>
                        <hr>
                        <p>Kaliteli içerikli ve manipülasyonsuz bir izle'yorum için bu kurallara lütfen uyunuz. Her şey platformun kalitesi için :)</p>
                        <p class="mb-0">Kurallara uyulmamış ve uygun görülmemiş yorumların kaldırılması veya düzenlenmesi hakkı saklıdır.</p>
                    </div>
                </div><!-- Col-Sm-6 -->
                <div class="col-sm-6 ml-auto pr-0">
                    <div class="form-group"><label  class="col-sm-12 col-form-label pr-0">Yapıma Puanın</label>
                        <div class="col-sm-12 pr-0"><input name="rating_number" type="number" max='100' class="col-sm-3 form-control fm-md" required>
                            <small class="form-text text-muted">Lütfen 0 ile 100 arasında bir puan giriniz.</small>
                        </div>
                    </div>
                    <div class="form-group"><label  class="col-sm-12 col-form-label pr-0">Yapım Hakkında Yorumun</label>
                        <div class="col-sm-12 pr-0">
                            <textarea name="rating_content" class="form-control fm-md" id="comment" cols="30" minlength="200" maxlength="3000" rows="10" required></textarea>
                            <small class="form-text text-muted">Lütfen 200 karakterden az, 3000 karakterden uzun yorum yapmayınız.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row pr-3 comment-btn">
                            <a class="btn btn-outline-primary ml-4" id="hk-btn">Heveskıran</a>
                            <input type="hidden" name="submit" value="1">
                            <button class="btn btn-primary ml-auto">Tamamla</button>
                        </div>
                    </div>
                </div><!-- Col-Sm-6 -->
            </div>
        </form>
    </div><!-- Col-Sm-12 -->
<?php else:?>
    <div class="widget-title">
        <h3>YORUMLAR</h3>
    </div>
    <div class="comment-place">
        <div class="comment-do">
            <p>Yorum yazmak için giriş yapın</p>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter2">Giriş Yap</button>
        </div>
    </div><!-- Comment-Place -->
<?php endif; ?>
<?php if (isset($error2)): ?>
    <div class="alert alert-primary col-sm-12 float-left" role="alert">
        <?= $error2 ?>
    </div>
<?php else: ?>
    <div class="comment-container">
        <?php foreach ($ratings as $row): ?>
            <div class="comment-box">
                <div class="comment-info">
                    <div class="comment-author-img" style="background-image: url(<?= $row['user_img'] ? site_url('upload/files/') . $row['user_img'] : public_url('img/user_icon.png')?>)"></div>
                    <div class="comment-author-box">
                        <div class="comment-author">
                            <h2><?= $row['user_name']?></h2>
                        </div>
                        <div class="comment-author-nickname">
                            <h3><?= '@'.$row['user_nick']?></h3>
                        </div>
                        <div class="comment-author-grade">
                            <h3>1.seviye yazar</h3>
                        </div>
                        <div class="fidibe-meter meter-s <?= RatingColor($row['rating_number'])?>">
                            <h2 id="tl-m">
                                <?= $row['rating_number']?>
                            </h2>
                        </div><!-- Fidibe-Meter -->
                    </div><!-- Comment-Author-Box -->
                </div><!-- Comment-İnfo -->
                <div class="comment-text">
                    <p><?= $row['rating_content']?></p>
                </div>
                <div class="comment-bottom">
                    <div class="comment-like like-content">
                        <?php if (session('user_id')): ?>
                            <?php if (empty(UserLike(session('user_id'), $row['rating_id']))): ?>
                                <button class="like-btn like-review btn-like" user-id="<?= $row['user_id']?>" rating-id="<?= $row['rating_id']?>"><i class="far fa-heart"></i><?= LikeView($row['rating_id'])?></button>
                            <?php else: ?>
                                <button class="like-btn like-review btn-unlike" user-id="<?= $row['user_id']?>" rating-id="<?= $row['rating_id']?>">beğenmekten vazgeç <i class="fas fa-heart"></i> <?= LikeView($row['rating_id'])?></button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="like-btn like-review" data-toggle="modal" data-target="#exampleModalCenter2"><i class="far fa-heart"></i><?= LikeView($row['rating_id'])?></button>
                        <?php endif; ?>
                </div>
                    <div class="comment-date">
                        <h3><?= timeConvert($row['rating_date'])?></h3>
                    </div>
                </div>
            </div><!-- Comment-Box -->
        <?php endforeach; ?>
    </div><!-- Comment-Container -->
<?php endif; ?>