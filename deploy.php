<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/symfony.php';

option('artifact-url', null, InputOption::VALUE_REQUIRED, 'The URL to get build artifacts from');
option('circleci-token', null, InputOption::VALUE_REQUIRED, 'The personal Circle CI API token to use');

set('application', 'reliquary');
set('deploy_path', '~/{{application}}');
set('repository', 'git@github.com:johnnoel/reliquary.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

host('67.207.69.0')
    ->setRemoteUser('johnnoel-uk')
;

task('deploy:update_code', function () {
    $artifactUrl = input()->getOption('artifact-url');
    $circleCiToken = input()->getOption('circleci-token');

    if (!is_string($artifactUrl) || !is_string($circleCiToken)) {
        throw new \InvalidArgumentException('Either artifact-url or circleci-token not provided');
    }

    $header = escapeshellarg('Circle-Token: ' . $circleCiToken);
    $url = escapeshellarg($artifactUrl);

    $jsonRaw = run('curl -sH ' . $header . ' ' . $url);
    $json = json_decode($jsonRaw, true);

    if (!is_array($json) || count($json) === 0) {
        throw new \InvalidArgumentException('Invalid JSON returned: ' . $jsonRaw);
    }

    $url = escapeshellarg($json[0]['url'] . '?' . http_build_query([
            'circle-token' => $circleCiToken,
        ]));

    run('wget -qO reliquary.tar.bz2 ' . $url);
    run('tar xjf reliquary.tar.bz2 -C {{release_path}}');
});
task('deploy:vendors', function () { });

after('deploy:failed', 'deploy:unlock');
