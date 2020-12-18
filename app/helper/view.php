<?php

function User_Follower($user_id){
    global $db;
    $query = $db->from('follows')
        ->where('user_id' , $user_id)
        ->all();
    return $query;
}

function User_Follow($user_id){
    global $db;
    $query = $db->from('follows')
        ->where('follow_user_id' , $user_id)
        ->all();
    return $query;
}

function User_Tuut_Like($user_id,$tuut_id){
    global $db;
    $query = $db->from('likes')
        ->where('user_id' , $user_id)
        ->where('tuut_id' , $tuut_id)
        ->all();
    return $query;
}

function User_Tuut_Unlike($user_id,$tuut_id){
    global $db;
    $query = $db->from('unlikes')
        ->where('user_id' , $user_id)
        ->where('tuut_id' , $tuut_id)
        ->all();
    return $query;
}

function Tuut_Count($tuut_id){
    global $db;
    $tuut_likes = $db->from('likes')
        ->where('tuut_id' , $tuut_id)
        ->all();
    $tuut_unlikes = $db->from('unlikes')
        ->where('tuut_id' , $tuut_id)
        ->all();
    if (count($tuut_likes) > count($tuut_unlikes)){
        return "+" . (count($tuut_likes) - count($tuut_unlikes));
    } elseif (count($tuut_likes) == count($tuut_unlikes)){
        return (count($tuut_likes) - count($tuut_unlikes));
    } else {
        return "-" . (count($tuut_unlikes) - count($tuut_likes));
    }

}

function Tuut_Comments($tuut_id){
    global $db;
    $query = $db->from('comments')
        ->where('tuut_id' , $tuut_id)
        ->join('users', '%s.user_id = %s.user_id')
        ->all();
    return $query;
}

function User_Tuut_Comment_Like($user_id,$comment_id){
    global $db;
    $query = $db->from('comment_likes')
        ->where('user_id' , $user_id)
        ->where('comment_id' , $comment_id)
        ->all();
    return $query;
}

function User_Tuut_Comment_Unlike($user_id,$comment_id){
    global $db;
    $query = $db->from('comment_unlikes')
        ->where('user_id' , $user_id)
        ->where('comment_id' , $comment_id)
        ->all();
    return $query;
}

function Tuut_Comment_Count($comment_id){
    global $db;
    $comment_likes = $db->from('comment_likes')
        ->where('comment_id' , $comment_id)
        ->all();
    $comment_unlikes = $db->from('comment_unlikes')
        ->where('comment_id' , $comment_id)
        ->all();
    if (count($comment_likes) > count($comment_unlikes)){
        return "+" . (count($comment_likes) - count($comment_unlikes));
    } elseif (count($comment_likes) == count($comment_unlikes)){
        return (count($comment_likes) - count($comment_unlikes));
    } else {
        return "-" . (count($comment_unlikes) - count($comment_likes));
    }

}

function Tuut_Likes_User($user_id){
    global $db;
    $user_tuuts = $db->from('tuuts')
        ->where('user_id', $user_id)
        ->all();
    $user_likes = [];
    foreach ($user_tuuts as $key => $item){
        $user_likes_that = $db->from('likes')
            ->where('tuut_id', $item['tuut_id'])
            ->first();
        if (!empty($user_likes_that)){
            $user_likes[] = $user_likes_that;
        }
    }
    return $user_likes;
}

function Tuut_Unlikes_User($user_id){
    global $db;
    $user_tuuts = $db->from('tuuts')
        ->where('user_id', $user_id)
        ->all();
    $user_unlikes = [];
    foreach ($user_tuuts as $key => $item){
        $user_unlikes_that = $db->from('unlikes')
            ->where('tuut_id', $item['tuut_id'])
            ->first();
        if (!empty($user_unlikes_that)){
            $user_unlikes[] = $user_unlikes_that;
        }
    }
    return $user_unlikes;
}

function Actor($id){

    global $db;
    $query = $db->from('movies')
        ->like('movie_cast' , $id)
        ->select('movie_id')
        ->all();
    $query = array_column($query, 'movie_id');

    foreach ($query as $key => $row){
        $query2 = $db->from('ratings')
            ->where('rating_type' , 'movie')
            ->where('prod_id' , $row)
            ->select('rating_number')
            ->all();
        $query3 = $db->from('movies')
            ->where('movie_id' , $row)
            ->all();
        if (!$query2){
            $rating = 'N/A';
            return $rating;
        } else {
            $rating = array_column($query2, 'rating_number');
            $rating = array_sum($rating)/count($rating);
            $rating_arr = [];
            $rating_arr [] = floor($rating).'%';
        }

    }

    return $rating_arr;

}

