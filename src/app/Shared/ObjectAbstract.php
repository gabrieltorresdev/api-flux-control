<?php

namespace App\Shared;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Spatie\LaravelData\Data;

abstract class ObjectAbstract extends Data
{
    private static array $reflectionCache = [];
    private static array $useStatementsCache = [];

    /**
     * @throws Exception
     */
    public static function from(mixed ...$payloads): static
    {
        $instance = parent::from(...$payloads);
        $instance->processDtoArrays();
        return $instance;
    }

    /**
     * @throws Exception
     */
    public static function arrayOf(mixed ...$payloads): array
    {
        return array_map(fn($payload) => static::from($payload), ...$payloads);
    }

    /**
     * @throws Exception
     */
    private function processDtoArrays(): void
    {
        $reflectionClass = $this->getReflectionClass();
        foreach ($reflectionClass->getProperties() as $property) {
            $propertyName = $property->getName();
            $propertyValue = $this->{$propertyName};

            if ($this->isDtoArrayProperty($property) && is_array($propertyValue)) {
                $dtoClass = $this->getDtoClassFromProperty($property);
                $this->{$propertyName} = array_map(function ($item) use ($dtoClass) {
                    if ($this->isDtoSubclass($dtoClass)) {
                        /** @var Data $dtoClass */
                        return $dtoClass::from($item);
                    }
                    return new $dtoClass($item);
                }, $propertyValue);
            }
        }
    }

    private function isDtoArrayProperty(ReflectionProperty $property): bool
    {
        $docComment = $property->getDocComment();
        return $docComment !== false && preg_match('/@var\s+([^\s]+)\[\]/', $docComment) === 1;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private function getDtoClassFromProperty(ReflectionProperty $property): string
    {
        $docComment = $property->getDocComment();
        if ($docComment === false) {
            throw new Exception("Property {$property->getName()} does not have a @var annotation.");
        }

        preg_match('/@var\s+([^\s]+)\[\]/', $docComment, $matches);
        if (!isset($matches[1])) {
            throw new Exception("Unable to determine DTO class for property {$property->getName()}.");
        }

        return $this->resolveDtoClass($matches[1]);
    }

    /**
     * @throws ReflectionException
     */
    private function resolveDtoClass(string $className): string
    {
        $reflectionClass = $this->getReflectionClass();
        $namespace = $reflectionClass->getNamespaceName();
        $useStatements = $this->getUseStatements();

        return $useStatements[$className] ?? $namespace . '\\' . $className;
    }

    /**
     * @throws ReflectionException
     */
    private function isDtoSubclass(string $className): bool
    {
        $reflectionClass = new ReflectionClass($className);
        return $reflectionClass->isSubclassOf(Data::class);
    }

    /**
     * @throws ReflectionException
     */
    private function getReflectionClass(): ReflectionClass
    {
        $className = static::class;
        if (!isset(self::$reflectionCache[$className])) {
            self::$reflectionCache[$className] = new ReflectionClass($className);
        }

        return self::$reflectionCache[$className];
    }

    /**
     * @throws ReflectionException
     */
    private function getUseStatements(): array
    {
        $reflectionClass = $this->getReflectionClass();
        $file = $reflectionClass->getFileName();

        if (!isset(self::$useStatementsCache[$file])) {
            $content = file_get_contents($file);
            preg_match_all('/^use\s+([^\s]+);/m', $content, $matches);
            $useStatements = [];
            foreach ($matches[1] as $useStatement) {
                $parts = explode('\\', $useStatement);
                $shortName = array_pop($parts);
                $useStatements[$shortName] = $useStatement;
            }

            self::$useStatementsCache[$file] = $useStatements;
        }

        return self::$useStatementsCache[$file];
    }
}
