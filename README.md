# Specification Pattern

Encapsulate your business decisions for readable, clear, and maintainable purposes.
In simpler words: encapsulate your business's IF's and ELSE's, and speak with clients on the same language.

Read it if you are not familiar with Specification pattern [http://www.martinfowler.com/apsupp/spec.pdf].

This library has no dependencies on any external libs and works on PHP 5.5+. Why?
Because legacy projects still exists, and they also want some structure.

## Install

```bash
composer require slava-basko/specification-php
```

## Usage

Let's imagine that we have the specification of an Adult Person.

```php
class AdultUserSpecification extends AbstractSpecification
{
    /**
     * @param User $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->getAge() >= 18;
    }
}
```

Now let's check if the user is actually an adult.

```php
$adultUserSpecification = new AdultUserSpecification();
$adultUserSpecification->isSatisfiedBy(new User(14)); // false
$adultUserSpecification->isSatisfiedBy(new User(20)); // true
```

Use `TypedSpecification` decorator/wrapper if you want typed specification.

```php
$adultUserSpecification = new TypedSpecification(new AdultUserSpecification(), User::class);
$adultUserSpecification->isSatisfiedBy(new User(20)); // true
$adultUserSpecification->isSatisfiedBy('blah'); // InvalidArgumentException will be thrown
```

#### `TypedSpecification` VS `public function isSatisfiedBy(User $candidate)`

Of course, you can create your own specification interfaces with type hinting in `isSatisfiedBy`,
but sooner or later you will see a lot of interfaces that are similar by 99%.

```php
interface UserSpecification
{
    public function isSatisfiedBy(User $user);
}

interface ProductSpecification
{
    public function isSatisfiedBy(Product $product);
}

interface CartSpecification
{
    public function isSatisfiedBy(Cart $cart);
}

interface ParcelSpecification
{
    public function isSatisfiedBy(Parcel $parcel);
}
// etc.
```

Or you can use `TypedSpecification` decorator to achieve the same goal.

```php
new TypedSpecification(new SomeUserSpecification(), User::class);
new TypedSpecification(new SomeProductSpecification(), Product::class);
new TypedSpecification(new SomeCartSpecification(), Cart::class);
new TypedSpecification(new SomeParcelSpecification(), Parcel::class);
```

#### Autocompletion

Use the doc-block type hinting in your end specifications for autocompletion, like `@param User $candidate`.

```php
/**
 * @param User $candidate
 * @return bool
 */
public function isSatisfiedBy($candidate)
{
    return $candidate->someMethodThatWillBeAutocompletedInYourIDE();
}
```

`TypedSpecification` guaranty that `$candidate` will be an instance of `User` class,
and doc-block `@param User $candidate` helps your IDE to autocomplete `$candidate` methods.

#### Composition

This lib provides useful builtin specifications like `NotSpecification`, `AndSpecification`, `OrSpecification`, 
etc. (https://en.wikipedia.org/wiki/Logical_connective) that helps you to group up your specifications and create a new one.

```php
$adultPersonSpecification = new AndSpecification([
    new AdultSpecification(),
    new OrSpecification([
        new MaleSpecification(),
        new FemaleSpecification(),
    ])
]);

$adultPersonSpecification->isSatisfiedBy($adultAlien); // false
// because only AdultSpecification was satisfied; assume we know age, and we don't know alien sex.
```

Here is another example that shows how highly composable specifications could be.

```php
// Card of spades and not (two or three of spades), or (card of hearts and not (two or three of hearts))
$spec = new OrSpecification([
    new AndSpecification([
        new SpadesSpecification(),
        new NorSpecification([
            new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2),
            new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_3)
        ])
    ]),
    new AndSpecification([
        new HeartsSpecification(),
        new NorSpecification([
            new PlayingCardSpecification(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_2),
            new PlayingCardSpecification(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_3)
        ])
    ]),
]);

$spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_4)); // true
$spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2)); // false
```

#### Remainders

Method `isSatisfiedBy` returns `bool`, and sometimes in case of `false` you want to know what exactly has gone wrong.
Use `remainderUnsatisfiedBy` method for that. It returns a remainder of unsatisfied specifications.

```php
$parcel = [
    'value' => 20,
    'destination' => 'CA'
];

$trackableParcelSpecification = new AndSpecification([
    new HighValueParcelSpecification(),
    new OrSpecification([
        new DestinationCASpecification(),
        new DestinationUSSpecification(),
    ])
]);

if ($trackableParcelSpecification->isSatisfiedBy($parcel)) {
    // do something
} else {
    $remainderSpecification = $trackableParcelSpecification->remainderUnsatisfiedBy($parcel);
    // do something with $remainderSpecification
}

// $remainderSpecification is equal to
//
// AndSpecification([
//      HighValueParcelSpecification
// ]);
//
// because only DestinationXX satisfied
```

You can use `Utils` to convert it to useful array.

```php
$remainder = Utils::flatten(Utils::toSnakeCase($trackableParcel->remainderUnsatisfiedBy($parcel)));
// $remainder is equal to ['high_value_parcel']
```

For example, you can use strings inside `$remainder` like `high_value_parcel` as a translation key
to show meaningful error message.

## License

Use as you want. No liability or warranty from me. Can be considered as MIT.