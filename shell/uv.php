<?php
/**
 * Raise/update static version numbers in composer.json.
 *
 * Run on the CLI: "composer outdated --direct > outdated.txt"
 */
$composerJson = json_decode(file_get_contents('composer.json'), true);
var_dump($composerJson);
$listOfOutdatedPackages = file('outdated.txt');

foreach($listOfOutdatedPackages as $line) {

    $regexp = '/(?P<package>[\w]+\/[\w]+).*(?P<currentVersion>\d.\d.\d).*(?P<latestVersion>\d.\d.\d)/';
    preg_match($regexp, $line, $matches);
    $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

    if(isset($matches['package']))
    {
        $package = $matches['package'];

        if(isset($composerJson['require'][$package]))
        {
            $currentVersion = $composerJson['require'][$package];
            echo sprintf('Updating %s from %s to %s', $package, $currentVersion, $matches['latestVersion']);
            $composerJson['require'][$package] = $matches['latestVersion'];
        }
        if(isset($composerJson['require-dev'][$package]))
        {
            $currentVersion = $composerJson['require-dev'][$package];
            echo sprintf('Updating %s from %s to %s', $package, $currentVersion, $matches['latestVersion']);
            $composerJson['require-dev'][$package] = $matches['latestVersion'];
        }
    }
}

file_put_contents('composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
