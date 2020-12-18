<?php

$user_id = session('user_id');

if (!$user_id){
    header('Location:' . site_url('giris'));
    exit;
} else {
    if (post('submit-forming-tuut')) {

        $tuut_title = post('tuut_title');
        $tuut_title = filter_var($tuut_title, FILTER_SANITIZE_STRING); //html filter
        $tuut_desc = post('tuut_desc');
        $tuut_desc = filter_var($tuut_desc, FILTER_SANITIZE_STRING);
        $tuut_category_id = post('tuut_category');
        $tuut_file = $_FILES["tuut_file"];
        $tuut_url = generateRandomString();

        if (empty($tuut_category_id)) {
            $error_forming_tuut = "Lütfen bir kategori seçiniz.";
        } elseif (empty($tuut_file)) {
            $error_forming_tuut = "Seçilmiş bir görsel bulunmuyor.";
        } elseif (strlen($tuut_title) > 100) {
            $error_forming_tuut = "Lütfen daha kısa bir başlık giriniz veya açıklama kısmını kullanınız.";
        } elseif (strlen($tuut_desc) > 300) {
            $error_forming_tuut = "Lütfen daha kısa bir açıklama giriniz.";
        } elseif (isset($_FILES["tuut_file"])) {
            $maxsize = 1216519;
            $acceptable = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png'
            );
            if (($_FILES['tuut_file']['size'] >= $maxsize) || ($_FILES["tuut_file"]["size"] == 0)) {
                $error_forming_tuut = 'Yüklediğiniz görselin boyutu 1MB\'dan fazla. Lütfen boyutunu düşürün. Boyut=' . $_FILES["tuut_file"]["size"];
            } elseif ((!in_array($_FILES['tuut_file']['type'], $acceptable)) && (!empty($_FILES["tuut_file"]["type"]))) {
                $error_forming_tuut = 'Desteklenmeyen dosya türü. Sadece JPG, GIF veya PNG tipinde görseller yükleyebilirsiniz.';
            } else {

                $query = $db->insert('tuuts')
                    ->set([
                        'tuut_title' => $tuut_title,
                        'tuut_desc' => $tuut_desc,
                        'tuut_url' => $tuut_url,
                        'tuut_img' => $tuut_url . '.jpg',
                        'category_id' => $tuut_category_id,
                        'user_id' => session('user_id'),
                    ]);
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/tuut.web/' . '/upload/tuuts_image/';
                $target_file = $target_dir . $tuut_url . '.jpg';
                $img_url = $tuut_url . '.jpg';
                move_uploaded_file($_FILES["tuut_file"]["tmp_name"], $target_file);

            }
            if ($query) {
                header('Location:' . site_url('tuut/') . $tuut_url);
            } else {
                $error_forming_tuut = "Bir hata oluştu, lütfen tekrar deneyiniz.";
            }
        }
    }
}
require view('forming-post');