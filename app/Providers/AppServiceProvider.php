<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ChatKit', function() {
            return new \Chatkit\Chatkit([
                'instance_locator' => config('services.chatkit.locator'),
                'key' => config('services.chatkit.secret'),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('levelonly', function ($expression) {
            $level = trim($expression, '()');

            return "<?php if (Auth::check() && Auth::user()->level() == {$level}): ?>";
        });

        Blade::directive('endlevelonly', function () {
            return '<?php endif; ?>';
        });
    }
}
