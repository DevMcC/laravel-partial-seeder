<?php

namespace DevMcC\LaravelPartialSeeder\Traits;

use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait PartialSeedsHistoryTableUser
{
    /**
     * Gets the database name.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return string
     */
    protected function databaseName()
    {
        return 'partial_seeds_history';
    }

    /**
     * Creates the partial_seeds_history table.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @return bool
     */
    public function createHistoryTableIfNotExists()
    {
        if (Schema::hasTable($this->databaseName())) {
            return false;
        }

        $this->output->writeln('<comment>Creating history table.</comment>');
        Schema::create($this->databaseName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('seeder');
        });
        $this->output->writeln('<info>Created history table.</info>');


        return true;
    }

    /**
     * Checks if a partial seeder has been seeded.
     *
     * @author DevMcC <sinbox.c@gmail.com>
     *
     * @param  string $fileName
     *
     * @return bool
     */
    public function checkSeederFromHistory(string $fileName)
    {
        return DB::table($this->databaseName())->where('seeder', $fileName)->exists();
    }
}
