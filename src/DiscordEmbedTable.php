<?php

namespace Smitmartijn\DiscordTableBuilder;

/**
 * @package Smitmartijn\DiscordTableHelper
 * @version 1.0.0
 * @license GNU General Public License v3.0
 * @link
 */

/**
 * This is the main class, used to create a table for a Discord embed.
 */
class DiscordEmbedTable
{
  // The titles of the table
  private $titles;
  // The column widths of the table, initialized based on the titles
  private $columnWidths;
  // The start of the row (e.g. '`')
  public $start;
  // The end of the row (e.g. '`')
  public $end;
  // The padding between the columns
  public $padding;
  // The rows of the table
  private $rows;
  // Whether to use white space or not
  private $whiteSpace;

  public function __construct(array $options)
  {
    $this->titles = $options['titles'] ?? throw new \Exception('Titles/headers are required');
    $this->start = $options['start'] ?? '`';
    $this->end = $options['end'] ?? '`';
    $this->padding = $options['padding'] ?? 0;
    $this->whiteSpace = $options['whiteSpace'] ?? false;
    $this->rows = [];

    // Initialize column widths based on titles
    $this->columnWidths = array_map('strlen', $this->titles);
  }

  public function addRow(array $columns, array $options = []): self
  {
    // Store the raw column data
    $this->rows[] = [
      'columns' => $columns,
      'url' => $options['url'] ?? null
    ];

    // Update column widths
    $this->updateColumnWidths($columns);

    return $this;
  }

  /**
   * @param array $columns The columns of the row
   *
   * This function is used to update the column widths based on the columns of the row.
   */
  private function updateColumnWidths(array $columns): void
  {
    foreach ($columns as $i => $column) {
      $this->columnWidths[$i] = max($this->columnWidths[$i] ?? 0, strlen($column));
    }
  }

  /**
   * @param array $rowData The data of the row
   * @return string The rendered row
   *
   * This function is used to render a row of the table.
   */
  private function renderRow(array $rowData): string
  {
    $rowString = $this->start;
    foreach ($rowData['columns'] as $i => $column) {
      $padding = $this->whiteSpace ? "\u{200B}" : ' ';
      $rowString .= str_pad($column, $this->columnWidths[$i] + $this->padding, $padding);
    }
    $rowString = rtrim($rowString) . $this->end;

    if (isset($rowData['url'])) {
      $rowString = "[{$rowString}]({$rowData['url']})";
    }

    return $rowString;
  }

  /**
   * @return string The rendered title row
   *
   * This function is used to render the title row of the table.
   */
  private function renderTitleRow(): string
  {
    $titleString = $this->start;
    foreach ($this->titles as $i => $title) {
      $padding = $this->whiteSpace ? "\u{200B}" : ' ';
      $titleString .= str_pad($title, $this->columnWidths[$i] + $this->padding, $padding);
    }
    return rtrim($titleString) . $this->end;
  }

  /**
   * @param array $options The options for the field
   * @return array The field
   *
   * This function is used to convert the table to a field that can be used in the Discord API.
   */
  public function toField(array $options = []): array
  {
    $titleRow = $this->renderTitleRow();
    $rows = array_map([$this, 'renderRow'], $this->rows);

    $field = [
      'name' => $titleRow,
      'value' => implode("\n", $rows),
      'inline' => $options['inline'] ?? false
    ];

    if (!($options['keepRows'] ?? false)) $this->clear();

    return $field;
  }

  public function toString(array $options = []): string
  {
    $titleRow = $this->renderTitleRow();
    $rows = array_map([$this, 'renderRow'], $this->rows);
    $string = $titleRow . "\n" . implode("\n", $rows);

    if (!($options['keepRows'] ?? false)) $this->clear();

    return $string;
  }

  public function hasRows(): bool
  {
    return count($this->rows) > 0;
  }

  private function clear(): void
  {
    $this->rows = [];
  }
}
