# Discord Table Builder

This PHP package is a simple helper to create tables for discord messages, as there's no native way to do it. Send an embed with the result of this package to format an awesome table in your Discord messages.

* Figures out the width of each column based on the content
* Unlimited rows/columns (Discord API dependent)
* Make a row link to a URL
*

## Installation

```bash
composer require smitmartijn/discord-table-builder
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';
use Smitmartijn\DiscordTableBuilder;

// Example: Game Leaderboard Table
$table = new DiscordTableBuilder\DiscordEmbedTable([
  'titles' => ['Position', 'Player', 'Points'],
  'padding' => 8
]);

$table->addRow(['1st', 'Charlie', '300'], ['url' => 'https://lostdomain.org']);
$table->addRow(['2nd', 'Alice', '100']);

// From here you can use the $table object to render the table in a Discord API call
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
// use your own function to send the message to Discord
sendToDiscord($messageContent);
```

## Example Output

Here is an example of the DiscordTableBuilder in action with multiple tables in a single embed.

![Example Output](./examples/discord-message-example.png)

The `toField()` method returns a Discord embed field object. You can use this in your Discord API call to render the table in a Discord message.

```
/**
 * The toField() method returns the following structure, nicely formatted as a table:
 *
 *  [`1st             Charlie        300`](https://whatpulse.org)
 *  [`2nd             Dana           250`](https://typetest.io)
 *  [`3rd             Eve            200`](https://lostdomain.org)
 *  [`4th             Bob            150`](https://mutedeck.com)
 *   `5th             Alice          100`"
 */
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

This package is licensed under the GNU General Public License v3.0. See the [LICENSE](LICENSE) file for more information.
