<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'phpdoc_summary' => false,
        'phpdoc_align' => ['align' => 'left'],
        'global_namespace_import' => [
            'import_classes' => null,
            'import_constants' => null,
            'import_functions' => null,
        ],
        'trailing_comma_in_multiline' => [
            'after_heredoc' => false,
            'elements' => ['arguments', 'arrays', 'match', 'parameters'],
        ],
    ])
    ->setFinder($finder)
;
