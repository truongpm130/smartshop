<?php

class Thumbnail
{

    protected $original;
    protected $originalwidth;
    protected $originalheight;
    protected $basename;
    protected $maxSize = 120;
    protected $imageType;
    protected $destination;
    protected $suffix = '_thb';
    protected $messages = [];
    protected $newName;

    public function __construct($image, $destination, $maxSize = 120, $suffix = '_thb')
    {
        if (is_file($image) && is_readable($image)) {
            $details = getimagesize($image);
        } else {
            throw new \Exception("Can not open $image");
        }

        if (!is_array($details)) {
            throw new \Exception("$image does not appear to be an image");
        } else {
            if ($details[0] == 0) {
                throw new \Exception("Cannot determine size of $image");
            }

            // check the MIME type
            if (!$this->checkType($details['mime'])) {
                throw new \Exception('Cannot process that type of file');
            }

            $this->original = $image;
            $this->originalwidth = $details[0];
            $this->originalheight = $details[1];
            $this->basename = pathinfo($image, PATHINFO_FILENAME);
            $this->setDestination($destination);
            $this->setMaxSize($maxSize);
            $this->setSuffix($suffix);
        }
    }

    protected function checkType($mime)
    {
        $mimeType = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($mime, $mimeType)) {
            // Extract the character after '/'
            $this->imageType = substr($mime, strpos($mime, '/') + 1);
            return true;
        } else {
            return false;
        }
    }

    protected function setDestination($destination)
    {
        if (is_dir($destination) && is_writable($destination)) {
            $this->destination = rtrim($destination, '/\\') . DIRECTORY_SEPARATOR;
        } else {
            throw new \Exception("Cannot write to $destination");
        }
    }

    protected function setMaxSize($size)
    {
        if (is_numeric($size) && $size > 0) {
            $this->maxSize = abs($size);
        } else {
            throw new  \Exception('The value for setMaxSize() must be positive number');
        }
    }

    protected function setSuffix($suffix)
    {
        if (preg_match('/^\w+$/', $suffix)) {
            if (strpos($suffix, '_') !== 0) {
                $this->suffix = '_' . $suffix;
            } else {
                $this->suffix = $suffix;
            }
        }
    }

    protected function calculateRatio($width, $height, $maxSize)
    {
        if ($width <= $maxSize && $height <= $maxSize) {
            return 1;
        } elseif ($width > $height) {
            return $maxSize / $width;
        } else {
            return $maxSize / $height;
        }
    }


    public function create()
    {
        $ratio = $this->calculateRatio($this->originalwidth, $this->originalheight, $this->maxSize);
        $thumbwidth = round($this->originalwidth * $ratio);
        $thumbheight = round($this->originalheight * $ratio);
        $resource = $this->createImageResource();
        $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
        imagecopyresampled(
            $thumb,
            $resource,
            0,
            0,
            0,
            0,
            $thumbwidth,
            $thumbheight,
            $this->originalwidth,
            $this->originalheight
        );
        $newname = $this->basename . $this->suffix;

        switch ($this->imageType) {
            case 'jpeg':
                $newname .= '.jpeg';
                $success = imagejpeg($thumb, $this->destination . $newname);
                break;
            case 'png':
                $newname .= '.png';
                $success = imagepng($thumb, $this->destination . $newname);
                break;
            case 'gif':
                $newname .= '.gif';
                $success = imagegif($thumb, $this->destination . $newname);
                break;
            case 'webp':
                $newname .= '.webp';
                $success = imagewebp($thumb, $this->destination . $newname);
                break;
        }

        if ($success) {
            $this->messages[] = "$newname was created successfully";
        } else {
            $this->messages[] = 'Couldn\'t create a thumbnail for ' . basename($this->original);
        }

        $this->newName = $newname;

        imagedestroy($resource);
        imagedestroy($thumb);
    }

    protected function createImageResource()
    {
        switch ($this->imageType) {
            case 'jpeg':
                return imagecreatefromjpeg($this->original);
            case 'png':
                return imagecreatefrompng($this->original);
            case 'gif':
                return imagecreatefromgif($this->original);
            case 'webp':
                return imagecreatefromwebp($this->original);
        }
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getNewName() {
        return $this->newName;
    }

}
