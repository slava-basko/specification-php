<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\AndSpecification;
use Basko\Specification\ConverseImpliesSpecification;
use Basko\Specification\ConverseNimplySpecification;
use Basko\Specification\FalseSpecification as FSpec;
use Basko\Specification\IdentitySpecification;
use Basko\Specification\ImpliesSpecification;
use Basko\Specification\NandSpecification;
use Basko\Specification\NimplySpecification;
use Basko\Specification\NorSpecification;
use Basko\Specification\NotSpecification;
use Basko\Specification\OrSpecification;
use Basko\Specification\TrueSpecification as TSpec;
use Basko\Specification\XnorSpecification;
use Basko\Specification\XorSpecification;
use Basko\SpecificationTest\Specification\DiamondsAceSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class SpecificationTest extends BaseTest
{
    public function testBasicLogic()
    {
        $this->assertTrue((new TSpec())->isSatisfiedBy(null));
        $this->assertFalse((new FSpec())->isSatisfiedBy(null));

        $iSpec = new IdentitySpecification();
        $this->assertTrue($iSpec->isSatisfiedBy(true));
        $this->assertFalse($iSpec->isSatisfiedBy(false));
        $this->assertTrue($iSpec->isSatisfiedBy(42));
        $this->assertFalse($iSpec->isSatisfiedBy(0));
        $this->assertTrue($iSpec->isSatisfiedBy("hello"));

        /**
         * Truth table NOT
         * P   ¬P
         * ------
         * T    F
         * F    T
         */
        $this->assertFalse((new NotSpecification(new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new NotSpecification(new FSpec()))->isSatisfiedBy(null));

        /**
         * Truth table AND
         * A   B   A ∧ B
         * -------------
         * F    F    F
         * F    T    F
         * T    F    F
         * T    T    T
         */
        $this->assertFalse((new AndSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new AndSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new AndSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new AndSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table OR
         * A   B   A ∨ B
         * -------------
         * F    F    F
         * F    T    T
         * T    F    T
         * T    T    T
         */
        $this->assertFalse((new OrSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new OrSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new OrSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new OrSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table A ↑ B
         * A   B   A ↑ B
         * -------------
         * F    F    T
         * F    T    T
         * T    F    T
         * T    T    F
         */
        $this->assertTrue((new NandSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new NandSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new NandSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new NandSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table A ↓ B
         * A   B   A ↓ B
         * -------------
         * F    F    T
         * F    T    F
         * T    F    F
         * T    T    F
         */
        $this->assertTrue((new NorSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new NorSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new NorSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new NorSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table XOR
         * A   B   A ⊕ B
         * -------------
         * F    F    F
         * F    T    T
         * T    F    T
         * T    T    F
         */
        $this->assertFalse((new XorSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XorSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XorSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new XorSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table for A ⊕ B ⊕ C
         * A   B   C   A ⊕ B ⊕ C
         * ----------------------
         * F   F   F       F
         * F   F   T       T
         * F   T   F       T
         * F   T   T       F
         * T   F   F       T
         * T   F   T       F
         * T   T   F       F
         * T   T   T       T
         */
        $this->assertFalse((new XorSpecification(new FSpec(), new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XorSpecification(new FSpec(), new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XorSpecification(new FSpec(), new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new XorSpecification(new FSpec(), new TSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XorSpecification(new TSpec(), new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new XorSpecification(new TSpec(), new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new XorSpecification(new TSpec(), new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XorSpecification(new TSpec(), new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table XNOR
         * A   B   A ⊙ B
         * -------------
         * F    F    T
         * F    T    F
         * T    F    F
         * T    T    T
         */
        $this->assertTrue((new XnorSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new XnorSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new XnorSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new XnorSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table for A ⇒ B (¬A ∨ B)
         * A   B   A ⇒ B
         * ----------------
         * F   F   T
         * F   T   T
         * T   F   F
         * T   T   T
         */
        $this->assertTrue((new ImpliesSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new ImpliesSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new ImpliesSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new ImpliesSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table for A ⇏ B (A ∧ ¬B)
         * A   B   A ⇏ B
         * ----------------
         * F   F   F
         * F   T   F
         * T   F   T
         * T   T   F
         */
        $this->assertFalse((new NimplySpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new NimplySpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new NimplySpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new NimplySpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table for A ⇐ B (A ∨ ¬B)
         * A   B   A ⇐ B
         * ----------------
         * F   F   T
         * F   T   F
         * T   F   T
         * T   T   T
         */
        $this->assertTrue((new ConverseImpliesSpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new ConverseImpliesSpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new ConverseImpliesSpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new ConverseImpliesSpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));

        /**
         * Truth table for A ⇍ B (¬A ∧ B)
         * A   B   A ⇍ B
         * ----------------
         * F   F   F
         * F   T   T
         * T   F   F
         * T   T   F
         */
        $this->assertFalse((new ConverseNimplySpecification(new FSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertTrue((new ConverseNimplySpecification(new FSpec(), new TSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new ConverseNimplySpecification(new TSpec(), new FSpec()))->isSatisfiedBy(null));
        $this->assertFalse((new ConverseNimplySpecification(new TSpec(), new TSpec()))->isSatisfiedBy(null));
    }

    public function testSpecification()
    {
        $spec = new DiamondsAceSpecification();

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );

        $this->assertNull(
            $spec->remainderUnsatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_ACE))
        );

        $this->assertEquals(
            new DiamondsAceSpecification(),
            $spec->remainderUnsatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_ACE))
        );
    }

    public function testNotSpecification()
    {
        $spec = new NotSpecification(new DiamondsAceSpecification());

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_ACE))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );
    }
}