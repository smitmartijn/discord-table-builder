<?php

namespace Smitmartijn\DiscordTableBuilder;

/**
 * @package Smitmartijn\DiscordTableHelper
 * @version 1.0.0
 * @license GNU General Public License v3.0
 * @link
 */


/**
 * This class is used to create a table row for a Discord embed.
 */
class DiscordEmbedRow
{
  private $columns;
  private $indexes;
  private $whiteSpace;

  public function __construct(array $options)
  {
    $this->columns = $options['columns'];
    $this->indexes = $options['indexes'];
    $this->whiteSpace = $options['whiteSpace'];
  }

  public function toString(): string
  {
    $res = '';
    for ($i = 0; $i < count($this->columns); $i++) {
      $res .= $this->padRow($i);
    }
    return $res;
  }

  /**
   * @param int $i The index of the row
   * @return string The padded row
   * @since 1.0.0
   *
   * This function is used to pad a row with white space.
   */
  private function padRow(int $i): string
  {
    $padding = $this->whiteSpace ? "\u{200B} " : ' ';
    $repeatCount = ($this->indexes[$i] ?? 0) - ($this->indexes[$i - 1] ?? 0) - (isset($this->columns[$i - 1]) ? strlen((string)$this->columns[$i - 1]) : 0);
    $paddedSpace = str_repeat($padding, max(0, $repeatCount));

    $nextIndex = $this->indexes[$i + 1] ?? PHP_INT_MAX;
    $currentIndex = $this->indexes[$i] ?? 0;
    $sliceLength = $nextIndex - $currentIndex;

    return $paddedSpace . mb_substr((string)$this->columns[$i], 0, $sliceLength);
  }
}
