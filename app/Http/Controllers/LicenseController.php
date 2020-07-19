<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Licenses;

class LicenseController extends Controller
{
	public function blockall($codLicense)
	{
		$license = new License();
		echo $license->VerifyLicense($codLicense);
	}
}