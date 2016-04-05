<?php

/**
 * @file
 * Contains \Drupal\github_data\Controller\ManifestController.
 */

namespace Drupal\github_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\github_data\GitHubDataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ManifestController.
 *
 * @package Drupal\github_data\Controller
 */
class ManifestController extends ControllerBase {

  /**
   * Drupal\github_data\GitHubDataService definition.
   *
   * @var GitHubDataService
   */
  protected $github_data_api;

  /**
   * {@inheritdoc}
   */
  public function __construct(GitHubDataService $github_data_api) {
    $this->github_data_api = $github_data_api;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('github_data.api')
    );
  }


  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    $github = $this->github_data_api;

    $version = $this->github_data_api->getLatestRelease();

    $url = sprintf(
      'https://github.com/%s/%s/releases/download/%s/drupalvm.phar',
      $github::ORGANISATION,
      $github::REPOSITORY,
      $version
    );

    $urlVersion = sprintf(
      'https://github.com/%s/%s/releases/download/%s/drupalvm.phar.version',
      $github::ORGANISATION,
      $github::REPOSITORY,
      $version
    );

    $request = \Drupal::httpClient()->get($urlVersion);

    $sha1 = (String) $request->getBody();

    $jsonData[] = [
      'name' => 'drupalvm.phar',
      'sha1' => str_replace("\n", "", $sha1),
      'url' => $url,
      'version' => $version
    ];

    return new JsonResponse($jsonData);
  }

}
