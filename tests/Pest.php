<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/*
|--------------------------------------------------------------------------
| Pest Test Case Configuration
|--------------------------------------------------------------------------
|
| Tất cả các file trong thư mục tests/Feature và tests/Unit
| sẽ tự động extend TestCase của Laravel, có sẵn:
| - $this->get(), $this->post(), $this->put(), $this->delete(), ...
| - $this->artisan()
| - $this->faker
| - RefreshDatabase để reset DB
|
*/

uses(
    TestCase::class,
    RefreshDatabase::class,
    WithFaker::class
)->in('Feature', 'Unit');
