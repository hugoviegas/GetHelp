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

/**
 * References for CAPTCHA Implementation 
 *
 * The CAPTCHA generation in this file utilizes the following PHP GD functions:
 *
 * The PHP Documentation Group. 2001-2025. imagecreatetruecolor. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagecreatetruecolor.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagecolorallocate. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagecolorallocate.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagefilledrectangle. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagefilledrectangle.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imageline. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imageline.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagesetpixel. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagesetpixel.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagettfbbox. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagettfbbox.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagettftext. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagettftext.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagepng. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagepng.php [Accessed 17 May 2025].
 * The PHP Documentation Group. 2001-2025. imagedestroy. In: PHP Manual. [online]. Available at: https://www.php.net/manual/en/function.imagedestroy.php [Accessed 17 May 2025].
 */
