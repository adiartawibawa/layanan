<?php

namespace App\Livewire\Maps;

use Livewire\Attributes\On;
use Livewire\Component;

class GeoJsonViewer extends Component
{
    public $geoJsonUrl; // URL to fetch the GeoJSON data
    public $layerId; // Identifier for the layer in the map
    public $mapInstance; // Instance of the map
    public $isPoint; // Flag indicating if the GeoJSON represents point data
    public $originalGeoJson; // Store the original GeoJSON data
    public $filteredGeoJson; // Store the filtered GeoJSON data
    public $allowSearch = true; // Default permission to allow searching
    public $searchableProperties; // Properties that can be searched by default

    /**
     * Mount the component with provided parameters.
     * This method initializes the properties of the component.
     *
     * @param string $geoJsonUrl - The URL for the GeoJSON data.
     * @param string $layerId - The ID for the layer in the map.
     * @param bool $isPoint - Indicates if the GeoJSON represents point data.
     * @param bool $allowSearch - Indicates whether searching is allowed.
     * @param string $searchableProperties - Comma-separated properties that can be searched.
     */
    public function mount($geoJsonUrl, $layerId = 'geojson-layer', $isPoint = false, $allowSearch = true, $searchableProperties = 'nama')
    {
        $this->geoJsonUrl = $geoJsonUrl; // Assign the GeoJSON URL to the property
        $this->layerId = $layerId; // Assign the layer ID to the property
        $this->isPoint = $isPoint; // Assign the point flag to the property
        $this->originalGeoJson = $this->fetchGeoJson($geoJsonUrl); // Fetch and store original GeoJSON data
        $this->filteredGeoJson = $this->originalGeoJson; // Initialize filteredGeoJson with the original data
        $this->allowSearch = $allowSearch; // Set whether searching is allowed
        $this->searchableProperties = array_map('trim', explode(',', $searchableProperties)); // Convert searchable properties string into an array
    }

    #[On('mapInitialized')]
    public function handleMapInitialized($mapId)
    {
        $this->mapInstance = $mapId; // Assign the map ID to the instance property

        // Dispatch an event to load GeoJSON data into the map
        $this->dispatch('loadGeoJson', [
            'geoJsonUrl' => $this->geoJsonUrl,
            'layerId' => $this->layerId,
            'mapId' => $mapId,
        ]);
    }

    #[On('searchGeoJson')]
    public function handleSearchGeoJson($query)
    {
        // Filter GeoJSON data based on the search query
        $this->filteredGeoJson = $this->filterGeoJson($query);

        // Dispatch an event to update the GeoJSON layer with the filtered data
        $this->dispatch('updateGeoJsonLayer' . $this->layerId, [
            'layerId' => $this->layerId,
            'geoJsonData' => $this->filteredGeoJson,
        ]);

        dd($this->filteredGeoJson);
    }

    public function fetchGeoJson($url)
    {
        // Fetch GeoJSON data from the specified URL
        $geoJson = file_get_contents($url); // Get the content from the URL
        return json_decode($geoJson, true); // Decode the JSON data into an associative array
    }

    /**
     * Filter GeoJSON based on the search query.
     * This will only filter if searching is allowed.
     *
     * @param string $query - The search query.
     * @return array - The filtered GeoJSON data.
     */
    public function filterGeoJson($query)
    {
        // If searching is not allowed or the query is empty, return the original GeoJSON
        if (!$this->allowSearch || empty($query)) {
            return $this->originalGeoJson;
        }

        // Normalize the search query for comparison
        $normalizedQuery = $this->normalizeText($query);

        // Filter GeoJSON based on the searchable properties
        $filtered = array_filter($this->originalGeoJson['features'], function ($feature) use ($normalizedQuery) {
            foreach ($this->searchableProperties as $property) {
                // Get the value of the searchable property
                $propertyValue = strtolower($feature['properties'][$property] ?? ''); // Get the property value and convert it to lowercase
                $normalizedPropertyValue = $this->normalizeText($propertyValue); // Normalize the property value for comparison

                // Check if the normalized property value contains the normalized query
                if (stripos($normalizedPropertyValue, $normalizedQuery) !== false) {
                    return true; // Match found, return true
                }
            }
            return false; // No properties matched the query
        });

        // Return the filtered GeoJSON structure
        return [
            'type' => $this->originalGeoJson['type'], // Keep the original GeoJSON type
            'features' => array_values($filtered), // Return the filtered features with reset keys
        ];
    }

    /**
     * Function to normalize text into a simple search format.
     * Removes common words, symbols, and excess whitespace.
     *
     * @param string $text - The text to be normalized.
     * @return string - The normalized text.
     */
    private function normalizeText($text)
    {
        $text = strtolower($text); // Convert text to lowercase

        // Remove common unnecessary words (e.g., "no", "no.", "nomor")
        $text = preg_replace('/\b(no|no\.|nomor)\b/', '', $text);

        // Remove all non-alphanumeric characters except numbers and letters
        $text = preg_replace('/[^a-z0-9]/', '', $text);

        return $text; // Return the normalized text
    }

    public function render()
    {
        // Render the Livewire component view
        return view('livewire.maps.geo-json-viewer'); // Return the view for the component
    }
}
