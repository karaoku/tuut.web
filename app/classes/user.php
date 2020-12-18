<?php

class User{

    public static function Login($data)
    {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user_nick'] = $data['user_nick'];
        $_SESSION['user_rank'] = $data['user_rank'];
        $_SESSION['user_url'] = $data['user_url'];
        $_SESSION['user_activation'] = $data['user_activation'];
        $_SESSION['user_login_date'] = $data['user_login_date'];
    }

    //mail aktivasyon için
    public static function nonLogin($data)
    {
        $_SESSION['user_nick'] = $data['user_nick'];
    }

    public static function userExistsNick($usernick)
    {
        global $db;
        $query = $db-> prepare('SELECT * FROM users WHERE user_nick = :usernick');
        $query->execute([
            'usernick' => $usernick,
        ]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function userExistsEmail($email)
    {
        global $db;
        $query2 = $db-> prepare('SELECT * FROM users WHERE user_email = :email');
        $query2->execute([
            'email' => $email,
        ]);
        return $query2->fetch(PDO::FETCH_ASSOC);
    }

    public static function Register($data)
    {
        global $db;
        $query = $db->prepare('INSERT INTO users SET user_name = :username, user_nick = :usernick, user_url = :url, user_email =:email, user_password = :password, user_rank = :rank, user_activation = :user_activation, user_token = :token, user_login_date = :login_date, user_mail_date = :mail_date');
        return $query->execute($data);
    }

    public static function SendMail($user_name, $user_email, $token)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("mail@izleyiciler.com", "TuuT");
        $email->setSubject("TuuT'a Hoşgeldiniz! - Hesabınızı Onaylayınız");
        $email->addTo($user_email, $user_name);
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html",
            "<div class='mail-box' style='float: left;width: 100%;padding: 3rem;background-color: #032458;background: linear-gradient(to right,#404040,#5f6368);'>
                    <h1 style='display: block;margin-bottom: 1rem;color: #FFF'>Hoşgeldin <span style='color: #09A5E2'>$user_name ✋</span></h1>
                    <h3 style='display: block;margin-bottom: .5rem;color: #FFF'>Aşağıdaki linke tıklayarak hesabını onayla lütfen.</h3>
                    <a href='".site_url('activation/').$token."' style='display: block;width:100%;margin-bottom:2rem;'>".site_url('activation/').$token."</a>
                    <img src='https://i.hizliresim.com/Rga0mR.png' alt='' style='width: 30%'>
                    <h2 style='display: block;margin-bottom: .5rem;color: #FFF'>🗣 Yeni tuut'lar oluşturup, mizaha katılabilirsin.</h2>
                    <h2 style='display: block;margin-bottom: 1rem;color: #FFF'>👥 Beğendiğin hesapları takip edebilirsin.</h2>
                    <p style='display: block;margin-bottom: .5rem;color: #FFF;font-size: 1rem'>🧠 Mizah kültüre destek veren bir platform olmak için birlikte çalışıyoruz.</p>
                    <p style='display: block;margin-bottom: .5rem;color: #FFF;font-size: 1rem'>😄 Sen de tuut'lar paylaşmaya başla, insanları güldürelim.</p>
                </div>"
        );
        $sendgrid = new \SendGrid('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');
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202){
            return true;
        } else {
            return false;
        }
    }

    public static function SendForgetPassMail($user)
    {
        global $db;
        $token = md5(uniqid());
        $db->update('users')
            ->where('user_id' , $user['user_id'])
            ->set([
                'user_token' => $token
            ]);
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("mail@izleyiciler.com", "TuuT");
        $email->setSubject("Şifrenizi Sıfırlayın - TuuT");
        $email->addTo($user['user_email'], $user['user_name']);
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>Sayın '".$user['user_name']."'</strong><br><h3>Şifrenizi sıfırlama talebinde bulundunuz. Eğer bunu siz yapmadıysanız lütfen bu e-posta'yı dikkate almayınız. Eğer talepte bulunan siz iseniz aşağıdaki linke tıklayınız.</h3><br><a href='".site_url('forget-password/').$token."'>".site_url('forget-password/').$token."</a>"
        );
        $sendgrid = new \SendGrid('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');
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202){
            return true;
        } else {
            return false;
        }
    }

    public static function UserInfo($user_nick)
    {
        global $db;
        $query = $db->from('users')
            ->where('user_nick', $user_nick)
            ->first();
        return $query;
    }
}
