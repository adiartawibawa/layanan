<?php

if (!function_exists('class_uses_recursive')) {
    /**
     * Get all traits used by a class and its parent classes.
     *
     * @param string $class
     * @return array
     */
    function class_uses_recursive($class)
    {
        $traits = [];
        while ($class) {
            $traits = array_merge($traits, class_uses($class));
            $class = get_parent_class($class);
        }
        return $traits;
    }
}
