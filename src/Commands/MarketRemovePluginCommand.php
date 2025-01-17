<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace Fresns\MarketManager\Commands;

use Illuminate\Console\Command;

class MarketRemovePluginCommand extends Command
{
    protected $signature = 'market:remove-plugin {fskey}
        {--cleardata=}';

    protected $description = 'remove fresns plugin';

    public function handle()
    {
        $fskey = $this->argument('fskey');

        // uninstall plugin
        $exitCode = $this->call('plugin:uninstall', [
            'fskey' => $fskey,
            '--cleardata' => $this->option('cleardata') ?? 0,
        ]);

        if ($exitCode == 0) {
            $this->info("Delete plugin data successfully: $fskey");
        }

        return $exitCode;
    }
}
