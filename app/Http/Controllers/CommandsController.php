<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use function Laravel\Prompts\alert;

class CommandsController extends Controller
{
    public function seed(): void
    {
        Artisan::call('db:seed');

        var_dump('success');
    }
}
