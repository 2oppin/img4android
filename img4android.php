<?php
require "console.php";

$allowedA = ['-h', '--help', '-f', '--file', '-d', '--dir', '-s', '--size'];
try {
    $input = parseArgs(array_slice($argv, 1), $allowedA);
    if (isset($input['-h']) || isset($input['--help'])) {
        echo <<<EOD

That's the tool to create images of different sizes may be required for the Android application
Usage: php scale.php -f you_enormously_big_file.jpg -s 1024

-h --help\t - Display help
-f --file\t - Provide file to process
-d --dir\t - Provide directory to process
-s --size\t - Specify max desired size (width). Use carefully if you pass whole directory, in that case all images will have same size

EOD;
        exit;
    }
    $file = $input['-f'] ?? $input['--file'] ?? null;
    $dir = $input['-d'] ?? $input['--dir'] ?? null;
    $size = $input['-s'] ?? $input['--size'] ?? null;

    if (!$file && !$dir) throw new Exception("File must be passed.");

    $files = $dir ? glob("$dir/*.*") : [$file];

    foreach ($files as $file) {
        if (!file_exists($file)) _output('File doesn\'t exists.', 'orange');

        $sizes = [
            './drawable-xxxhdpi' => 1,
            './drawable-xxhdpi' => 0.75,
            './drawable-xhdpi' => 0.5,
            './drawable-hdpi' => 0.375,
            './drawable-tvdpi' => 0.3328,
            './drawable-mdpi' => 0.25,
            './drawable-ldpi' => 0.1875,
        ];

        foreach ($sizes as $folder => $xscale) {
            $img = new Imagick($file);
            $w = $img->getImageWidth();
            $h = $img->getImageHeight();

            $scale = $size ? $w / $size : 1;

            if (!file_exists($folder)) mkdir($folder);
            $nw = $w * $scale * $xscale;
            $nh = $h * $scale * $xscale;
            $img->scaleImage($nw, $nh, TRUE);
            $img->writeImage($folder . '/' . basename($file));

            _output("$file\t$w x $h \t $scale * $xscale =>\t $nw x $nh ...done", 'cyan');
        }
    }
} catch (\Exception $e) {
    _output($e->getMessage(), 'red');
    exit;
}


_output('Done! ^_^', 'green');


?>
