<?php

namespace DocsPen\Console\Commands;

use DocsPen\Services\SearchService;
use Illuminate\Console\Command;

class RegenerateSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docspen:regenerate-search {--database= : The database connection to use.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-index all content for searching';

    protected $searchService;

    /**
     * Create a new command instance.
     *
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        parent::__construct();
        $this->searchService = $searchService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $connection = \DB::getDefaultConnection();
        if ($this->option('database') !== null) {
            \DB::setDefaultConnection($this->option('database'));
            $this->searchService->setConnection(\DB::connection($this->option('database')));
        }

        $this->searchService->indexAllEntities();
        \DB::setDefaultConnection($connection);
        $this->comment('Search index regenerated');
    }
}
