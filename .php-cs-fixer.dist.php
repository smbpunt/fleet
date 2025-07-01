<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->exclude(['vendor', 'var'])
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Coding standards compliance
        '@PER-CS' => true,
        '@PHP82Migration' => true,
        '@PSR12' => true,

        // Strict types
        'declare_strict_types' => true,

        // Import optimization
        'no_unused_imports' => true,

        // Array formatting
        'array_syntax' => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => true,

        // String formatting
        'single_quote' => true,

        // Function and method formatting
        'method_chaining_indentation' => true,
        'no_spaces_around_offset' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'none',
                'const' => 'none',
            ],
        ],

        // Control structures
        'yoda_style' => true,
    ])
    ->setFinder($finder);
