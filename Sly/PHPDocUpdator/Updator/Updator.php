<?php

namespace Sly\PHPDocUpdator\Updator;

use Symfony\Component\Finder\Finder;
use Sly\PHPDocUpdator\Manager\FileManager;
use Sly\PHPDocUpdator\Generator\DocGenerator;

/**
 * Updator.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Updator
{
    protected $options;
    protected $finder;
    protected $fileManager;

    /**
     * Constructor.
     *
     * @param array $options Options
     */
    public function __construct(array $options)
    {
        $this->options     = $options;
        $this->finder      = new Finder();
        $this->fileManager = new FileManager();

        $this->loadFoldersIntoFinder();

        $parsedFiles = $this->getFileManagerFiles();
    }

    /**
     * Loader folders into Finder service.
     */
    protected function loadFoldersIntoFinder()
    {
        foreach ($this->options['include'] as $file) {
            if (is_array($file)) {
                $file = key($file);
            }

            $this->finder->in(ROOT_DIR.'/'.$file);
        }

        foreach ($this->options['exclude'] as $file) {
            $this->finder->exclude(ROOT_DIR.'/'.$file);
        }
    }

    /**
     * Get FileManager service files.
     */
    protected function getFileManagerFiles()
    {
        foreach ($this->finder as $file) {
            $this->fileManager->add($file);
        }

        return $this->fileManager->getFiles();
    }
}
