<?php

namespace App\Concerns;

trait Searchable
{
    /**
     * Scope to perform search with fuzzy search, including related models.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term, $columns = [])
    {
        // Get the columns to be searched.
        $columns = $this->getSearchableColumns($columns);

        // Apply the search filter on each column.
        $this->applySearchQuery($query, $term, $columns);

        return $query;
    }

    /**
     * Get the columns that should be searchable. Default to model's own searchable columns.
     *
     * @param array $columns
     * @return array
     */
    protected function getSearchableColumns($columns)
    {
        if (empty($columns)) {
            return $this->searchableColumns ?? ['name']; // Default to 'name' if none provided.
        }

        return $columns;
    }

    /**
     * Apply the search term to the query for each column (including related model columns).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param array $columns
     */
    protected function applySearchQuery($query, $term, $columns)
    {
        $query->where(function ($q) use ($term, $columns) {
            foreach ($columns as $column) {
                // Determine if it's a relation or a direct column search.
                if ($this->isRelationColumn($column)) {
                    $this->applyRelationSearch($q, $term, $column);
                } else {
                    $this->applyBasicSearch($q, $term, $column);
                }
            }
        });
    }

    /**
     * Determine if the given column is a relation (contains a dot).
     *
     * @param string $column
     * @return bool
     */
    protected function isRelationColumn($column)
    {
        return str_contains($column, '.');
    }

    /**
     * Apply a search on related models using whereHas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param string $column
     */
    protected function applyRelationSearch($query, $term, $column)
    {
        [$relation, $relatedColumn] = explode('.', $column);

        $query->orWhereHas($relation, function ($relationQuery) use ($term, $relatedColumn) {
            $relationQuery->where($relatedColumn, 'like', '%' . $term . '%');
        });
    }

    /**
     * Apply a basic search using the LIKE operator.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param string $column
     */
    protected function applyBasicSearch($query, $term, $column)
    {
        $query->orWhere($column, 'like', '%' . $term . '%');
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
