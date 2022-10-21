<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jarvis Tang
 * Released under the Apache-2.0 License.
 */

namespace Fresns\MarketManager\Listeners;

use Fresns\MarketManager\Models\Plugin as PluginModel;
use Fresns\MarketManager\Support\Json;
use Fresns\ThemeManager\Theme;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ThemeInstallingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $unikey = $event['unikey'] ?? null;
        if (! $unikey) {
            return;
        }

        if (! class_exists(Theme::class)) {
            return;
        }

        $theme = new Theme($unikey);
        $themeJson = Json::make($theme->getThemeJsonPath())->get();
        if (! $themeJson) {
            \info('Failed to write theme information to database');

            return;
        }

        $themeType = 4;
        $themeJson['type'] = $themeType;

        $plugin = PluginModel::addPlugin($themeJson);
    }
}
