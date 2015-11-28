<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\Validates;

abstract class Controller extends BaseController
{
	use DispatchesJobs, Validates;
}
