<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\SpecificationTest\Specification\DiamondsAceSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class InvokableSpecificationTest extends BaseTest
{
    public function testInvokableSpecification()
    {
        $spec = new DiamondsAceSpecification();

        $this->assertTrue(
            call_user_func($spec, new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );
    }
}