<?php require view('static/header') ?>
<div class="row">
    <div class="form-body p-5 mx-auto m-5" style="background-color: #e9ecef;">
        <form method="post">
            <?php if (!isset($error_set_password) && !isset($success_set_password)): ?>
                <div class="alert alert-primary" role="alert">
                    Lütfen aşağıdaki alanları <strong>eksiksiz</strong> doldurun.
                </div>
            <?php endif; ?>
            <?php if (isset($error_set_password)): ?>
                <div class="alert alert-warning" role="alert">
                    <?= $error_set_password ?>
                </div>
            <?php endif; ?>
            <?php if (isset($success_set_password)): ?>
                <div class="alert alert-warning" role="alert">
                    <?= $success_set_password ?>
                </div>
            <?php endif; ?>
            <label>Yeni Şifreniz</label>
            <div class="input-group input-group-sm mb-3">
                <input type="password" class="form-control" name="set_password">
            </div>
            <label>Yeni Şifreniz Tekrar</label>
            <div class="input-group input-group-sm mb-3">
                <input type="password" class="form-control" name="set_password_again">
            </div>
            <hr>
            <input type="hidden" name="submit_set_password" value="1">
            <button type="submit" class="btn btn-primary">Şifreyi Değiştir</button>
        </form>
    </div><!-- Form-Body -->
</div><!-- Row -->
</div><!-- Col-Sm-10 -->
<?php require view('static/footer') ?>

