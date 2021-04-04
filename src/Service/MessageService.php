<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Message;

class MessageService
{
    public const PART_1 = [
        'username' => '[Username]',
        'i' => 'I',
        'nameless' => 'A nameless android',
        'one' => 'One android',
        'wounded' => 'A wounded android',
        'black' => 'A black android',
        'humanoid' => 'A humanoid machine',
        'lonesoldier' => 'A lone soldier',
        'ferocious' => 'A ferocious soldier',
        'courageous' => 'A courageous soldier',
        'craven' => 'A craven soldier',
        'greedy' => 'A greedy soldier',
        'shrewd' => 'A shrewd soldier',
        'loyal' => 'A loyal soldier',
        'bohemian' => 'A bohemian soldier',
        'inexperienced' => 'An inexperienced soldier',
        'naive' => 'A naive soldier',
        'cooperative' => 'A cooperative soldier',
        'reckless' => 'A reckless soldier',
        'unremarkable' => 'An unremarkable soldier',
        'loneswordsman' => 'A lone swordsman',
        'passionate' => 'A passionate amazon',
        'lonelancer' => 'A lone lancer',
        'lonepugilist' => 'A lone pugilist',
        'dualwielder' => 'A dual-wielder',
        'weaponless' => 'A weaponless soldier',
        'beautiful' => 'A beautiful android',
        'small' => 'A small android',
        'doublecrossing' => 'A double-crossing android',
        'weaponcarrying' => 'A weapon-carrying android',
        'emotional' => 'An emotional android',
        'ruthless' => 'A ruthless android',
        'solitary' => 'A solitary android',
        'carefree' => 'A carefree android',
        'serious' => 'A serious android',
        'combatloving' => 'A combat-loving android',
        'natureloving' => 'A nature-loving android',
        'animalloving' => 'An animal-loving android',
        'sealoving' => 'A sea-loving android',
        'skyloving' => 'A sky-loving android',
        'earthloving' => 'An earth-loving android',
        'foolish' => 'A foolish doll',
        'hollowedout' => 'A hollowed-out doll',
        'dreamy' => 'A dreamy child',
        'just' => 'A just, young boy',
        'cursed' => 'A cursed child',
        'secretive' => 'A secretive girl',
        'suffering' => 'A suffering girl',
        'scared' => 'A scared girl',
        'vengeful' => 'A vengeful girl',
        'proud' => 'A proud man',
        'lone' => 'A lone woman',
        'withoutbeliefs' => 'A woman without beliefs',
        'broken' => 'A broken woman',
        'poorlamb' => 'A poor lamb',
    ];

