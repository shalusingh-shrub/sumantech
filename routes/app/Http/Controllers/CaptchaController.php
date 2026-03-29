<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function image()
    {
        // Generate random captcha text - only uppercase for easy reading
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';
        for ($i = 0; $i < 5; $i++) {
            $captcha .= $chars[random_int(0, strlen($chars) - 1)];
        }

        // Store in session (lowercase for case-insensitive compare)
        session(['captcha' => strtolower($captcha)]);

        // Create image
        $width  = 150;
        $height = 45;
        $image  = imagecreatetruecolor($width, $height);

        // Background gradient effect
        $bg = imagecolorallocate($image, 240, 244, 255);
        imagefill($image, 0, 0, $bg);

        // Add noise lines
        for ($i = 0; $i < 6; $i++) {
            $color = imagecolorallocatealpha($image,
                random_int(100, 200), random_int(100, 200), random_int(150, 220), 60);
            imageline($image, random_int(0, $width), random_int(0, $height),
                random_int(0, $width), random_int(0, $height), $color);
        }

        // Add dots
        for ($i = 0; $i < 50; $i++) {
            $dot = imagecolorallocatealpha($image,
                random_int(0, 150), random_int(0, 150), random_int(100, 200), 70);
            imagesetpixel($image, random_int(0, $width), random_int(0, $height), $dot);
        }

        // Draw each character
        $colors = [
            imagecolorallocate($image, 26, 42, 108),   // dark blue
            imagecolorallocate($image, 179, 18, 23),   // red
            imagecolorallocate($image, 0, 100, 0),     // green
            imagecolorallocate($image, 123, 31, 162),  // purple
            imagecolorallocate($image, 230, 81, 0),    // orange
        ];

        $fontPath = public_path('fonts/captcha.ttf');
        $x = 12;
        for ($i = 0; $i < strlen($captcha); $i++) {
            $color = $colors[$i % count($colors)];
            $size  = random_int(18, 22);
            $angle = random_int(-15, 15);
            $y     = random_int(30, 36);

            if (file_exists($fontPath)) {
                imagettftext($image, $size, $angle, $x, $y, $color, $fontPath, $captcha[$i]);
            } else {
                // Fallback - use built-in font
                imagestring($image, 5, $x, 12, $captcha[$i], $color);
            }
            $x += random_int(24, 28);
        }

        // Output
        header('Content-Type: image/png');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return response($imageData, 200, ['Content-Type' => 'image/png']);
    }
}
