<?php

namespace Drupal\eos_video\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Video entities.
 *
 * @ingroup eos_video
 */
interface VideoInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Video name.
   *
   * @return string
   *   Name of the Video.
   */
  public function getName();

  /**
   * Sets the Video name.
   *
   * @param string $name
   *   The Video name.
   *
   * @return \Drupal\eos_video\Entity\VideoInterface
   *   The called Video entity.
   */
  public function setName($name);

  /**
   * Gets the Video creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Video.
   */
  public function getCreatedTime();

  /**
   * Sets the Video creation timestamp.
   *
   * @param int $timestamp
   *   The Video creation timestamp.
   *
   * @return \Drupal\eos_video\Entity\VideoInterface
   *   The called Video entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Video published status indicator.
   *
   * Unpublished Video are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Video is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Video.
   *
   * @param bool $published
   *   TRUE to set this Video to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\eos_video\Entity\VideoInterface
   *   The called Video entity.
   */
  public function setPublished($published);

  /**
   * Gets the Video revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Video revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\eos_video\Entity\VideoInterface
   *   The called Video entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Video revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Video revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\eos_video\Entity\VideoInterface
   *   The called Video entity.
   */
  public function setRevisionUserId($uid);

}
