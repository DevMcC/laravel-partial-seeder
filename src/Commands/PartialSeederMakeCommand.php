<?php

namespace DevMcC\LaravelPartialSeeder\Commands;

use DevMcC\LaravelPartialSeeder\Traits\PartialSeedsFileManager;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Support\Str;

class PartialSeederMakeCommand extends SeederMakeCommand
{
    use PartialSeedsFileManager;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:prtl-seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new partial seeder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Partial Seeder';

    /**
     * Execute the console command.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return bool|null
     */
    public function fire()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $className = str::studly($name);

        $path = $this->getDestinationPath($name);

        $this->requireFiles($this->getPartialSeedsFiles());

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ($this->alreadyExists($className)) {
            $this->error('A '.$className.' '.$this->type.' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($className));

        $this->info($this->type.' created successfully.');
    }

    /**
     * Checks if the current class already exists.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  $name
     *
     * @return bool
     */
    protected function alreadyExists($name)
    {
        return class_exists($name);
    }

    /**
     * Get the destination class path.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  $name
     *
     * @return string
     */
    protected function getDestinationPath($name)
    {
        return $this->getPartialSeedsPath().'/'.$this->getDatePrefix().'_'.$name.'.php';
    }

    /**
     * Get the date prefix for the partial seeder.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return string
     */
    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }
}