function Rating($id,$type)
{
    global $db;
    if ($type == 'series'){
        $query = $db->from('ratings')
            ->where('rating_type' , $type)
            ->where('prod_id' , $id)
            ->select('rating_number')
            ->all();
        if (!$query) {
            $query2 = $db->from('episodes')
                ->where('series_id', $id)
                ->select('episode_id')
                ->all();
            $rating_episodes = [];
            $query2 = array_column($query2, 'episode_id');
            foreach ($query2 as $key => $episode) {
                $query3 = $db->from('ratings')
                    ->where('rating_type', 'episode')
                    ->where('prod_id', $episode)
                    ->select('rating_number')
                    ->all();
                if ($query3){
                    $rating = array_column($query3, 'rating_number');
                    $rating = floor(array_sum($rating)/count($rating));
                    $rating_episodes[] = $rating;
                }
            }
            if (empty($rating_episodes)){
                $rating = 'N/A';
                return $rating;
            } else {
                return floor(array_sum($rating_episodes) / count($rating_episodes));
            }
        } else {
            $rating_series = array_column($query, 'rating_number');
            $rating_series = floor(array_sum($rating_series)/count($rating_series));

            $query2 = $db->from('episodes')
                ->where('series_id', $id)
                ->select('episode_id')
                ->all();
            $rating_episodes = [];
            $query2 = array_column($query2, 'episode_id');
            foreach ($query2 as $key => $episode) {
                $query3 = $db->from('ratings')
                    ->where('rating_type', 'episode')
                    ->where('prod_id', $episode)
                    ->select('rating_number')
                    ->all();
                if ($query3){
                    $rating = array_column($query3, 'rating_number');
                    $rating = floor(array_sum($rating)/count($rating));
                    $rating_episodes[] = $rating;
                }
            }
            if (empty($rating_episodes)){
                return $rating_series;
            } else {
                $rating_episodes = floor(array_sum($rating_episodes)/count($rating_episodes));
                return floor(($rating_series + $rating_episodes) / 2);
            }
        }
    } else {
        $query = $db->from('ratings')
            ->where('rating_type' , $type)
            ->where('prod_id' , $id)
            ->select('rating_number')
            ->all();
        if (!$query){
            $rating = 'N/A';
            return $rating;
        } else {
            $rating = array_column($query, 'rating_number');
            $rating = array_sum($rating)/count($rating);
            return floor($rating);
        }
    }
}

function RatingColor($rating_func){
    if ($rating_func == 'N/A'){
        return 'meter-grey';
    } elseif ($rating_func <= 25){
        return 'meter-red';
    } elseif ($rating_func > 25 && $rating_func <= 50 ){
        return 'meter-orange';

    } elseif ($rating_func > 50 && $rating_func <= 75){
        return 'meter-yellow';

    } elseif ($rating_func > 75 && $rating_func <= 90){
        return 'meter-green-yellow';

    } elseif ($rating_func > 90 ){
        return 'meter-green';

    } else {
        return 'meter-gray';
    }
}


function Categories($genre_title)
{
    $genre_title = explode(', ', $genre_title);
    return $genre_title;
}