    public const PART_2 = [
        'collapsed' => 'collapsed',
        'fell' => 'fell',
        'powerless' => 'felt utterly powerless',
        'careless' => 'was careless',
        'laughed' => 'laughed at the enemy\'s strength',
        'shocked' => 'was shocked at what happened',
        'sought' => 'sought more strength',
        'mistake' => 'regretted a mistake',
        'ambushed' => 'was ambushed by the enemy',
        'surrounded' => 'was surrounded by enemies',
        'amused' => 'was amused by how it all ended',
        'revenge' => 'vowed revenge',
        'grace' => 'fell with grace',
        'ounce' => 'fought with every ounce of strength',
        'vengeance' => 'vowed vengeance',
        'despair' => 'felt despair at this cold world',
        'heldnothing' => 'held nothing back',
        'gave' => 'gave it all',
        'getup' => 'could not get up again',
        'grow' => 'vowed to grow as a person',
        'grimaced' => 'grimaced in anger',
        'missed' => 'missed the chance of a lifetime',
        'weakpoint' => 'couldn\'t find a weakpoint',
        'overwhelmed' => 'was overwhelmed',
        'outmatched' => 'was totally outmatched',
        'flower' => 'was distracted by a flower',
        'hesitated' => 'hesitated to land the killing blow',
        'behind' => 'was attacked from behind',
        'ground' => 'fell to the ground',
        'hit' => 'couldn\'t even get a hit in',
        'lazy' => 'was too damn lazy',
        'underestimated' => 'underestimated the enemy',
        'facedaway' => 'faced away from the enemy',
        'fear' => 'learned to fear the enemy',
        'overcome' => 'was overcome by fear',
        'perform' => 'couldn\'t perform as well as usual',
        'topform' => 'wasn\'t in top form',
        'allout' => 'failed to go all-out',
        'powerful' => 'tried taking on a powerful foe',
        'limit' => 'took it to the limit',
        'corner' => 'was backed into a corner',
        'bravely' => 'fought bravely',
        'brave' => 'fought a brave battle',
        'challenged' => 'challenged the enemy foolishly',
        'valiantly' => 'fought valiantly',
        'lost' => 'lost the battle',
        'honorable' => 'died an honorable death',
        'valuable' => 'learned a valuable lesson',
        'slipaway' => 'felt life slip away',
        'tough' => 'enjoyed a tough battle',
        'smiling' => 'never stopped smiling',
        'fate' => 'felt the hand of fate',
        'intel' => 'applied all combat intel',
        'trapped' => 'was trapped on the defensive',
        'tables' => 'had the tables turned',
        'almost' => 'almost won',
        'admired' => 'admired the enemy\'s strength',
        'wall' => 'hit a wall',
        'smile' => 'couldn\'t help but smile',
        'cried' => 'cried and cried',
        'courage' => 'lost all courage',
        'think' => 'stopped trying to think',
        'doubleko' => 'suffered a double KO',
        'fellalong' => 'fell along with the enemy',
        'nothing' => 'regretted nothing',
        'giveup' => 'didn\'t give up until the very end',
        'doubt' => 'gave in to doubt',
        'fast' => 'wasn\'t fast enough',
        'died' => 'died',
        'killed' => 'got killed',
        'memory' => 'became a beautiful memory',
        'wind' => 'became the wind',
        'peacefully' => 'died peacefully',
        'bitter' => 'saw a bitter enemy',
        'patheticlump' => 'saw a pathetic lump of metal',
        'invaders' => 'saw conquering invaders',
        'takeover' => 'saw the enemy take over Earth',
        'emotionless' => 'saw emotionless machines',
        'imitating' => 'saw a machine imitating a human',
        'ponder' => 'saw a machine ponder life and death',
        'wandering' => 'saw a machine wandering around',
        'protecting' => 'saw solder protecting their land',
        'parade' => 'saw machines enjoying a parade',
        'dancing' => 'saw a machine dancing like mad',
        'believed' => 'saw machines that believed in the uncertain',
        'deepthought' => 'saw a machine in deep thought',
        'caring' => 'saw a caring machine',
        'love' => 'saw a machine full of love',
        'flying' => 'saw a machine flying around',
        'end' => 'saw a machine end it all',
        'combat' => 'saw a machine living for combat',
        'eating' => 'saw a machine eating its own kind',
        'humans' => 'saw a machine in love with humans',
        'lostmachine' => 'saw a lost machine',
        'sand' => 'saw a machine buried in sand',
        'tree' => 'saw a machine behind a tree',
        'dreams' => 'saw a machine with dreams',
        'junk' => 'saw a machine living in junk',
        'walk' => 'saw a machine taking a walk',
        'skies' => 'saw a machine cover the skies',
        'footsteps' => 'heard the footsteps of machines',
        'crazed' => 'heard the screams of crazed machines',
        'friends' => 'thought of many friends',
        'victory' => 'wished for a friend\'s victory',
        'lovedone' => 'thought of a loved one',
        'vision' => 'saw a vision of those lost',
        'nostalgic' => 'saw something strange yet nostalgic',
        'blue' => 'saw a blue bird',
        'whitebook' => 'saw a white book',
        'black' => 'saw a black book',
        'whiteflower' => 'saw a white flower',
        'flora' => 'saw swaying flora',
        'flowing' => 'heard the sound of flowing water',
        'waves' => 'heard the sound of waves',
        'call' => 'heard the call of friends',
        'coldness' => 'felt the coldness of water',
        'heat' => 'felt the heat of sand',
        'companions' => 'saw old companions',
        'yorha' => 'saw a YoRHa once considered a friend',
        'redeyes' => 'saw an android with red eyes',
        'gazing' => 'saw red eyes gazing down',
        'squadmates' => 'saw squadmates lose their minds',
        'screams' => 'heard the screams of crazed androids',
        'laughing' => 'heard a girl laughing merrily',
    ];

