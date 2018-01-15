<?php

$finder = PhpCsFixer\Finder::create()
                                             ->notPath('bootstrap/cache')
                                             ->notPath('storage')
                                             ->notPath('vendor')
                                             ->in(__DIR__.'/src')
                                             ->name('*.php')
                                             ->notName('*.html.twig')
                                             ->ignoreDotFiles(true)
                                             ->ignoreVCS(true)
                                         ;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@PHP70Migration' => true,
        '@DoctrineAnnotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'single'],
        'yoda_style' => ['equal' => null , 'identical' => null]
    ])
    ->setFinder($finder)
;
