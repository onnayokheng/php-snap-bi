<?php

namespace Otnansirk\SnapBI\Traits;


trait HasConfig
{
    private static $configs = [];

    /**
     * Required config fields
     *
     * @var array
     */
    private static $requiredConfigFields = [
        "ssh_private_key",
        "ssh_public_key",
        "client_secret",
        "client_id",
        "account_id",
        "partner_id",
        "channel_id",
        "base_url"
    ];

    /**
     * Register configs
     *
     * @param array $configs
     * @return void
     */
    public function register(array $configs = []): void
    {
        foreach (self::$requiredConfigFields as $field) {
            if (!isset($configs[$field]) || empty($configs[$field])) {
                throw new \InvalidArgumentException("$field is Required");
            }
            self::$configs[$field] = $configs[$field];
        }

        self::$configs = array_merge(self::$configs, $configs);
    }

    /**
     * Get all configs
     *
     * @return array
     */
    static function all(): array
    {
        return self::$configs;
    }

    /**
     * Get single config
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    static function get(string $name, mixed $default = null): mixed
    {
        $keys = explode('.', $name);
        $value = self::$configs;

        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                return ($default) ? $default: null;
            }
        }

        return $value;
    }

}