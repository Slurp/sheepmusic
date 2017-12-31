<?php

$finder = PhpCsFixer\Finder::create()
                                             ->notPath('bootstrap/cache')
                                             ->notPath('storage')
                                             ->notPath('vendor')
                                             ->in(__DIR__)
                                             ->name('*.php')
                                             ->notName('*.html.twig')
                                             ->ignoreDotFiles(true)
                                             ->ignoreVCS(true)
                                         ;

return PhpCsFixer\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        '-phpdoc_scalar',
        '-no_extra_consecutive_blank_lines',
        '-binary_operator_spaces',
        'binary_operator_spaces',
        'linebreak_after_opening_tag',
        'ordered_imports',
        'short_array_syntax',
    ))
    ->setUsingCache(false)
    ->finder($finder)
;
