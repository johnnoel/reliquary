# Reliquary message system

[reliquary.johnnoel.uk](https://reliquary.johnnoel.uk/)

Inspired by the NieR Automata Reliquary System whereby upon the player's defeat, a "body" is left along with a message composed of three different parts chosen from lists of fixed phrases.

Here each message is only assignable to a single person which is managed by logging in via Twitter.

## Possibility space

1. 54 options
2. 123 options
3. 69 options

54 * 123 * 69 = 458,298 possible unique messages

## Stack

* [PHP 8.0](https://www.php.net)
* [Symfony 5.2](https://symfony.com)
* [Redis](https://redis.io)
* [Preact](https://preactjs.com)
* [Typescript](https://www.typescriptlang.org/)

## Visual

Based on the [UI design from NieR Automata](https://www.gameuidatabase.com/gameData.php?id=150).

### Accessibility

Some components aren't as accessible as they should be. Specific known issues include:

1. Colour contrast on the buttons on the homepage and "choose message" page - only AA complaint for large text
2. Colour contrast of the selected state for the "choose message" part - not compliant at all

Ideally the everything would be AAA accessible but this would involve deviating from the intended aesthetic. In this instance I've left as-is due to the niche nature of the audience but small tweaks to the colours could make a huge difference.

### Known changes

Some elements have been changed from the original UI design for ease or to ensure they work within a web context:

1. All selectable interface elements should have the "spaceship" selector appear when focused / active; the options on the "choose message" screen do not have this due to how overflow visibility works in CSS, i.e. if you set Y overflow to scroll but X to be visible, [X is changed to "auto"](https://stackoverflow.com/a/6433475). This makes the effect tricky to implement without restructuring the entire modal
2. No background shapes; the background should have abstract outline shapes in the top left and bottom right but don't as ensuring these don't overlap at different screen sizes and orientations was unmanageable
3. No grid overlay over certain elements; the grid effect is set as a background on the page and then left as-is but should overlay elements like the modal or buttons when present. This was too difficult to achieve quickly: as an overlay this would interfere with the interactive elements, and making elements transparent to "show" the grid messed with the colours

## Todo

1. Disable options that aren't usable as they have already been assigned - a tough problem as you'd need to keep three different sets: one that holds all the used keys if you select part 1 and part 2, one for all the keys if you select part 1 and part 3, and one for all the keys if you select part 2 and part 3. This becomes difficult to manage as at the moment there's no need to remove anything if someone changes their message. This also only becomes useful as the number of available messages becomes small
2. Multiple languages - I'm not sure how different versions of the game handle the 3-part message structure and whether that would need to be tweaked, apart from the interface though this should just be a case of updating [two](src/Service/MessageService.php) [files](frontend/options.ts)

## License

All of the code is released under the MIT License. If you make use of the code, it would be great to [hear from you](https://twitter.com/ceetea_).
