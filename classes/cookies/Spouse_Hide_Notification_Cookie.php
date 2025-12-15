<?php

if (!interface_exists('CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data')) {
    return;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Spouse_Hide_Notification_Cookie implements Known_Cookie_Data
{
    // Name of the service or functionality issuing the cookie
    public function issuer(): string
    {
        return 'Spouseprogram';
    }

    // Name of the cookie, if the name has variable suffix, append _* to the name
    public function name(): string
    {
        return 'hidenotification';
    }

    // Cookie name for humans, shown on the consent banner and settings
    public function label(): string
    {
        return 'hidenotification';
    }

    // Translated description of what the cookie is used for
    public function descriptionTranslations(): array
    {
        return array(
            'en' => 'Remembers to hide the news notification if user has closed it'
        );
    }

    // Retention time translations
    public function retentionTranslations(): array
    {
        return array(
            'en' => 'persistent'
        );
    }

    // Supported types: cachestorage, indexeddb, localstorage, sessionstorage
    // Invalid type will be marked as unknown
    public function type(): string
    {
        return 'localstorage';
    }

    // Supported categories: preferences, functional, marketing, statistics, statistics_anonymous
    // Invalid category will be marked as unknown
    public function category(): string
    {
        return 'functional';
    }
}