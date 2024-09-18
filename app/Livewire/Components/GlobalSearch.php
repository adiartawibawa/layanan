<?php

namespace App\Livewire\Components;

use Livewire\Component;

class GlobalSearch extends Component
{
    public $searchQuery = ''; // Holds the search query entered by the user.
    public $results = []; // Stores search results.

    /**
     * Method to handle changes in the search query.
     */
    public function updatedSearchQuery()
    {
        $this->results = []; // Reset results before performing new search.

        if (!empty($this->searchQuery)) {
            // Get all models that use the Searchable trait.
            $models = $this->getSearchableModels();

            foreach ($models as $model) {
                // Perform search on each model and store results.
                $this->results[$model] = $model::search($this->searchQuery)->get();
            }
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
