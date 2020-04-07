<?php

require_once 'Upload.php';
require_once 'Thumbnail.php';

class ThumbnailUpload extends Upload
{

    protected $thumbDestination;
    protected $deleteOriginal;
    protected $maxSize = 120;
    protected $suffix = '_thb';
    protected $name;

    public function __construct($path, $deleteOriginal = false)
    {
        parent::__construct($path);
        $this->thumbDestination = $path;
        $this->deleteOriginal = $deleteOriginal;
    }

    public function setThumbOptions($path, $maxSize = null, $suffix = null)
    {
        if (is_dir($path) && is_writable($path)) {
            $this->thumbDestination = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
        } else {
            throw new \Exception("$path must be a valid, writeable directory");
        }

        if (!is_null($maxSize)) {
            $this->maxSize = $maxSize;
        }

        if (!is_null($suffix)) {
            $this->suffix = $suffix;
        }
    }

    protected function createThumbnail($image)
    {
        $thumb = new Thumbnail($image, $this->thumbDestination, $this->maxSize, $this->suffix);
        $thumb->create();
        $messages = $thumb->getMessages();
        $this->messages = array_merge($this->messages, $messages);
        $this->name = $thumb->getNewName();
    }

    public function moveFile($file)
    {
        $filename = $this->newName ?? $file['name'];
        $this->name = $filename;

        $success = move_uploaded_file(
            $file['tmp_name'],
            $this->destination . $filename
        );
        if ($success) {
            // add a message only if the original image is not deleted
            if (!$this->deleteOriginal) {
                $result = $file['name'] . ' was uploaded successfully';
                if (!is_null($this->newName)) {
                    $result .= ', and was renamed ' . $this->newName;
                }
                $this->messages[] = $result;
            }
            // create a thumbnail from the uploaded image
            $this->createThumbnail($this->destination . $filename);
            // delete the uploaded image if required
            if ($this->deleteOriginal) {
                unlink($this->destination . $filename);
            }
            $this->status = true;
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

    public function getName($file) {
        return $this->name;
    }

}
