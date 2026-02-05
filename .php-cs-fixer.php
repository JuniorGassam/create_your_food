<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'single_quote' => true,
        'no_unused_imports' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
