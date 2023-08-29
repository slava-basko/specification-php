<?php

namespace Basko\SpecificationTest\Value;

class PlayingCard
{
    const SUIT_HEARTS = '♥';
    const SUIT_DIAMONDS = '♦';
    const SUIT_CLUBS = '♣';
    const SUIT_SPADES = '♠';

    const RANK_ACE = 14;
    const RANK_KING = 13;
    const RANK_QUEEN = 12;
    const RANK_JACK = 11;
    const RANK_10 = 10;
    const RANK_9 = 9;
    const RANK_8 = 8;
    const RANK_7 = 7;
    const RANK_6 = 6;
    const RANK_5 = 5;
    const RANK_4 = 4;
    const RANK_3 = 3;
    const RANK_2 = 2;

    public static $possibleSuites = [
        self::SUIT_HEARTS,
        self::SUIT_DIAMONDS,
        self::SUIT_CLUBS,
        self::SUIT_SPADES,
    ];

    public static $possibleRanks = [
        self::RANK_ACE,
        self::RANK_KING,
        self::RANK_QUEEN,
        self::RANK_JACK,
        self::RANK_10,
        self::RANK_9,
        self::RANK_8,
        self::RANK_7,
        self::RANK_6,
        self::RANK_5,
        self::RANK_4,
        self::RANK_3,
        self::RANK_2,
    ];

    public $suit;
    public $rank;

    public function __construct($suit, $rank)
    {
        if (!in_array($suit, self::$possibleSuites)) {
            throw new \InvalidArgumentException('Unknown suit');
        }

        if (!in_array($rank, self::$possibleRanks)) {
            throw new \InvalidArgumentException('Unknown rank');
        }

        $this->suit = $suit;
        $this->rank = $rank;
    }
}
