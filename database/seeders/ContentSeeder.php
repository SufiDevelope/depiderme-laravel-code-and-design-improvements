<?php

namespace Database\Seeders;

use App\Services\ContentService;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        app(ContentService::class)->syncFromConfig();
    }
}
