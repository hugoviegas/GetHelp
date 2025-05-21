<?php
/**
 * CAPTCHA Generation File
 * 
 * This file generates a random alphanumeric CAPTCHA code and outputs it as a PNG image.
 * It can be called directly to refresh the CAPTCHA code via AJAX.
 */

// Start the session to store the CAPTCHA code
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate a random alphanumeric CAPTCHA code
 * 
 * @param int $length The length of the CAPTCHA code
 * @return string Generated alphanumeric code
 */
function generateCaptcha($length = 6) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Exclude similar-looking chars
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $captcha;
}

// Generate and store the code
$captcha = generateCaptcha();
$_SESSION['captcha'] = $captcha;

// Create the image
$width = 140;
$height = 48;
$image = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($image, 245, 245, 245);
$fg = imagecolorallocate($image, 34, 34, 34);
$noise = imagecolorallocate($image, 180, 180, 180);
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Add noise
for ($i = 0; $i < 40; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $noise);
}
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noise);
}

// Add the text
$font = __DIR__ . '/assets/fonts/arial.ttf';
if (!file_exists($font)) {
    $font = __DIR__ . '/assets/fonts/DejaVuSans.ttf'; // fallback
}
$fontSize = 22;
$angle = rand(-10, 10);
$bbox = imagettfbbox($fontSize, $angle, $font, $captcha);
$textWidth = $bbox[2] - $bbox[0];
$textHeight = $bbox[1] - $bbox[7];
$x = ($width - $textWidth) / 2;
$y = ($height + $textHeight) / 2;
imagettftext($image, $fontSize, $angle, $x, $y, $fg, $font, $captcha);

// Output the image
header('Content-Type: image/png');
header('Cache-Control: no-cache, must-revalidate');
imagepng($image);
imagedestroy($image);
exit;
