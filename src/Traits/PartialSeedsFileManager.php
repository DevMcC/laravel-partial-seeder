<?php

namespace DevMcC\LaravelPartialSeeder\Traits;

trait PartialSeedsFileManager
{
    /**
     * Gets the directory name.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return string
     */
    protected function directoryName()
    {
        return 'partial_seeds';
    }

    /**
     * Get the partial_seeds path.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return string
     */
    protected function getPartialSeedsPath()
    {
        return $this->laravel->databasePath().'/'.$this->directoryName();
    }

    /**
     * Get all the .php files from the partial_seeds directory.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return array
     */
    protected function getPartialSeedsFiles()
    {
        $path = $this->getPartialSeedsPath();

        if (!realpath($path)) {
            return [];
        }

        return array_map(function ($file) use ($path) {
            return pathinfo($file);
        }, $this->files->glob($path.'/*_*.php'));
    }

    /**
     * Requires all the given files.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return void
     */
    protected function requireFiles($files)
    {
        foreach ($files as $file) {
            $this->files->requireOnce($file['dirname'].'/'.$file['basename']);
        }
    }
}
