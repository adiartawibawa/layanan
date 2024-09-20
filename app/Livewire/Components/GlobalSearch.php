<?php

namespace App\Livewire\Components;

use Livewire\Component;

class GlobalSearch extends Component
{
    public $searchQuery = ''; // Holds the search query entered by the user.
    public $results = []; // Stores search results.
    public $perPage = 5; // Number of results to show per page.
    public $page = []; // Current page for each model.
    public $hasMoreResults = []; // Tracks whether more results are available per model.

    public function mount()
    {
        // Initialize pagination and result flags for all models.
        $this->resetSearchResults();
    }

    /**
     * Method to handle changes in the search query.
     */
    public function updatedSearchQuery()
    {
        $this->resetSearchResults(); // Reset results when search query changes.
        $this->performSearch();
    }

    /**
     * Perform the search and load results.
     */
    protected function performSearch()
    {
        if (!empty($this->searchQuery)) {
            // Get all models that use the Searchable trait.
            $models = $this->getSearchableModels();

            foreach ($models as $model) {
                // If no more results for this model, skip it.
                if (!$this->hasMoreResults[$model]) {
                    continue;
                }

                // Perform search with pagination.
                $paginatedResults = $model::search($this->searchQuery)
                    ->paginate($this->perPage, ['*'], 'page', $this->page[$model]);

                // Append new records to the results array.
                $this->results[$model] = array_merge(
                    $this->results[$model] ?? [],
                    $paginatedResults->items()
                );

                // Determine if more records exist for this model.
                $this->hasMoreResults[$model] = $paginatedResults->hasMorePages();

                // Increment page number if more results exist.
                if ($this->hasMoreResults[$model]) {
                    $this->page[$model]++;
                }
            }
        }
    }

    /**
     * Load more results for lazy loading.
     */
    public function loadMore()
    {
        $this->performSearch(); // Load more results for each model.
    }

    /**
     * Reset search results and pagination.
     */
    public function resetSearchResults()
    {
        $this->results = [];
        $this->page = [];
        $this->hasMoreResults = [];

        // Initialize for all searchable models.
        foreach ($this->getSearchableModels() as $model) {
            $this->page[$model] = 1;
            $this->hasMoreResults[$model] = true;
        }
    }

    /**
     * Get all models that use the Searchable trait.
     *
     * @return array
     */
    protected function getSearchableModels()
    {
        $models = [];

        // Scan the app/Models directory for all model files.
        $modelFiles = glob(app_path('Models') . '/*.php');

        foreach ($modelFiles as $modelFile) {
            // Get the full class name of the model.
            $modelClass = 'App\\Models\\' . basename($modelFile, '.php');

            // Check if the model uses the Searchable trait.
            if (in_array('App\Concerns\Searchable', class_uses($modelClass))) {
                $models[] = $modelClass; // Add the model to the list.
            }
        }

        return $models;
    }

    /**
     * Check if all searchable models have no more results.
     *
     * @return bool
     */
    public function allModelsExhausted()
    {
        foreach ($this->getSearchableModels() as $model) {
            if ($this->hasMoreResults[$model] ?? false) {
                return false; // At least one model still has more results.
            }
        }

        return true; // All models are exhausted.
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.components.global-search');
    }
}
