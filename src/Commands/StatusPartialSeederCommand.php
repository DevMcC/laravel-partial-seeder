<?php

namespace DevMcC\LaravelPartialSeeder\Commands;

use DevMcC\LaravelPartialSeeder\Traits\PartialSeedsFileManager;
use DevMcC\LaravelPartialSeeder\Traits\PartialSeedsHistoryTableUser;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class StatusPartialSeederCommand extends Command
{
    use PartialSeedsFileManager;
    use PartialSeedsHistoryTableUser;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prtl-seeder:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the status of each partial seeder';

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
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return void
     */
    public function fire()
    {
        $files = $this->getPartialSeedsFiles();

        if (empty($files)) {
            $this->output->writeln('<info>No partial seeders found.</info>');

            return;
        }

        $files = array_map(function ($file) {
            return [
                $this->getSeederStatus($file['filename']),
                $file['filename'],
            ];
        }, $files);

        $this->table(['Ran?', 'Partial Seeder'], $files);
    }

    /**
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  string $fileName
     *
     * @return string
     */
    protected function getSeederStatus(string $fileName)
    {
        return $this->checkSeederFromHistory($fileName) ? '<info>Y</info>' : '<fg=red>N</fg=red>';
    }
}
