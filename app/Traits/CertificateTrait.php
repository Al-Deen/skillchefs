<?php
namespace App\Traits;

use App\Traits\QrCodeGenerator;
use Intervention\Image\Facades\Image;

trait CertificateTrait
{
    use QrCodeGenerator;

    public function makeText($text, $enroll)
    {
        $text = str_replace('[name]', $enroll->user->name, $text);
        $text = str_replace('[instructor]', $enroll->teacher->name, $text);
        $text = str_replace('[course]', $enroll->course->title, $text);
        $text = str_replace('[date]', date('d M Y', strtotime($enroll->completed_at)), $text);
        return $text;

    }

    public function generateCertificate($template, $enroll, $serialNumber)
    {
        try {

            $text = $this->makeText($template->text, $enroll);
            $templateDesign = showImage(@$template->image->original, 'frontend/default/certificate.png');
            $certificate = $this->createCertificate($template->title, strip_tags($text), $enroll->teacher->name, $templateDesign, $serialNumber);

            if ($certificate['status']) {
                $certificate = $certificate['data'];
            } else {
                return [
                    'status' => false,
                    'message' => $certificate['message'],
                ];
            }
            return [
                'status' => true,
                'message' => ___('alert.certificate_generated'),
                'certificate' => $certificate,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }

    }

    public function logo()
    {
        $logo_path = showImage(setting('favicon'), 'favicon.png');
        $extension = pathinfo($logo_path, PATHINFO_EXTENSION);
        $image = Image::make($logo_path);
        $image->encode('png');
        $temp_file = 'logo.png';
        if (file_exists($temp_file)) {
            unlink($temp_file);
        }
        $image->save($temp_file);
        $logo_path = $temp_file;
        return $logo_path;
    }
    public function createCertificate($certificate_name, $course, $instructor, $template, $serialNumber)
    {
        try {

            if (!file_exists('temp')) {
                mkdir('temp', 0777, true);
            }

            $outputImage = 'temp/certificate_of_' . $serialNumber . '.jpg';
            $outputImage = $this->checkFile($outputImage);
            $signature = $instructor;
            // Load the certificate image
            $certificate = imagecreatefrompng($template);

            // Set the font and color for the text
            $font = public_path('frontend/font/OpenSans-BoldItalic.ttf');
            $black = imagecolorallocate($certificate, 0, 0, 0);
            $centerX = imagesx($certificate) / 2;
            $centerY = imagesy($certificate) / 2;

            // Write the certificate name
            $fontSize = 60;
            $recipientBox = imagettfbbox($fontSize, 0, $font, $certificate_name);
            $recipientWidth = $recipientBox[2] - $recipientBox[0];
            $recipientHeight = $recipientBox[0] - $recipientBox[5];

            $centerX = imagesx($certificate) / 2;
            $centerY = imagesy($certificate) / 2;

            $recipientX = $centerX - ($recipientWidth / 2);
            $recipientY = $centerY - ($recipientHeight / 2) - 300;
            imagettftext($certificate, $fontSize, 0, $recipientX, $recipientY, $black, $font, $certificate_name);

            // Generate the text for the certificate
            $maxLineWidth = 80;
            $fontSize = 26;
            $lines = wordwrap($course, $maxLineWidth, "\n", false);
            // Calculate the total height of the text
            $textHeight = substr_count($lines, "\n") * $fontSize * 2;
            // Calculate the y-coordinate for the first line
            $firstLineY = $centerY - ($textHeight / 2) - 100;
            // Draw each line of text
            $lineY = $firstLineY;
            foreach (explode("\n", $lines) as $line) {
                $lineBox = imagettfbbox($fontSize, 0, $font, $line);
                $lineWidth = $lineBox[2] - $lineBox[0];
                $lineX = $centerX - ($lineWidth / 2);
                // use meta tag for all language support
                $line = html_entity_decode($line);
                imagettftext($certificate, $fontSize, 0, $lineX, $lineY, $black, $font, $line);
                $lineY += $fontSize * 2;
            }

            $rightSide = $centerX / 3 + 100;

            // Generate the signature image
            $signatureFont = public_path('frontend/font/Pacifico-Regular.ttf');
            $signatureSize = 26;
            $signatureBox = imagettfbbox($signatureSize, 0, $signatureFont, $instructor);
            $signatureWidth = $signatureBox[2] - $signatureBox[0];
            $signatureHeight = $signatureBox[3] - $signatureBox[5];

            $signature = imagecreatetruecolor($signatureWidth, $signatureHeight);
            $white = imagecolorallocate($signature, 255, 255, 255);
            imagefill($signature, 0, 0, $white);
            imagettftext($signature, $signatureSize, 0, 0, $signatureHeight, $black, $signatureFont, $instructor);

            // Calculate the X and Y positions of the signature to center it
            $signatureX = $rightSide + $centerX - ($signatureWidth / 2);
            $signatureY = $centerY + ($signatureHeight / 2) + 100;

            // Write the signature image
            imagecopy($certificate, $signature, $signatureX, $signatureY, 0, 0, $signatureWidth, $signatureHeight);

            // Write the border without imagecopy

            // Write the instructor name
            $instructorBox = imagettfbbox(18, 0, $font, $instructor);
            $instructorWidth = $instructorBox[2] - $instructorBox[0];
            $instructorHeight = $instructorBox[3] - $instructorBox[5];

            $instructorX = $rightSide + $centerX - ($instructorWidth / 2);
            $instructorY = $signatureY + $signatureHeight + 50;

            imagettftext($certificate, 18, 0, $instructorX, $instructorY, $black, $font, $instructor);

            // Write the a border
            $certWidth = $signatureWidth;
            $certY = $signatureY + $instructorHeight + 30;
            $certHeight = 1;
            $certColor = imagecolorallocate($certificate, 0, 0, 0);

            $borderWidth = $signatureWidth;

            // Calculate the X position of the border to center it
            $borderX = $rightSide + $centerX - (($certWidth + $signatureWidth) / 2) + ($borderWidth / 2);

            // Write the border
            imagefilledrectangle($certificate, $borderX, $certY, $borderX + $certWidth, $certY + $certHeight, $certColor);

            //  write the qr code
            $qrCodeData = $this->getBarcodePNGPath(route('front.certificateView', "certificate_id=". $serialNumber), "QRCODE", 6, 5);

            // $qrCodeImage = imagecreatefromstring(file_get_contents(url($qrCodeData)));
            $qrCodeImage = imagecreatefrompng(asset($qrCodeData));
            // Calculate the X and Y positions of the QR code to center it
            $qrCodeWidth = imagesx($qrCodeImage);
            $qrCodeHeight = imagesy($qrCodeImage);
            $qrCodeX = $centerX / 2;
            $qrCodeY = $centerY + ($signatureHeight / 2) + 120;

            // Write the QR code image
            imagecopy($certificate, $qrCodeImage, $qrCodeX, $qrCodeY, 0, 0, $qrCodeWidth, $qrCodeHeight);

            // Write the and
            $andBox = imagettfbbox(14, 0, $font, '&');
            $andWidth = $andBox[2] - $andBox[0];
            $andHeight = $andBox[3] - $andBox[5];

            $andX = $rightSide + $centerX - ($andWidth / 2);
            $andY = $instructorY + $instructorHeight + 30;
            imagettftext($certificate, 14, 0, $andX, $andY, $black, $font, '&');

            // Write the website logo
            $logo_path = $this->logo();
            $logo = imagecreatefrompng($logo_path);
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);

            $logoX = $rightSide + $centerX - ($logoWidth / 2);
            $logoY = $andY + $andHeight + 10;
            imagecopy($certificate, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);

            // save the certificate image
            $outputImage = 'temp/certificate_of_' . $serialNumber . '.jpg';
            imagejpeg($certificate, $outputImage);

            // Free up memory
            imagedestroy($certificate);
            imagedestroy($qrCodeImage);
            imagedestroy($logo);
            unlink($qrCodeData);
            imagedestroy($signature);

            return [
                'status' => true,
                'message' => 'Certificate generated successfully',
                'data' => $outputImage,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }

    }

    protected function checkFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }

}
