<?php

namespace App\Concerns;

trait Searchable
{
    /**
     * Scope to perform search with fuzzy search.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term, $columns = [])
    {
        // If no specific columns are provided, use default searchable columns.
        if (empty($columns)) {
            $columns = $this->searchableColumns ?? ['name'];
        }

        // Apply basic search with LIKE operator first to limit results from the database.
        $query->where(function ($q) use ($term, $columns) {
            foreach ($columns as $column) {
                // Basic fuzzy search using LIKE operator.
                $q->orWhere($column, 'like', '%' . $term . '%');
            }
        });

        // Return the query builder so it can be executed later.
        return $query;
    }

    /**
     * Check if the column can use Full-Text Search.
     *
     * @param string $column
     * @return bool
     */
    protected function isFullTextSearchable($column)
    {
        return in_array($column, $this->fullTextSearchableColumns ?? []);
    }
}
