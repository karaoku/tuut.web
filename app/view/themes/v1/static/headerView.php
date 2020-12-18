<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>tuut - bir çeşit güldürü</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= public_url('css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= public_url('css/fontawesome.min.css')?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?= public_url('js/all.min.js')?>"></script>
    <script src="<?= public_url('js/main.js')?>"></script>
</head>
<body>
<header class="header">
    <div class="container">
        <div class="header-menu">
            <div class="header-menu-left">
                <a href="<?= !empty(session('user_nick')) ? site_url('olustur') : site_url('giris') ?>">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <a href="<?=URL?>" class="header-menu-center">
                <img src="<?=public_url('img/logo.png')?>" alt="">
            </a>
            <div class="header-menu-right">
                <a href="<?= !empty(session('user_nick')) ? site_url('uye/') . session('user_url') : site_url('giris') ?>">
                    <i class="far fa-user"></i>
                </a>
            </div>
        </div><!-- Header-Menu -->
    </div><!-- Container -->
</header><!-- Header -->
