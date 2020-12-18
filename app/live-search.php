<?php

require 'init.php';
global $db;

if (isset($_GET['term'])) { // Bir terim gelip gelmediğini kontrol ediyoruz.
    $term = $_GET['term']; // Gelen terimi değişkene atıyoruz.
    /* Gelen terim ile eşleşen kayıt olup olmadığını sorguluyoruz. */
    if ($term == '') {
        exit;
    }
    $row_movies = $db->prepare("SELECT * FROM movies WHERE (movie_title LIKE '%".$term."%' OR 
         movie_original_title LIKE '%".$term."%' ) ORDER BY movie_id DESC");
    $row_movies->execute();
    $bas_movies = $row_movies->fetchAll(PDO::FETCH_ASSOC);

    $row_series = $db->prepare("SELECT * FROM series WHERE (series_title LIKE '%".$term."%' OR 
         series_original_title LIKE '%".$term."%' ) ORDER BY series_id DESC");
    $row_series->execute();
    $bas_series = $row_series->fetchAll(PDO::FETCH_ASSOC);

    /* Gelen terim ile eşleşen kayıt olup olmadığını sorguluyoruz. */
    if ($bas_movies || $bas_series){
        if ($bas_movies) { // Sorgulama sonucu dolu olursa eğer sonuçları ekrana basıyoruz.
            $query_movies = $db->prepare("SELECT * FROM movies WHERE (movie_title LIKE '%".$term."%' OR 
         movie_original_title LIKE '%".$term."%' ) ORDER BY movie_id DESC");
            $query_movies->execute();
            $bas_alt_movies = $query_movies->fetchAll(PDO::FETCH_ASSOC);

            foreach ($bas_alt_movies as $key => $row) {
                echo '
            <a href="' . site_url('film/') . $row['movie_url'] . '">
                <div class="search-item">
                    <div class="search-item-img" id="ps-s" style="background-image: url(' . site_url('upload/posters/') . $row['movie_img'] . ');"></div>
                    <div class="search-item-info">
                        <div class="fidibe-meter meter-s ' . RatingColor(Rating($row['movie_id'], 'movie')) . '">
                            <h2 id="tl-sm">
                                ' . Rating($row['movie_id'], 'movie') . '
                            </h2>
                        </div>
                        <h1 id="tl-sm">' . $row['movie_title'] . '</h1>
                        <h4 id="tl-s">' . $row['movie_original_title'] . '</h4>
                        <h4 id="tl-s">' . $row['movie_release_date'] . '</h4>
                    </div>
                </div>
            </a>
	';
            }
        }
        if ($row_series) { // Sorgulama sonucu dolu olursa eğer sonuçları ekrana basıyoruz.
            $query_series = $db->prepare("SELECT * FROM series WHERE (series_title LIKE '%".$term."%' OR 
         series_original_title LIKE '%".$term."%' ) ORDER BY series_id DESC");
            $query_series->execute();
            $bas_alt_series = $query_series->fetchAll(PDO::FETCH_ASSOC);
            foreach ($bas_alt_series as $key => $row) {
                echo '
        <a href="' . site_url('dizi/') . $row['series_url'] . '">
            <div class="search-item">
                <div class="search-item-img" id="ps-s" style="background-image: url(' . site_url('upload/posters/') . $row['series_img'] . ');"></div>
                <div class="search-item-info">
                    <div class="fidibe-meter meter-s ' . RatingColor(Rating($row['series_id'], 'series')) . '">
                        <h2 id="tl-sm">
                            ' . Rating($row['series_id'], 'series') . '
                        </h2>
                    </div>
                    <h1 id="tl-sm">' . $row['series_title'] . '</h1>
                    <h4 id="tl-s">' . $row['series_original_title'] . '</h4>
                    <h4 id="tl-s">' . $row['series_release_date'] . '</h4>
                </div>
            </div>
        </a>
';
            }
        }
    } else {
        // Eğer eşleşen kayıt yoksa alttaki uyarıyı ekrana basıyoruz.
        echo '<div class="search-item"><p>Eşleşen kayıt bulunamadı.</p></div>';
    }
}

