<?php

namespace Basko\Specification;

final class Utils extends AbstractSpecification
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return mixed
     * @throws \Basko\Specification\Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize");
    }

    public function isSatisfiedBy($candidate)
    {
        return false;
    }

    /**
     * @param array|\Traversable $list
     * @return array
     */
    public static function flatten($list)
    {
        $result = [];
        foreach ($list as $value) {
            if (\is_array($value) || $value instanceof \Traversable) {
                $result = \array_merge($result, Utils::flatten($value));
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * Returns snake_case representation of specification.
     *
     * @param \Basko\Specification\Specification $specification
     * @return array|array[]|string
     */
    public static function toSnakeCase(Specification $specification)
    {
        if ($specification instanceof Nary) {
            $key = Utils::getName($specification);

            $result = [$key => []];
            foreach ($specification->container as $spec) {
                $result[$key][] = Utils::toSnakeCase($spec);
            }

            return $result;
        } elseif ($specification instanceof Binary) {
            return [Utils::getName($specification) => [
                Utils::toSnakeCase($specification->container[0]),
                Utils::toSnakeCase($specification->container[1])
            ]];
        } elseif ($specification instanceof Unary) {
            return [Utils::getName($specification) => Utils::toSnakeCase($specification->container)];
        } elseif ($specification instanceof TypedSpecification) {
            return Utils::toSnakeCase($specification->container);
        }

        return Utils::getName($specification);
    }

    /**
     * @param \Basko\Specification\Specification $specification
     * @return string
     */
    private static function getName(Specification $specification)
    {
        if (\method_exists($specification, '__toString')) {
            return (string)$specification;
        }

        $parts = \explode('\\', \get_class($specification));
        $className = \str_replace('Specification', '', \end($parts));
        \preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $className, $matches);
        $result = $matches[0];
        foreach ($result as &$match) {
            $match = $match == \strtoupper($match) ? \strtolower($match) : \lcfirst($match);
        }

        return \implode('_', $result);
    }
}
