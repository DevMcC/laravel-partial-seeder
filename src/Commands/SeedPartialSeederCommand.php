<?php

namespace DevMcC\LaravelPartialSeeder\Commands;

use DB;
use DevMcC\LaravelPartialSeeder\Traits\PartialSeedsFileManager;
use DevMcC\LaravelPartialSeeder\Traits\PartialSeedsHistoryTableUser;
use Illuminate\Database\ConnectionResolver as Resolver;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class SeedPartialSeederCommand extends SeedCommand
{
    use PartialSeedsFileManager;
    use PartialSeedsHistoryTableUser;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'prtl-seeder:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with history controlled records';

    /**
     * The Filesystem facade.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The command constructor.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  Filesystem $files
     */
    public function __construct(Filesystem $files, Resolver $resolver)
    {
        parent::__construct($resolver);

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->resolver->setDefaultConnection($this->getDatabase());

        $this->createHistoryTableIfNotExists();

        $files = array_filter($this->getPartialSeedsFiles(), function ($file) {
            return !$this->checkSeederFromHistory($file['filename']);
        });

        if (empty($files)) {
            $this->output->writeln('<info>Nothing to seed.</info>');

            return;
        }

        Model::unguarded(function () use ($files) {
            foreach ($files as $file) {
                $className = $this->resolve($file['filename']);

                $this->output->writeln("<comment>Seeding:<comment> {$className}");
                $this->prepareSeeder($className)->__invoke();
                $this->appendSeederToHistory($file['filename']);
                $this->output->writeln("<info>Seeded:</info> {$className}");
            }
        });
    }

    /**
     * Resolve a className from a fileName.
     *
     * @param  string $fileName
     *
     * @return string
     */
    public function resolve(string $fileName)
    {
        return Str::studly(implode('_', array_slice(explode('_', $fileName), 4)));
    }

    /**
     * Prepares a seeder.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  string $className
     *
     * @return object
     */
    public function prepareSeeder(string $className)
    {
        $class = $this->laravel->make($className);

        return $class->setContainer($this->laravel)->setCommand($this);
    }

    /**
     * Appends a partial seeder to the history.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  string $file
     *
     * @return void
     */
    public function appendSeederToHistory(string $fileName)
    {
        DB::table($this->databaseName())->insert([
            'seeder' => $fileName,
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}
