<?php

namespace Drupal\github_data;

use Github\Client;
use Github\HttpClient\CachedHttpClient;

class GitHubDataService {

  const ORGANISATION = 'opdavies';

  const REPOSITORY = 'drupal-vm-generator';

  /**
   * @var Client
   */
  private $githubClient;

  /**
   * @return Client
   */
  private function getGithubClient() {
    if (!$this->githubClient) {
      $cacheDir = '/tmp/github-api-cache';

      $this->githubClient = new Client(
        new CachedHttpClient(['cache_dir' => $cacheDir])
      );
    }

    return $this->githubClient;
  }

  /**
   * @return string
   */
  public function getLatestRelease() {
    return $this->getGithubClient()->api('repo')->releases()->latest(
      self::ORGANISATION,
      self::REPOSITORY
    )['tag_name'];
  }

}
