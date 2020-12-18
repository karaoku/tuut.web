<div class="widget">
    <div class="widget-title">
        <h3>Haftanın En Popülerlerİ</h3>
    </div><!-- Widget-Title -->
    <?php foreach (PopularPages() as $key => $row): ?>
    <div class="fidibe-horizontal min">
        <div class="fidibe-poster">
            <a href="<?= site_url('film/') . $row['movie_url'] ?>"><img src="<?= site_url('upload/posters/') . $row['movie_img'] ?>" alt="" id="ps-s"></a>
        </div><!-- Fidibe-Poster -->
        <div class="fidibe-info">
            <div class="fidibe-meter meter-s <?= RatingColor(Rating($row['movie_id'],'movie'))?>">
                <h2 id="tl-sm">
                    <?= Rating($row['movie_id'],'movie')?>
                </h2>
            </div><!-- Fidibe-Meter -->
            <div class="fidibe-title">
                <a href="<?= site_url('film/') . $row['movie_url'] ?>"><h1 id="tl-sm" style="color: #343a40" title="<?= $row['movie_title'] ?>"><?= $row['movie_title'] ?></h1></a>
            </div>
        </div><!-- Fidibe-İnfo -->
    </div><!-- Fidibe -->
    <?php endforeach; ?>
</div><!-- Widget -->
<div class="widget">
    <div class="widget-title">
        <h3>BOX OFFİCE</h3>
    </div>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Film</th>
            <th scope="col">Hft</th>
            <th scope="col">H.S. İz.</th>
            <th scope="col">Top. İz.</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (BoxOffice() as $key => $val): ?>
        <tr>
            <td style="font-weight: bold"><?= $val['film']?></td>
            <td><?= $val['hafta']?></td>
            <td><?= $val['hs_seyirci']?></td>
            <td><?= $val['toplam_seyirci']?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>