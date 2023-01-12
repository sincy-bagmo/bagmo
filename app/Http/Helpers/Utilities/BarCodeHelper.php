<?php


namespace App\Http\Helpers\Utilities;

use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarCodeHelper
{
    public static function generateBarcodeHtml($code)
    {
        $generator = new BarcodeGeneratorHTML();
        return (! is_null($code)) ? $generator->getBarcode($code, $generator::TYPE_CODE_128) : '----';
    }

    public static function generateBarcodePng($code)
    {
        $generatorPNG = new BarcodeGeneratorPNG();
        return (! is_null($code)) ? '<img src="data:image/png;base64,' . base64_encode($generatorPNG->getBarcode($code, $generatorPNG::TYPE_CODE_128)) . '">' : '----';
    }

    public static function generateQrCode($code)
    {
        $fileName = time() . '.png';
        QrCode::size(500)
            ->format('png')
            ->generate(url(route('device-reading', base64_encode($code))),
                Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'qrcodes/' . $fileName);
        return $fileName;
    }

    public static function generateQrCodeWithoutUrl($code)
    {
        if(!is_null($code)) {
            return QrCode::size(250)->format('svg')->generate($code);  
        }
    }

}
