<?php
return [
    /**
     * Automatically detect based on current protocol
     */
    'auto' => false,

    /**
     * Force everything to a set protocol either
     * 'http' or 'https'. If blank then won't
     * force anything. Ignored if 'auto' is true.
     */
    'protocol' => '',

    /**
     * Use different rules per environment
     * Ignored if 'auto' is true or 'protocol' is set.
     */
    'environments' => [
        'local' => [
            'https' => false,
            'redirect' => false
        ],
        'production' => [
            'https' => true,
            'redirect' => false
        ]
    ]
];