function MovieTime($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return "N/A";
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
function SeriesTime($time, $format = '%02d')
{
    if ($time < 1) {
        return "N/A";
    }
    $minutes = $time;
    return sprintf($format, $minutes);
}

function MovieCountry($movie_country_data)
{
    $char_map = [
        'Andorra' => 'Andorra',
        'United Arab Emirates' => 'Birleşik Arap Emirlikleri',
        'Afghanistan' => 'Afganistan',
        'Antigua and Barbuda' => 'Antigua ve Barbuda',
        'Anguilla' => 'Anguilla',
        'Albania' => 'Arnavutluk',
        'Armenia' => 'Ermenistan',
        'Angola' => 'Angola',
        'Antarktika' => 'Antarktika',
        'Argentina' => 'Arjantin',
        'American Samoa' => 'Amerikan Samoası',
        'Austria' => 'Avusturya',
        'Australia' => 'Avustralya',
        'Aruba' => 'Aruba',
        'Azerbaijan' => 'Azerbaycan',
        'Bosnia and Herzegovina' => 'Bosna-Hersek',
        'Barbados' => 'Barbados',
        'Bangladesh' => 'Bangladeş',
        'Belgium' => 'Belçika',
        'Burkina Faso' => 'Burkina Faso',
        'Bulgaria' => 'Bulgaristan',
        'Bahrain' => 'Bahreyn',
        'Burundi' => 'Burundi',
        'Benin' => 'Benin',
        'St Barts' => 'Saint Barthelemy',
        'Bermuda' => 'Bermuda',
        'Brunei' => 'Brunei',
        'Bolivia' => 'Bolivya',
        'Brazil' => 'Brezilya',
        'Bahamas' => 'Bahamalar',
        'Bhutan' => 'Bhutan',
        'Bouvet Island' => 'Bouvet Adası',
        'Botswana' => 'Botsvana',
        'Belarus' => 'Beyaz Rusya',
        'Belize' => 'Belize',
        'Canada' => 'Kanada',
        'Cocos Island' => 'Cocos (Keyling) Adaları',
        'Democratic Republic of Congo' => 'Demokratik Kongo Cumhuriyeti',
        'Central African Republic' => 'Orta Afrika Cumhuriyeti',
        'Republic of The Congo' => 'Kongo Cumhuriyeti',
        'Switzerland' => 'İsviçre',
        'Ivory Coast' => 'Fildişi Sahili',
        'Cook Islands' => 'Cook Adaları',
        'Chile' => 'Şili',
        'Cameroon' => 'Kamerun',
        'China' => 'Çin',
        'Colombia' => 'Kolombiya',
        'Costa Rica' => 'Kosta Rika',
        'Cuba' => 'Küba',
        'Cape Verde' => 'Yeşil Burun Adaları',
        'Curacao' => 'Curaçao',
        'Cyprus' => 'Kıbrıs',
        'Czech Republic' => 'Çek Cumhuriyeti',
        'Germany' => 'Almanya',
        'Djibouti' => 'Cibuti',
        'Denmark' => 'Danimarka',
        'Dominica' => 'Dominika',
        'Dominican Republic' => 'Dominik Cumhuriyeti',
        'Algeria' => 'Cezayir',
        'Ecuador' => 'Ekvador',
        'Estonia' => 'Estonya',
        'Egypt' => 'Mısır',
        'Sahrawi Arab Democratic Republic' => 'Batı Sahra',
        'Eritrea' => 'Eritre',
        'Spain' => 'İspanya',
        'Ethiopia' => 'Etiyopya',
        'Finland' => 'Finlandiya',
        'Fiji' => 'Fiji',
        'Falkland Islands' => 'Falkland Adaları (Islas Malvinas)',
        'Micronesia' => 'Mikronezya Federal Devletleri',
        'Faroe Islands' => 'Faroe Adaları',
        'France' => 'Fransa',
        'Gabon' => 'Gabon',
        'United Kingdom' => 'Birleşik Krallık',
        'Grenada' => 'Grenada',
        'Georgia' => 'Gürcistan',
        'Guernsey' => 'Guernsey',
        'Ghana' => 'Gana',
        'Gibraltar' => 'Cebelitarık',
        'Greenland' => 'Grönland',
        'Gambia' => 'Gambiya',
        'Guinea' => 'Gine',
        'Equatorial Guinea' => 'Ekvator Ginesi',
        'Greece' => 'Yunanistan',
        'Guatemala' => 'Guatemala',
        'Guam' => 'Guam',
        'Guinea Bissau' => 'Gine-Bissau',
        'Guyana' => 'Guyana',
        'Hong Kong' => 'Hong Kong',
        'Honduras' => 'Honduras',
        'Croatia' => 'Hırvatistan',
        'Haiti' => 'Haiti',
        'Hungary' => 'Macaristan',
        'Indonesia' => 'Endonezya',
        'Ireland' => 'İrlanda',
        'Israel' => 'İsrail',
        'Isle of Man' => 'Man Adası',
        'India' => 'Hindistan',
        'British Indian Ocean Territory' => 'Britanya Hint Okyanusu Toprakları',
        'Iraq' => 'Irak',
        'Iran' => 'İran',
        'Iceland' => 'İzlanda',
        'Italy' => 'İtalya',
        'Jersey' => 'Jersey',
        'Jamaica' => 'Jamaika',
        'Jordan' => 'Ürdün',
        'Japan' => 'Japonya',
        'Kenya' => 'Kenya',
        'Kyrgyzstan' => 'Kırgızistan',
        'Cambodia' => 'Kamboçya',
        'Kiribati' => 'Kiribati',
        'Comoros' => 'Komorlar',
        'Saint Kitts and Nevis' => 'Saint Kitts ve Nevis',
        'North Korea' => 'Kuzey Kore',
        'South Korea' => 'Güney Kore',
        'Kwait' => 'Kuveyt',
        'Cayman Islands' => 'Cayman Adaları',
        'Kazakhstan' => 'Kazakistan',
        'Laos' => 'Laos',
        'Lebanon' => 'Lübnan',
        'St Lucia' => 'Saint Lucia',
        'Liechtenstein' => 'Lihtenştayn',
        'Sri Lanka' => 'Sri Lanka',
        'Liberia' => 'Liberya',
        'Lesotho' => 'Lesotho',
        'Lithuania' => 'Litvanya',
        'Luxembourg' => 'Lüksemburg',
        'Latvia' => 'Letonya',
        'Libya' => 'Libya',
        'Morocco' => 'Fas',
        'Monaco' => 'Monako',
        'Moldova' => 'Moldova',
        'Montenegro' => 'Karadağ',
        'Madagascar' => 'Madagaskar',
        'Marshall Island' => 'Marshall Adaları',
        'Republic of Macedonia' => 'Makedonya',
        'Mali' => 'Mali',
        'Myanmar' => 'Burma',
        'Mongolia' => 'Moğolistan',
        'Macao' => 'Makao',
        'Northern Marianas Islands' => 'Kuzey Mariana Adaları',
        'Martinique' => 'Martinique',
        'Mauritania' => 'Moritanya',
        'Montserrat' => 'Montserrat',
        'Malta' => 'Malta',
        'Mauritius' => 'Mauritius',
        'Maldives' => 'Maldivler',
        'Malawi' => 'Malavi',
        'Mexico' => 'Meksika',
        'Malasya' => 'Malezya',
        'Mozambique' => 'Mozambik',
        'Namibia' => 'Namibya',
        'New Caledonia' => 'Yeni Kaledonya',
        'Niger' => 'Nijer',
        'Norfolk Island' => 'Norfolk Adası',
        'Nigeria' => 'Nijerya',
        'Nicaragua' => 'Nikaragua',
        'Netherlands' => 'Hollanda',
        'Norway' => 'Norveç',
        'Nepal' => 'Nepal',
        'Nauru' => 'Nauru',
        'Niue' => 'Niue',
        'New Zealand' => 'Yeni Zelanda',
        'Oman' => 'Umman',
        'Panama' => 'Panama',
        'Peru' => 'Peru',
        'French Polynesia' => 'Fransız Polinezyası',
        'Papua New Guinea' => 'Papua Yeni Gine',
        'Philippines' => 'Filipinler',
        'Pakistan' => 'Pakistan',
        'Poland' => 'Polonya',
        'Pitcairn Islands' => 'Pitcairn Adaları',
        'Puerto Rico' => 'Porto Riko',
        'Palestine' => 'Filistin',
        'Portugal' => 'Portekiz',
        'Palau' => 'Palau',
        'Paraguay' => 'Paraguay',
        'Qatar' => 'Katar',
        'Romania' => 'Romanya',
        'Serbia' => 'Sırbistan',
        'Russia' => 'Rusya',
        'Rwanda' => 'Ruanda',
        'Saudi Arabia' => 'Suudi Arabistan',
        'Solomon Islands' => 'Solomon Adaları',
        'Seychelles' => 'Seyşeller',
        'Sudan' => 'Sudan',
        'Sweden' => 'İsveç',
        'Singapore' => 'Singapur',
        'Slovenia' => 'Slovenya',
        'Slovakia' => 'Slovakya',
        'Sierra Leone' => 'Sierra Leone',
        'San Marino' => 'San Marino',
        'Senegal' => 'Senegal',
        'Somalia' => 'Somali',
        'Suriname' => 'Surinam',
        'South Sudan' => 'Güney Sudan',
        'Sao Tome and Prince' => 'Sao Tome ve Principe',
        'El Salvador' => 'El Salvador',
        'Sint Maarten' => 'Saint Martin',
        'Syria' => 'Suriye',
        'Swaziland' => 'Svaziland',
        'Turks and Caicos' => 'Turks ve Caicos Adaları',
        'Chad' => 'Çad',
        'Togo' => 'Togo',
        'Thailand' => 'Tayland',
        'Tajikistan' => 'Tacikistan',
        'Tokelau' => 'Tokelau',
        'East Timor' => 'Doğu Timor',
        'Turkmenistan' => 'Türkmenistan',
        'Tunisia' => 'Tunus',
        'Tonga' => 'Tonga',
        'Turkey' => 'Türkiye',
        'Trinidad and Tobago' => 'Trinidad ve Tobago',
        'Tuvalu' => 'Tuvalu',
        'Taiwan' => 'Tayvan',
        'Tanzania' => 'Tanzanya',
        'Ukraine' => 'Ukrayna',
        'Uganda' => 'Uganda',
        'United Nations' => 'Birleşmiş Milletler',
        'United States of America' => 'ABD',
        'Uruguay' => 'Uruguay',
        'Uzbekistn' => 'Özbekistan',
        'Vatican City' => 'Vatikan',
        'St Vincent and The Grenadines' => 'Saint Vincent ve Grenadinler',
        'Venezuela' => 'Venezuela',
        'British Virgin Islands' => 'Britanya Virjin Adaları',
        'Virgin Islands' => 'Virjin Adaları',
        'Vietnam' => 'Vietnam',
        'Vanuatu' => 'Vanuatu',
        'Samoa' => 'Samoa',
        'Kosovo' => 'Kosova',
        'Yemen' => 'Yemen',
        'South Africa' => 'Güney Afrika',
        'Zambia' => 'Zambiya',
        'Zimbabwe' => 'Zimbabve',
        ];
    $str = strtr($movie_country_data , $char_map);
    return $str;

}

function SeriesCountry($series_country_data)
{
    $char_map = [
        'TR' => 'Türkiye',
        'VI' => 'ABD Virgin Adaları',
        'AF' => 'Afganistan',
        'AX' => 'Aland Adaları',
        'DE' => 'Almanya',
        'US' => 'ABD',
        'UM' => 'Amerika Birleşik Devletleri Küçük Dış Adaları',
        'AS' => 'Amerikan Samoası',
        'AD' => 'Andora',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarktika',
        'AG' => 'Antigua ve Barbuda',
        'AR' => 'Arjantin',
        'AL' => 'Arnavutluk',
        'AW' => 'Aruba',
        'QU' => 'Avrupa Birliği',
        'AU' => 'Avustralya',
        'AT' => 'Avusturya',
        'AZ' => 'Azerbaycan',
        'BS' => 'Bahamalar',
        'BH' => 'Bahreyn',
        'BD' => 'Bangladeş',
        'BB' => 'Barbados',
        'EH' => 'Batı Sahara',
        'BZ' => 'Belize',
        'BE' => 'Belçika',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BY' => 'Beyaz Rusya',
        'BT' => 'Bhutan',
        'ZZ' => 'Bilinmeyen veya Geçersiz Bölge',
        'AE' => 'Birleşik Arap Emirlikleri',
        'GB' => 'Birleşik Krallık',
        'BO' => 'Bolivya',
        'BA' => 'Bosna Hersek',
        'BW' => 'Botsvana',
        'BV' => 'Bouvet Adası',
        'BR' => 'Brezilya',
        'BN' => 'Brunei',
        'BG' => 'Bulgaristan',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'CV' => 'Cape Verde',
        'GI' => 'Cebelitarık',
        'DZ' => 'Cezayir',
        'CX' => 'Christmas Adası',
        'DJ' => 'Cibuti',
        'CC' => 'Cocos Adaları',
        'CK' => 'Cook Adaları',
        'TD' => 'Çad',
        'CZ' => 'Çek Cumhuriyeti',
        'CN' => 'Çin',
        'DK' => 'Danimarka',
        'DM' => 'Dominik',
        'DO' => 'Dominik Cumhuriyeti',
        'TL' => 'Doğu Timor',
        'EC' => 'Ekvator',
        'GQ' => 'Ekvator Ginesi',
        'SV' => 'El Salvador',
        'ID' => 'Endonezya',
        'ER' => 'Eritre',
        'AM' => 'Ermenistan',
        'EE' => 'Estonya',
        'ET' => 'Etiyopya',
        'FK' => 'Falkland Adaları (Malvinalar)',
        'FO' => 'Faroe Adaları',
        'MA' => 'Fas',
        'FJ' => 'Fiji',
        'CI' => 'Fildişi Sahilleri',
        'PH' => 'Filipinler',
        'PS' => 'Filistin Bölgesi',
        'FI' => 'Finlandiya',
        'FR' => 'Fransa',
        'GF' => 'Fransız Guyanası',
        'TF' => 'Fransız Güney Bölgeleri',
        'PF' => 'Fransız Polinezyası',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GH' => 'Gana',
        'GN' => 'Gine',
        'GW' => 'Gine-Bissau',
        'GD' => 'Granada',
        'GL' => 'Grönland',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GY' => 'Guyana',
        'ZA' => 'Güney Afrika',
        'GS' => 'Güney Georgia ve Güney Sandwich Adaları',
        'KR' => 'Güney Kore',
        'CY' => 'Güney Kıbrıs Rum Kesimi',
        'GE' => 'Gürcistan',
        'HT' => 'Haiti',
        'HM' => 'Heard Adası ve McDonald Adaları',
        'IN' => 'Hindistan',
        'IO' => 'Hint Okyanusu İngiliz Bölgesi',
        'NL' => 'Hollanda',
        'AN' => 'Hollanda Antilleri',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong SAR - Çin',
        'HR' => 'Hırvatistan',
        'IQ' => 'Irak',
        'VG' => 'İngiliz Virgin Adaları',
        'IR' => 'İran',
        'IE' => 'İrlanda',
        'ES' => 'İspanya',
        'IL' => 'İsrail',
        'SE' => 'İsveç',
        'CH' => 'İsviçre',
        'IT' => 'İtalya',
        'IS' => 'İzlanda',
        'JM' => 'Jamaika',
        'JP' => 'Japonya',
        'JE' => 'Jersey',
        'KH' => 'Kamboçya',
        'CM' => 'Kamerun',
        'CA' => 'Kanada',
        'ME' => 'Karadağ',
        'QA' => 'Katar',
        'KY' => 'Kayman Adaları',
        'KZ' => 'Kazakistan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'CO' => 'Kolombiya',
        'KM' => 'Komorlar',
        'CG' => 'Kongo',
        'CD' => 'Kongo Demokratik Cumhuriyeti',
        'CR' => 'Kosta Rika',
        'KW' => 'Kuveyt',
        'KP' => 'Kuzey Kore',
        'MP' => 'Kuzey Mariana Adaları',
        'CU' => 'Küba',
        'KG' => 'Kırgızistan',
        'LA' => 'Laos',
        'LS' => 'Lesotho',
        'LV' => 'Letonya',
        'LR' => 'Liberya',
        'LY' => 'Libya',
        'LI' => 'Liechtenstein',
        'LT' => 'Litvanya',
        'LB' => 'Lübnan',
        'LU' => 'Lüksemburg',
        'HU' => 'Macaristan',
        'MG' => 'Madagaskar',
        'MO' => 'Makao S.A.R. Çin',
        'MK' => 'Makedonya',
        'MW' => 'Malavi',
        'MV' => 'Maldivler',
        'MY' => 'Malezya',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'IM' => 'Man Adası',
        'MH' => 'Marshall Adaları',
        'MQ' => 'Martinik',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Meksika',
        'FM' => 'Mikronezya Federal Eyaletleri',
        'MD' => 'Moldovya Cumhuriyeti',
        'MC' => 'Monako',
        'MS' => 'Montserrat',
        'MR' => 'Moritanya',
        'MZ' => 'Mozambik',
        'MN' => 'Moğolistan',
        'MM' => 'Myanmar',
        'EG' => 'Mısır',
        'NA' => 'Namibya',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NE' => 'Nijer',
        'NG' => 'Nijerya',
        'NI' => 'Nikaragua',
        'NU' => 'Niue',
        'NF' => 'Norfolk Adası',
        'NO' => 'Norveç',
        'CF' => 'Orta Afrika Cumhuriyeti',
        'UZ' => 'Özbekistan',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PA' => 'Panama',
        'PG' => 'Papua Yeni Gine',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PN' => 'Pitcairn',
        'PL' => 'Polonya',
        'PT' => 'Portekiz',
        'PR' => 'Porto Riko',
        'RE' => 'Reunion',
        'RO' => 'Romanya',
        'RW' => 'Ruanda',
        'RU' => 'Rusya Federasyonu',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts ve Nevis',
        'LC' => 'Saint Lucia',
        'PM' => 'Saint Pierre ve Miquelon',
        'VC' => 'Saint Vincent ve Grenadinler',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome ve Principe',
        'SN' => 'Senegal',
        'SC' => 'Seyşeller',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapur',
        'SK' => 'Slovakya',
        'SI' => 'Slovenya',
        'SB' => 'Solomon Adaları',
        'SO' => 'Somali',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Surinam',
        'SY' => 'Suriye',
        'SA' => 'Suudi Arabistan',
        'SJ' => 'Svalbard ve Jan Mayen',
        'SZ' => 'Svaziland',
        'RS' => 'Sırbistan',
        'CS' => 'Sırbistan-Karadağ',
        'CL' => 'Şili',
        'TJ' => 'Tacikistan',
        'TZ' => 'Tanzanya',
        'TH' => 'Tayland',
        'TW' => 'Tayvan',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad ve Tobago',
        'TN' => 'Tunus',
        'TC' => 'Turks ve Caicos Adaları',
        'TV' => 'Tuvalu',
        'TM' => 'Türkmenistan',
        'UG' => 'Uganda',
        'UA' => 'Ukrayna',
        'OM' => 'Umman',
        'UY' => 'Uruguay',
        'QO' => 'Uzak Okyanusya',
        'JO' => 'Ürdün',
        'VU' => 'Vanuatu',
        'VA' => 'Vatikan',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'WF' => 'Wallis ve Futuna',
        'YE' => 'Yemen',
        'NC' => 'Yeni Kaledonya',
        'NZ' => 'Yeni Zelanda',
        'GR' => 'Yunanistan',
        'ZM' => 'Zambiya',
        'ZW' => 'Zimbabve'
    ];
    $str = strtr($series_country_data , $char_map);
    return $str;

}

function MovieDate($movie_date)
{
    return turkcetarih_formati('j F Y',$movie_date);
}

function SeriesDate($series_date)
{
    $series_date = explode('*', $series_date);
    $series_date[0] = explode('-', $series_date[0]);
    $series_date[0] = $series_date[0][2];
    $series_date[1] = explode('-', $series_date[1]);
    $series_date[1] = $series_date[1][2];
    if ($series_date[0] == $series_date[1]){
        return $series_date[0];
    }
    $series_date = implode('-', $series_date);
    return $series_date;
}

function Movie_Cast($movie_id,$count=false)
{
    global $db;
    $query = $db->from('movies')
        ->where('movie_id', $movie_id)
        ->select('movie_cast')
        ->first();
    if (!$query){
        $cast = 'N/A';
        return $cast;
    } else {
        $query2 = json_decode($query['movie_cast'], true);
        $movie_cast = [];
        foreach ($query2 as $key => $val){
            $row = $db->from('persons')
                ->where('person_id', $val['id'])
                ->first();
            $movie_cast[] = [
                'id' => $row['person_id'],
                'name' => $row['person_name'],
                'img' => $row['person_img'],
                'char' => $val['char'],
            ];
        }
        if ($count){
            return array_slice($movie_cast, 0, $count);
        } else {
            return $movie_cast;
        }
    }
}

function Movie_Director($movie_id)
{
    global $db;
    $query = $db->from('movies')
        ->where('movie_id', $movie_id)
        ->like('movie_crew' , 'Directing')
        ->first();
    if (!$query){
        $crew = 'N/A';
        return $crew;
    } else {
        $query2 = json_decode($query['movie_crew'], true);
        $person_movie = [];
        foreach ($query2 as $key => $val){
           if ($val['department'] == 'Directing'){
               $row = $db->from('persons')
                   ->where('person_id', $val['id'])
                   ->first();
               $person_movie[] = [
                   'id' => $row['person_id'],
                   'name' => $row['person_name'],
                   'department' => $val['department'],
                   'img' => $row['person_img']
               ];
           }
        }
        return $person_movie;
    }
}

function Movie_Writing($movie_id)
{
    global $db;
    $query = $db->from('movies')
        ->where('movie_id', $movie_id)
        ->like('movie_crew' , 'Writing')
        ->first();
    if (!$query){
        $crew = 'N/A';
        return $crew;
    } else {
        $query2 = json_decode($query['movie_crew'], true);
        $person_movie = [];
        foreach ($query2 as $key => $val){
            if ($val['department'] == 'Writing'){
                $row = $db->from('persons')
                    ->where('person_id', $val['id'])
                    ->first();
                $person_movie[] = [
                    'id' => $row['person_id'],
                    'name' => $row['person_name'],
                    'department' => $val['department'],
                    'img' => $row['person_img']
                ];
            }
        }
        return $person_movie;
    }
}

function Series_Cast($series_id)
{
    global $db;
    $query = $db->from('series')
        ->where('series_id', $series_id)
        ->select('series_cast')
        ->first();
    if (!$query){
        $cast = 'N/A';
        return $cast;
    } else {
        $query2 = json_decode($query['series_cast'], true);
        $series_cast = [];
        foreach ($query2 as $key => $val){
            $row = $db->from('persons')
                ->where('person_id', $val['id'])
                ->first();
            $series_cast[] = [
                'id' => $row['person_id'],
                'name' => $row['person_name'],
            ];
        }
        return $series_cast;
    }
}

function Series_Production($series_id)
{
    global $db;
    $query = $db->from('series')
        ->where('series_id', $series_id)
        ->like('series_crew' , 'Production')
        ->first();
    if (!$query){
        $crew = 'N/A';
        return $crew;
    } else {
        $query2 = json_decode($query['series_crew'], true);
        $person_series = [];
        foreach ($query2 as $key => $val){
            $row = $db->from('persons')
                ->where('person_id', $val['id'])
                ->first();
            $person_series[] = [
                'id' => $row['person_id'],
                'name' => $row['person_name'],
                'department' => $val['department'],
            ];
        }
        return $person_series;
    }
}

function Series_Writing($series_id)
{
    global $db;
    $query = $db->from('series')
        ->where('series_id', $series_id)
        ->like('series_crew' , 'Writing')
        ->first();
    if (!$query){
        $crew = 'N/A';
        return $crew;
    } else {
        $query2 = json_decode($query['series_crew'], true);
        $person_series = [];
        foreach ($query2 as $key => $val){
            $row = $db->from('persons')
                ->where('person_id', $val['id'])
                ->first();
            $person_series[] = [
                'id' => $row['person_id'],
                'name' => $row['person_name'],
                'department' => $val['department'],
            ];
        }
        return $person_series;
    }
}

function Series_RT($series_id)
{
    global $db;
    $query = $db->from('series')
        ->where('series_id', $series_id)
        ->first();
    if ($query['series_rt'] == '7'){
        return 'Genel İzleyici Kitlesi';
    } elseif ($query['series_rt'] == '7'){
        return '7 Yaş ve Üzeri';
    } elseif ($query['series_rt'] == '13'){
        return '13 Yaş ve Üzeri';
    } elseif ($query['series_rt'] == '18'){
        return '18 Yaş ve Üzeri. Madde Kullanımı, Cinsellik, Uygunsuz Davranışlar İçerebilir.';
    } else {
        return 'Yaş sınırı sınıflandırılması bulunamadı.';
    }
}

function Age($date)
{
    return floor((time() - strtotime($date)) / (60*60*24*365));
}

function UserRank($user_id)
{
    global $db;
    $query = $db->from('ratings')
        ->where('user_id' , $user_id)
        ->select('user_id')
        ->all();
    $user_comment = array_column($query, 'user_id');

    $query2 = $db->from('likes')
        ->where('user_id' , $user_id)
        ->select('user_id')
        ->all();

    $user_like = array_column($query2, 'user_id');

    if ((count($user_comment) < 10) && (count($user_like) < 10)){
        return 1;
    } elseif ((count($user_comment) >= 10 && count($user_comment) < 20) && (count($user_like) >= 10 && count($user_like) < 20)){
        return 2;
    } elseif ((count($user_comment) >= 20 && count($user_comment) < 35) && (count($user_like) >= 20 && count($user_like) < 40)){
        return 3;
    } elseif ((count($user_comment) >= 35 && count($user_comment) <= 60) && (count($user_like) >= 40 && count($user_like) < 70)){
        return 4;
    } elseif ((count($user_comment) >= 60 && count($user_comment) <= 90) && (count($user_like) >= 70 && count($user_like) < 120)){
        return 5;
    } elseif ((count($user_comment) >= 90 && count($user_comment) <= 125) && (count($user_like) >= 120 && count($user_like) < 160)){
        return 6;
    } elseif ((count($user_comment) >= 125 && count($user_comment) <= 170) && (count($user_like) >= 160 && count($user_like) < 250)){
        return 7;
    } elseif ((count($user_comment) >= 170 && count($user_comment) <= 250) && (count($user_like) >= 250 && count($user_like) < 340)){
        return 8;
    } elseif ((count($user_comment) >= 250 && count($user_comment) <= 350) && (count($user_like) >= 340 && count($user_like) < 500)){
        return 9;
    } elseif (count($user_comment) >= 350 && count($user_like) >= 700){
        return 10;
    } else{
        return 1;
    }
}

function UserList($user_id,$prod_id,$type)
{
    global $db;
    $query = $db->from('lists')
        ->where('user_id' , $user_id)
        ->first();

    if (!$query){
        $db->insert('lists')
            ->set([
                'list_title' => 'Favori Listem',
                'user_id' => session('user_id'),
                'list_seo' => '',
            ]);
    } else {
        $prods = json_decode($query['list_productions'] , true);
        if (!$prods){
            return 0;
        } else {
            $prods = array_values(array_filter($prods));
            foreach ($prods as $key => $val){
                if (($val['type'] == $type) && ($val['id'] == $prod_id)){
                    return 1;
                }
            }
            return 0;
        }
    }
}

function UserLike($user_like_id, $rating_id)
{
    global $db;

    $query = $db->from('likes')
        ->where('like_user_id' , $user_like_id)
        ->where('rating_id' , $rating_id)
        ->first();

    return $query;

}

function LikeView($rating_id)
{

    global $db;

    $query = $db->from('likes')
        ->where('rating_id' , $rating_id)
        ->all();

    return count($query);
}

function UserCommentProd($user_id,$type = false)
{
    global $db;
    if ($type){
        $user_ratings = $db->from('ratings')
            ->where('user_id' , $user_id)
            ->where('rating_type', $type)
            ->all();
    } else {
        $user_ratings = $db->from('ratings')
            ->where('user_id' , $user_id)
            ->all();
    }
    if (!$user_ratings){
        return false;
    } else {
        foreach ($user_ratings as $key => $val){
            if ($val['rating_type'] == "movie"){
                $query = $db->from('movies')
                    ->where('movie_id', $val['prod_id'])
                    ->first();
                $prods[] = [
                    'id' => $query['movie_id'],
                    'img' => $query['movie_img'],
                    'title' => $query['movie_title'],
                    'url' => 'film/'.$query['movie_url'],
                    'type' => 'movie',
                ];
            } elseif ($val['rating_type'] == "series"){
                $query = $db->from('series')
                    ->where('series_id', $val['prod_id'])
                    ->first();
                $prods[] = [
                    'id' => $query['series_id'],
                    'img' => $query['series_img'],
                    'title' => $query['series_title'],
                    'url' => 'dizi/'.$query['series_url'],
                    'type' => 'series',
                ];
            } else {
                $query = $db->from('episodes')
                    ->where('episode_id', $val['prod_id'])
                    ->join('series', '%s.series_id = %s.series_id')
                    ->first();
                $prods[] = [
                    'id' => $query['episode_id'],
                    'img' => $query['episode_img'],
                    'title' => $query['episode_title'],
                    'url' => 'dizi/'.$query['series_url'].'/'.$query['episode_url'],
                    'type' => 'episode',
                ];
            }
        }
    }
        return $prods;
}

function BoxOffice()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://boxofficeturkiye.com/");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $site1 = curl_exec($ch);
    curl_close($ch);
    preg_match_all('@<div id="tabAdmissionsHome" class="(.*?)" data-loaded="(.*?)">(.*?)</div>@si',$site1,$site);
    $box_office = [];
    preg_match_all('@<a class="film" title="(.*?)" href="(.*?)">(.*?)</a>@si',$site[0][0],$box_office['film'],PREG_SET_ORDER);
    preg_match_all('@<td class="cell-week">(.*?)</td>@si',$site[0][0],$box_office['hafta'],PREG_SET_ORDER);
    preg_match_all('@<td class="cell-total-admissions">(.*?)</td>@si',$site[0][0],$box_office['seyirci'],PREG_SET_ORDER);

    for ($i=0; $i<5; $i++){
        $box_office_result[] = [
            'film' => $box_office['film'][$i][3],
            'hafta' => $box_office['hafta'][$i][1],
            'hs_seyirci' => $box_office['seyirci'][2*$i][1],
            'toplam_seyirci' => $box_office['seyirci'][2*$i+1][1],
        ];
    }
    return $box_office_result;

}

