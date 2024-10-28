<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    'public_path' => null,  // Override the public path if needed

    /*
     * Dejavu Sans font is missing glyphs for converted entities, turn it off if you need to show € and £.
     */
    'convert_entities' => true,

    'options' => [
        'font_dir' => storage_path('fonts/'), // Direktori font
        'font_cache' => storage_path('fonts/'), // Direktori cache font
        'temp_dir' => sys_get_temp_dir(),
        'chroot' => realpath(base_path()),
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],
        'default_font' => 'Great Vibes', // Mengatur font default
        'default_paper_size' => 'A4',
        'default_paper_orientation' => 'portrait',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true, // Mengizinkan akses remote jika perlu
        'enable_font_subsetting' => true, // Mengaktifkan subsetting font
        'font_family' => [
            'Great Vibes' => 'GreatVibes-Regular.ttf', // Menambahkan font khusus
        ],
    ],

];
