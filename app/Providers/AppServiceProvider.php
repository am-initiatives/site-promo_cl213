<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BindersLoader;
use App\Services\RouterWithPermissions;

use Html;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{


		setlocale(LC_TIME, 'French');
		\Carbon\Carbon::setLocale('fr');

		Html::macro('solde', function($value, $unit = NULL)
		{
			$solde[] = number_format($value, 2);
			if (isset($unit)) {
				$solde[] = $unit;
			}

			$color = $value < 0 ? '#A00' : '#08A';

			return '<strong style="color: '.$color.'">'.join(" ", $solde).'</strong>';
		});


		Html::macro('diff', function($date)
		{
			if(!$date)
				return "Jamais";
			
			if ($date->diffInSeconds() <= 60) {
				$result = 'À l’instant';
			} elseif ($date->diffInDays() <= 7) {
				if ($date->isYesterday()) {
					$result = 'hier, à ' . $date->format('G:i');
				} else {
					$result = $date->diffForHumans(null, true);
				}
			} elseif ($date->diffInYears() <= 1) {
				$result = utf8_encode($date->formatLocalized('%d %B'));
			} else {
				$result = utf8_encode($date->formatLocalized('%d %B %Y'));
			}

			return ucfirst($result);
		});

		Html::macro('userIcons',function($user){
			$data = "";
			if($user->hasPermission("admin")){
				$data.='<i class="fa fa-star" title="Administrateur"></i>';
			}
			if($user->hidden){
				$data.='<i class="fa fa-user-secret" title="Caché"></i>';
			}
			return $data;
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton("transaction_factory","App\Services\TransactionFactory");
	}
}
