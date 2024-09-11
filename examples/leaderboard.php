<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Smitmartijn\DiscordTableBuilder;

// Example: Game Leaderboard Table
$table = new DiscordTableBuilder\DiscordEmbedTable([
  'titles' => ['Position', 'Player', 'Points'],
  'padding' => 8
]);

$table->addRow(['1st', 'Charlie', '300'], ['url' => 'https://whatpulse.org']);
$table->addRow(['2nd', 'Dana', '250'], ['url' => 'https://typetest.io']);
$table->addRow(['3rd', 'Eve', '200'], ['url' => 'https://lostdomain.org']);
$table->addRow(['4th', 'Bob', '150'], ['url' => 'https://mutedeck.com']);
$table->addRow(['5th', 'Alice', '100']);

// From here you can use the $table object to render the table in a Discord API call
// this next part is the Discord API structure:
$messageContent = [
  "tts" => false,
  "embeds" => [
    [
      "title" => "Weekly Leaderboard",
      "description" => "Here are the top users for the last week!",
      "fields" => [$table->toField()],
    ]
  ]
];

var_dump($messageContent);

/**
 * The toField() method returns the following structure, nicely formatted as a table:
 *
 *  [`1st             Charlie        300`](https://whatpulse.org)
 *  [`2nd             Dana           250`](https://typetest.io)
 *  [`3rd             Eve            200`](https://lostdomain.org)
 *  [`4th             Bob            150`](https://mutedeck.com)
 *   `5th             Alice          100`"
 */
