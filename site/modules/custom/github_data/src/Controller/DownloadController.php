<?php

/**
 * @file
 * Contains \Drupal\github_data\Routing\DownloadController.
 */

namespace Drupal\github_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\github_data\GitHubDataService;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DownloadController.
 */
class DownloadController extends ControllerBase {

  /**
   * @var GitHubDataService
   */
  private $githubData;

  /**
   * @var Client
   */
  private $httpClient;

  /**
   * The name of the file to download.
   */
  const FILENAME = 'drupalvm.phar';

  /**
   * {@inheritdoc}
   */
  public function __construct(
    GitHubDataService $githubData,
    Client $httpClient
  ) {
    $this->githubData = $githubData;
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('github_data.api'),
      $container->get('http_client')
    );
  }

  /**
   * @return ResponseInterface
   */
  public function index() {
    $ghDataApi = $this->githubData;

    $filename = sprintf(
      'https://github.com/%s/%s/releases/download/%s/%s',
      $ghDataApi::ORGANISATION,
      $ghDataApi::REPOSITORY,
      $this->githubData->getLatestRelease(),
      self::FILENAME
    );

    return $this->httpClient->get($filename);
  }

}
