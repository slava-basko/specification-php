# Specification Pattern

Encapsulate your business logic for readable, clear, and maintainable purposes.

Read it if you are not familiar with Specification pattern [http://www.martinfowler.com/apsupp/spec.pdf].


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
$adultUserTypesSpecification = new TypedSpecification(new AdultUserSpecification(), User::class);
$adultUserTypesSpecification->isSatisfiedBy(new User(20)); // true
$adultUserTypesSpecification->isSatisfiedBy('blah'); // InvalidArgumentException will be thrown
```


#### `TypedSpecification` VS `public function isSatisfiedBy(User $candidate)`
Of course, you can create your own specification interfaces with type hinting in `isSatisfiedBy`, 
but sooner or later you will see a lot of specifications that are similar by 99%.
```
public function isSatisfiedBy(User $user);
public function isSatisfiedBy(Product $product);
public function isSatisfiedBy(Cart $cart);
public function isSatisfiedBy(Parcel $parcel);
// etc.
```
Or you can use `TypedSpecification` decorator to achieve the same goal.


#### Other
This lib provided couple of useful prebuilt specifications like `AndSpecification` and `OrSpecification` 
that heals you to group up your specifications and create a new one.

## License
Use as you want. No liability or warranty from me. Can be considered as MIT.