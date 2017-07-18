<?php

namespace DevMcC\LaravelPartialSeeder\Commands;

use DevMcC\LaravelPartialSeeder\Traits\PartialSeedsHistoryTableUser;
use Illuminate\Console\Command;

class InstallPartialSeederCommand extends Command
{
    use PartialSeedsHistoryTableUser;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prtl-seeder:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the partial_seeds_history table';

    /**
     * The command constructor.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
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
        if (!$this->createHistoryTableIfNotExists()) {
            $this->output->writeln('<info>A history table was already created.</info>');
        }
    }
}
