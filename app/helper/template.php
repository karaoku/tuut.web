<?php

if(!isset($_SESSION))
{
    session_start();
}

function site_url($url = false)
{
    return URL . '/' . $url;
}

function public_url($url = false)
{
    return URL . '/public/themes/' . setting('theme'). '/' . $url;
}

function upload_url($url = false)
{
    return URL . '/upload/'. $url;
}

function tuuts_upload_url($url = false)
{
    return URL . '/upload/tuuts_image/'. $url;
}

function users_upload_url($url = false)
{
    return URL . '/upload/users_image/'. $url;
}

function error_sign_up()
{
    global $error_sign_up;
    return isset($error_sign_up) ? $error_sign_up : null;
}

function success_sign_up()
{
    global $success_sign_up;
    return isset($success_sign_up) ? $success_sign_up : null;
}

function error_login()
{
    global $error_login;
    return isset($error_login) ? $error_login : null;
}

function success_login()
{
    global $success_login;
    return isset($success_login) ? $success_login : null;
}

function error_activation()
{
    global $error_activation;
    return isset($error_activation) ? $error_activation : null;
}

function success_forget_pass()
{
    global $success_forget_pass;
    return isset($success_forget_pass) ? $success_forget_pass : null;
}

function error_forget_pass()
{
    global $error_forget_pass;
    return isset($error_forget_pass) ? $error_forget_pass : null;
}

function menu($id)
{
    global $db;
    $query = $db->prepare('SELECT * FROM menus WHERE menu_id = :id');
    $query->execute([
        'id' => $id,
    ]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row){
        $data = json_decode($row['menu_content'] , true);
        return $data;
    }
    return false;
}

function cut_text($str , $limit = 220)
{
    $str = strip_tags(htmlspecialchars_decode($str));
    $length = strlen($str);
    if ($length > $limit){
        $str = mb_substr($str, 0, $limit, 'UTF8') . '...';
    }
    return $str;
}

function turkcetarih_formati($format, $datetime = 'now'){
    $z = date("$format", strtotime($datetime));
    $gun_dizi = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'   => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday'  => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'  => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'   => 'Ocak',
        'February'  => 'Şubat',
        'March'     => 'Mart',
        'April'     => 'Nisan',
        'May'       => 'Mayıs',
        'June'      => 'Haziran',
        'July'      => 'Temmuz',
        'August'    => 'Ağustos',
        'September' => 'Eylül',
        'October'   => 'Ekim',
        'November'  => 'Kasım',
        'December'  => 'Aralık',
        'Mon'       => 'Pts',
        'Tue'       => 'Sal',
        'Wed'       => 'Çar',
        'Thu'       => 'Per',
        'Fri'       => 'Cum',
        'Sat'       => 'Cts',
        'Sun'       => 'Paz',
        'Jan'       => 'Oca',
        'Feb'       => 'Şub',
        'Mar'       => 'Mar',
        'Apr'       => 'Nis',
        'Jun'       => 'Haz',
        'Jul'       => 'Tem',
        'Aug'       => 'Ağu',
        'Sep'       => 'Eyl',
        'Oct'       => 'Eki',
        'Nov'       => 'Kas',
        'Dec'       => 'Ara',
    );
    foreach($gun_dizi as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
}
