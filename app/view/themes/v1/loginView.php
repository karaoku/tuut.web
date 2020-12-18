<?php require view('static/header') ?>
    <sub-title class="sub-title">
        <div class="container">
            <h1>Giriş</h1>
            <p>Giriş yaparak TuuT alemine gir.</p>
        </div><!-- Container -->
    </sub-title>
    <sub-header class="sub-header">
        <div class="container">
            <?php if (isset($error_login)):?>
                <div class="text-box"><?= $error_login ?></div>
            <?php endif; ?>
        </div><!-- Container -->
    </sub-header>
    <main class="main" style="margin-top: -2rem">
        <div class="container">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#eee" fill-opacity="1" d="M0,128L26.7,154.7C53.3,181,107,235,160,240C213.3,245,267,203,320,176C373.3,149,427,139,480,138.7C533.3,139,587,149,640,170.7C693.3,192,747,224,800,229.3C853.3,235,907,213,960,202.7C1013.3,192,1067,192,1120,202.7C1173.3,213,1227,235,1280,208C1333.3,181,1387,107,1413,69.3L1440,32L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path>
            </svg>
            <form method="post" style="background: #eee;padding: 2rem;margin-top: -25px;">
            <div class="input-group">
                <label>Kullanıcı Adı</label>
                <input type="text" name="user_nick">
                <label>Şifre</label>
                <input type="password" name="user_password">
            </div><!-- İnput-Group-->
            <input type="hidden" name="submit-login" value="1">
            <button type="submit" class="btn-dark">Tamamla</button>
            </form>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#eee" fill-opacity="1" d="M0,128L26.7,117.3C53.3,107,107,85,160,85.3C213.3,85,267,107,320,122.7C373.3,139,427,149,480,133.3C533.3,117,587,75,640,80C693.3,85,747,139,800,154.7C853.3,171,907,149,960,170.7C1013.3,192,1067,256,1120,282.7C1173.3,309,1227,299,1280,261.3C1333.3,224,1387,160,1413,128L1440,96L1440,0L1413.3,0C1386.7,0,1333,0,1280,0C1226.7,0,1173,0,1120,0C1066.7,0,1013,0,960,0C906.7,0,853,0,800,0C746.7,0,693,0,640,0C586.7,0,533,0,480,0C426.7,0,373,0,320,0C266.7,0,213,0,160,0C106.7,0,53,0,27,0L0,0Z"></path>
            </svg>
        </div><!-- Container -->
    </main><!-- Main -->
<?php require view('static/footer') ?>