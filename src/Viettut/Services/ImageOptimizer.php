<?php


namespace Viettut\Services;


use Imagick;

class ImageOptimizer implements ImageOptimizerInterface
{
    protected $quality;

    /**
     * ImageOptimizer constructor.
     * @param $quality
     */
    public function __construct($quality)
    {
        $this->quality = $quality;
    }

    public function optimizeImage($source)
    {
        $im = new Imagick($source);
        // Optimize the image layers
        $im->optimizeImageLayers();

        // Compression and quality
        $im->setImageCompression(Imagick::COMPRESSION_JPEG);
        $im->setImageCompressionQuality($this->quality);

        // Write the image back
        $im->writeImage($source);
    }
}