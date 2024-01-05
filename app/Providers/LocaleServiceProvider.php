<?php

namespace App\Providers;

use App\Enums\Locale\LocalesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Translation\Translator as BaseTranslator;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $request = app(Request::class);

        if ($request->get('locale')) {
            $localeFromRequest = $request->get('locale');
            if ($localeFromRequest && LocalesEnum::tryFrom($localeFromRequest)) {
                $this->app->setLocale($localeFromRequest);
            }
        }

        $locale = $this->app->getLocale();

        $this->app->singleton(Translator::class, function ($app) use ($locale) {
            return new BaseTranslator($app['translation.loader'], $locale);
        });
    }
}
