<?php

class Upload
{
    protected $destination;
    protected $max = 51200;
    protected $messages = [];
    protected $permitted = [
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp'
    ];
    protected $newName;
    protected $status = false;

    public function __construct($path)
    {
        if (is_dir($path) && is_writable($path)) {
            $this->destination = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
        } else {
            throw new \Exception("$path must be a valid, writeable directory");
        }
    }

    public function upload($fieldName, $size = null, array $mine = null, $renameDuplicates = true)
    {
        $uploaded = $_FILES[$fieldName];

        if (!is_null($size) && $size > 0) {
            $this->max = (int) $size;
        }

        if (!is_null($mine)) {
            $this->permitted = array_merge($this->permitted, $mine);
        }

        if (is_array($uploaded['name'])) {

            // deal with multiple uploads
            $numFiles = count($uploaded['name']);
            $key = array_keys($uploaded);

            for ($i = 0; $i < $numFiles; $i++) {
                $values = array_column($uploaded, $i);
                $currentFile = array_combine($key, $values);
                $this->processUpload($currentFile, $renameDuplicates);
            }
        } else {
            $this->processUpload($uploaded, $renameDuplicates);
        }
    }

    protected function processUpload($uploaded, $renameDuplicates)
    {
        if ($this->checkFile($uploaded)) {
            $this->checkName($uploaded, $renameDuplicates);
            $this->moveFile($uploaded);
        }
    }

    protected function checkName($file, $renameDuplicates)
    {
        $this->newName = null;
        $noSpaces = str_replace(' ', '_', $file['name']);
        if ($noSpaces != $file['name']) {
            $this->newName = $noSpaces;
        }

        if ($renameDuplicates) {
            $name = $this->newName ?? $file['name'];
            if (file_exists($this->destination . $name)) {
                // rename file
                $basename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $this->newName = $basename . '_' . time() . ".$extension";
            }
        }
    }

    protected function checkFile($file)
    {
        if ($this->getErrorLevel($file) && $this->checkSize($file) && $this->checkType($file)) {
            return true;
        } else {
            return false;
        }
    }

    public function getErrorLevel($file)
    {
        switch ($file['error']) {
            case 0:
                return true;
            case 1:
            case 2:
                $this->messages[] = $file['name'] . ' is too big: (max: ' . $this->getMaxSize() . ')';
                break;
            case 3:
                $this->messages[] = $file['name'] . ' was only partially uploaded';
                break;
            case 4:
                $this->messages[] = 'No file submitted';
                break;
            default:
                $this->messages[] = 'Sorry, there was a problem uploading file: ' . $file['name'];
        }
        return false;
    }

    protected function checkSize($file)
    {
        if ($file['error'] == 1 || $file['error'] == 2) {
            return false;
        } elseif ($file['size'] == 0) {
            $this->messages[] = $file['name'] . ' is an empty file';
            return false;
        } elseif ($file['size'] > $this->max) {
            $this->messages[] = $file['name'] . ' exceeds the maximum size for a file (' . $this->getMaxSize() . ')';
            return false;
        }
        return true;
    }

    protected function checkType($file)
    {
        if (!in_array($file['type'], $this->permitted)) {
            $this->messages[] = $file['name'] . ' is not permitted type of file';
            return false;
        }
        return true;
    }

    public function getMaxSize()
    {
        return number_format($this->max / 1024, 1) . 'Kb';
    }

    protected function moveFile($file)
    {
        $fileName = $this->newName ?? $file['name'];

        $success = move_uploaded_file($file['tmp_name'], $this->destination . $fileName);

        if ($success) {
            $this->status = true;
            $result = $file['name'] . ' was uploaded successfully';
            if (!is_null($this->newName)) {
                $result .= ', and was rename ' . $this->newName;
            }
            $this->messages[] = $result;
            
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function getName($file) 
    {
        $fileName = $this->newName ?? $file['name'];
        return $fileName;
    }
}
