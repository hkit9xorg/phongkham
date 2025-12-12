<?php

class Env
{
    private static array $cache = [];

    public static function load(string $path = __DIR__ . '/../.env'): void
    {
        if (!empty(self::$cache)) {
            return;
        }

        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $line, 2));
            $value = trim($value, "\"'");
            self::$cache[$key] = $value;
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        if (empty(self::$cache)) {
            self::load();
        }

        return self::$cache[$key] ?? $default;
    }
}
