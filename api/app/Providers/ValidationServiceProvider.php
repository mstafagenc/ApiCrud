<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public const JSON_INJECTION_KEY = 'json-injection';

    public function boot(): void
    {
        // ...
        $this->injectJsonTranslations();
    }

    /**
     * Because of Laravel's ValidationException::summarize function only supports JSON translations,
     * we are injecting some strings into Laravel's Lang engine to make the function's translation
     * work with php lang files.
     *
     * @see ValidationException::summarize()
     */
    protected function injectJsonTranslations(): void
    {
        $locales = collect(scandir(lang_path()))
            ->filter(fn (string $locale) => !Str::startsWith($locale, '.'));

        $locales->map(function (string $locale): void {
            $langFilePath = lang_path("{$locale}/validation.php");

            if (!file_exists($langFilePath)) {
                return;
            }

            $languageStrings = require $langFilePath;

            if (array_key_exists(self::JSON_INJECTION_KEY, $languageStrings)) {
                foreach ($languageStrings[self::JSON_INJECTION_KEY] as $key => $value) {
                    Lang::addLines(["*.{$key}" => $value], $locale);
                }
            }
        });
    }
}