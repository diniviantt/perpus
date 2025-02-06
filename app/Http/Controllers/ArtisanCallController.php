<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ArtisanCallController extends Controller
{
    public function down()
    {
        try {
            Artisan::call('down --refresh=60 --secret='.env('MAINTENANCE_SECRET_TOKEN', 'orzcode'));
            Log::info('Application is now in maintenance mode.');

            return redirect('/'.env('MAINTENANCE_SECRET_TOKEN', 'orzcode'));
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('dashboard');
        }
    }

    public function up()
    {
        try {
            Artisan::call('up');
            Log::info('Application is now live.');

            flash('Application is now live.');

            return to_route('dashboard');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('dashboard');
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('optimize:clear');
            Log::info('Clearing cached bootstrap files.');

            flash('Clearing cached bootstrap files.');

            return to_route('dashboard');
        } catch (\Throwable $err) {
            Log::error($err->getMessage());

            flash('[500] Server Error', 'err');

            return to_route('dashboard');
        }
    }
}
