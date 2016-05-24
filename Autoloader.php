<?php

class Autoloader
{
    protected $baseDir = __DIR__;
    protected $jsonFile = '';
    protected $directories = array();

    public function __construct($jsonFile = 'autoload.json')
    {
        $this->jsonFile = $this->makeAbsoluteDir($jsonFile);
        $this->directories = $this->loadDirectories($this->jsonFile);
    }

    public function autoload($className)
    {
        foreach ($this->directories as $dir) {
            if ($this->autoloadFromDir($className, $this->makeAbsoluteDir($dir))) {
                break;
            }
        }
    }

    public function autoloadFromDir($className, $directory)
    {
        if (file_exists($this->makeAbsoluteDir($className . '.php', $directory))) {
            require $this->makeAbsoluteDir($className . '.php', $directory);
        } else {
            return false;
        }

       return true; 
    }

    protected function loadDirectories($file)
    {
        $autoload = json_decode(file_get_contents($file), true);
        return $autoload['directory'];
    }

    protected function makeAbsoluteDir($directory, $baseDirectory = '')
    {
        $baseDirectory = empty($baseDirectory) ? $this->baseDir : $baseDirectory;
        return join(DIRECTORY_SEPARATOR, array($baseDirectory, $directory));
    }

}

$autoloader = new Autoloader();
spl_autoload_register(array($autoloader, 'autoload'));
