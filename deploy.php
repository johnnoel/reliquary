<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config

set('application', 'reliquary');
set('deploy_path', '~/{{application}}');
set('repository', 'git@github.com:johnnoel/reliquary.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('67.207.69.0')
    ->setRemoteUser('johnnoel-uk')
;

after('deploy:failed', 'deploy:unlock');