function PopularPages()
{
    global $db;
    $popular_pages = file_get_contents( PATH . '/app/popular_page.php' );
    $popular_pages = json_decode($popular_pages , true);
    foreach ($popular_pages as $key => $val){
        $needle = dirname( $val['url']);
        if (strstr($needle, 'film') !== false){
            $movie_url = basename( $val['url']);
            $query[$key] = $db->from('movies')
                ->where('movie_url' , $movie_url)
                ->first();
        }
    }
    return $query;
}

function UserCommentGrade($user_id)
{
    global $db;
    $query = $db->from('ratings')
        ->where('user_id' , $user_id)
        ->select('user_id')
        ->all();
    $user_comment_number = count(array_column($query, 'user_id'));
    $user_rank = UserRank($user_id);
    if ($user_rank == 1){
        return $user_comment_number*10;
    } elseif ($user_rank == 2){
        return ($user_comment_number - 10) * 10;
    } elseif ($user_comment_number == 3){
        return ($user_comment_number - 20) * 6.6;
    } elseif ($user_comment_number == 4) {
        return ($user_comment_number - 35) * 4;
    } elseif ($user_comment_number == 5) {
        return ($user_comment_number - 60) * 3.3;
    } elseif ($user_comment_number == 6) {
        return ($user_comment_number - 90) * 2.8;
    } elseif ($user_comment_number == 7) {
        return ($user_comment_number - 125) * 2.2;
    } elseif ($user_comment_number == 8) {
        return ($user_comment_number - 170) * 1.6;
    } elseif ($user_comment_number == 9) {
        return ($user_comment_number - 250) * 1;
    }

}

function UserLikeGrade($user_id)
{
    global $db;
    $query = $db->from('likes')
        ->where('user_id' , $user_id)
        ->select('user_id')
        ->all();
    $user_like_number = count(array_column($query, 'user_id'));
    $user_rank = UserRank($user_id);
    if ($user_rank == 1){
        return $user_like_number*10;
    } elseif ($user_rank == 2){
        return ($user_like_number - 10) * 10;
    } elseif ($user_like_number == 3){
        return ($user_like_number - 20) * 5;
    } elseif ($user_like_number == 4) {
        return ($user_like_number - 40) * 3.3;
    } elseif ($user_like_number == 5) {
        return ($user_like_number - 70) * 2;
    } elseif ($user_like_number == 6) {
        return ($user_like_number - 120) * 2.5;
    } elseif ($user_like_number == 7) {
        return ($user_like_number - 160) * 1.1;
    } elseif ($user_like_number == 8) {
        return ($user_like_number - 250) * 1.1;
    } elseif ($user_like_number == 9) {
        return ($user_like_number - 340) * 0.27;
    }

}