<?php

namespace App\Livewire\Components;

use Livewire\Component;

class GlobalSearch extends Component
{
    public $searchQuery = ''; // Holds the search query entered by the user.
    public $results = []; // Stores search results.
    public $perPage = 5; // Number of results to show per page.
    public $page = []; // Current page for each model.
    public $hasMoreResults = false; // Flag to check if more results are available for each model.

    public function mount()
    {
        // Initialize hasMoreResults to true when the component is mounted
        $this->hasMoreResults = true;
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
                // If there's no more results for this model, skip it.
                if (!$this->hasMoreResults[$model]) {
                    continue;
                }

                // Set the current page for this model if not already set.
                $currentPage = $this->page[$model] ?? 1;

                // Perform search with pagination.
                $paginatedResults = $model::search($this->searchQuery)
                    ->paginate($this->perPage, ['*'], 'page', $currentPage);

                // Append the new records to the results array instead of resetting it.
                $this->results[$model] = array_merge(
                    $this->results[$model] ?? [],
                    $paginatedResults->items()
                );

                // Check if there are more records to load for this model.
                if ($paginatedResults->currentPage() >= $paginatedResults->lastPage()) {
                    $this->hasMoreResults[$model] = false; // No more records to load for this model
                } else {
                    $this->hasMoreResults[$model] = true;  // More records available
                }
            }
        }
    }

    /**
     * Load more results for lazy loading.
     */
    public function loadMore()
    {
        // Increment the page count for each model that still has more results.
        $models = $this->getSearchableModels();

        foreach ($models as $model) {
            if ($this->hasMoreResults[$model]) {
                $this->page[$model] = ($this->page[$model] ?? 1) + 1;
            }
        }

        $this->performSearch(); // Load more results for each model.
    }

    /**
     * Reset search results and pagination.
     */
    public function resetSearchResults()
    {
        $this->page = [];
        $this->hasMoreResults = [];
        $this->results = [];

        // Initialize pagination and result flags for all models.
        $models = $this->getSearchableModels();
        foreach ($models as $model) {
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

        // Scan the app/Models directory for all model files
        $modelFiles = glob(app_path('Models') . '/*.php');

        foreach ($modelFiles as $modelFile) {
            // Get the full class name of the model
            $modelClass = 'App\\Models\\' . basename($modelFile, '.php');

            // Check if the model uses the Searchable trait
            if (in_array('App\Concerns\Searchable', class_uses($modelClass))) {
                $models[] = $modelClass; // Add the model to the list
            }
        }

        return $models;
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