    public const PART_3 = [
        'cradle' => 'in a cradle in the sky',
        'bunker' => 'at the Bunker, looking at Earth',
        'hq' => 'at YoRHa HQ',
        'city' => 'at a city drowned in green',
        'ruins' => 'at the ruins of civilization',
        'nature' => 'at a city consumed by nature',
        'deserted' => 'in a deserted land',
        'gaping' => 'at a city with a gaping hole',
        'reclaimed' => 'in a city reclaimed by nature',
        'mountain' => 'at a mountain of metal',
        'capital' => 'at the capital of junk',
        'religious' => 'at a religious mountain',
        'scrapiron' => 'at the home of scrap-iron',
        'vain' => 'in a vain forest',
        'deep' => 'in a deep, dark forest',
        'lush' => 'in a lush forest',
        'kingdom' => 'at the kingdom of machines',
        'dreams' => 'in a world of ended dreams',
        'distorted' => 'in a land of distorted fairy tales',
        'light' => 'at a city filled with light',
        'theater' => 'at a closed theater',
        'empty' => 'at an empty theater',
        'sunken' => 'at a sunken city',
        'water' => 'at a city consumed by water',
        'drenched' => 'at a city drenched in blue',
        'fake' => 'at a fake city',
        'manufactured' => 'at a manufactured city',
        'boxes' => 'at a city of boxes',
        'buildingblocks' => 'at a city of building blocks',
        'inorganic' => 'at an inorganic city',
        'copied' => 'at a copied city',
        'desert' => 'in a desert of shadows',
        'sandworld' => 'in a world of sand',
        'sanddays' => 'in days of sand',
        'death' => 'surrounded by the winds of death',
        'darkhold' => 'in a dark hold beneath a city',
        'underground' => 'underground',
        'lair' => 'at the enemy\'s lair',
        'ship' => 'inside an empty ship',
        'tower' => 'at a tower built by the gods',
        'angels' => 'on a tower smiled upon by angels',
        'tall' => 'inside a tall tower',
        'village' => 'at a peace-loving village',
        'refugees' => 'at a village of refugees',
        'freeskies' => 'in the free skies',
        'darkskies' => 'below dark skies',
        'battlefieldsea' => 'at a battlefield on the sea',
        'decisive' => 'during the decisive battle',
        'pointless' => 'during a pointless battle',
        'pastures' => 'on green pastures',
        'shining' => 'on a shining blue surface',
        'steel' => 'on ground of steel',
        'collapsed' => 'on a collapsed building',
        'drysand' => 'on dry sand',
        'earth' => 'looking down on Earth',
        'hell' => 'in the depths of hell',
        'abyss' => 'in the abyss',
        'deepest' => 'in the deepest darkness',
        'battlefieldblood' => 'at a blood-soaked battlefield',
        'past' => 'at a land stuck in the past',
        'memories' => 'at a place of memories',
        'live' => 'in the land where he used to live',
        'over' => 'over there',
        'there' => 'there',
        'garbage' => 'at a garbage dump',
        'countryside' => 'in the boring countryside',
        'dull' => 'somewhere very dull',
        'fit' => 'at a place fit to die',
        'verydark' => 'somewhere very dark',
        'confusing' => 'in a confusing place',
    ];

    public function __construct(private \Redis $redis)
    {
    }

    public function getMessageByTwitterId(string $twitterId): ?Message
    {
        $messageJson = $this->redis->hGet('messages', $twitterId);

        if ($messageJson === false) {
            return null;
        }

        $json = json_decode($messageJson);

        if ($json === null || !$this->isValidMessage($json->p1, $json->p2, $json->p3)) {
            return null;
        }

        $part1 = str_replace('[Username]', $json->n, self::PART_1[$json->p1]);
        $part2 = self::PART_2[$json->p2];
        $part3 = self::PART_3[$json->p3];

        $message = implode(' ', [ $part1, $part2, $part3 ]);

        return new Message($twitterId, $json->n, $message, $json->p1, $json->p2, $json->p3);
    }

    public function isMessageAvailable(string $part1, string $part2, string $part3): bool
    {
        if (!$this->isValidMessage($part1, $part2, $part3)) {
            return false;
        }

        return !$this->redis->sIsMember('takenMessages', $this->getMessageKey($part1, $part2, $part3));
    }

    public function assignMessage(
        string $twitterId,
        string $twitterName,
        string $part1,
        string $part2,
        string $part3
    ): void {
        $json = json_encode([
            'n' => $twitterName,
            'p1' => $part1,
            'p2' => $part2,
            'p3' => $part3,
        ]);

        if ($json === false) {
            throw new \RuntimeException('Unable to JSON encode message');
        }

        $this->redis->hSet('messages', $twitterId, $json);
        $this->redis->sAdd('seenTwitterIds', $twitterId);
        $this->redis->sAdd('takenMessages', $this->getMessageKey($part1, $part2, $part3));
    }

    public function getRandomTwitterId(): string
    {
        return $this->redis->sRandMember('seenTwitterIds');
    }

    private function isValidMessage(string $part1, string $part2, string $part3): bool
    {
        return
            array_key_exists($part1, self::PART_1) &&
            array_key_exists($part2, self::PART_2) &&
            array_key_exists($part3, self::PART_3)
        ;
    }

    private function getMessageKey(string $part1, string $part2, string $part3): string
    {
        return implode('|', [ $part1, $part2, $part3 ]);
    }
}
