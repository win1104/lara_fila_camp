<?php

return [
    /**
     * Tree model fields
     */
    'column_name' => [
        'order' => 'order',
        'parent' => 'parent_slug',
        'id' => 'slug',
        'slug' => 'slug',
        'parent_slug' => 'parent_slug',
        'type' => 'type',
        'title' => 'title',
    ],
    /**
     * Tree model default parent key
     */
    'default_parent_id' => null,
    /**
     * Tree model default children key name
     */
    'default_children_key_name' => 'children',
];
