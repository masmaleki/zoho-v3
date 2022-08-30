<?php

namespace Masmaleki\ZohoAllInOne\Commands;

use Illuminate\Console\Command;

class ZohoAllInOneCommand extends Command
{
    public $signature = 'zoho-v3';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
