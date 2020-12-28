<?php

return [

    'default' => [
        'title'         => 'Genel Resim',
        'disk'          => 'public', //config/filesystems.php içerisindeki disk adı
        'path'          => '/storage/', //Resmin yüklendiği path
        'output'        => "jpeg|jpg|png|bmp|gif|svg|webp", //izin verilen formatlar
        'forced_output' => "png", // png,jpg.. or null (Formatlanır ve uzantısı değişir)
        'width'         => 800, //Resim genişliği px
        'height'        => 100, //Resim yüksekliği px
        'quality'       => 0.9, //0-1 arası değer
        'enableResize'  => false,
        'enableExif'    => true,
        'type'          => 'square', // circle
        'max_size_kb'   => 2048, //kb
    ]
];
