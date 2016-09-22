<?php

// $databases = [];
// $config_directories = [];

$settings['install_profile'] = 'standard';

$settings['hash_salt'] = 'TWB8bRImyu8yhvtTkdbox6hqFlrWN1bj2Q9ZN3JAhXOwq0WSG40Qm5ZpvC8_VRnV6x9B9-8gkQ';

$settings['update_free_access'] = FALSE;

$settings['allow_authorize_operations'] = FALSE;

$settings['container_yamls'][] = __DIR__ . '/services.yml';

$config_directories['sync'] = '../config/sync';

if (file_exists(__DIR__ . '/local.settings.php')) {
  include __DIR__ . '/local.settings.php';
}
