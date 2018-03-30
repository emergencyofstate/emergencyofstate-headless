<?php

namespace Drupal\eos_video;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\eos_video\Entity\VideoInterface;

/**
 * Defines the storage handler class for Video entities.
 *
 * This extends the base storage class, adding required special handling for
 * Video entities.
 *
 * @ingroup eos_video
 */
interface VideoStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Video revision IDs for a specific Video.
   *
   * @param \Drupal\eos_video\Entity\VideoInterface $entity
   *   The Video entity.
   *
   * @return int[]
   *   Video revision IDs (in ascending order).
   */
  public function revisionIds(VideoInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Video author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Video revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\eos_video\Entity\VideoInterface $entity
   *   The Video entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(VideoInterface $entity);

  /**
   * Unsets the language for all Video with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
