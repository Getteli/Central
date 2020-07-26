<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Licenses;

class LicenseController extends Controller
{
	public function blockall($codLicense)
	{
		$license = new Licenses();
		echo $license->VerifyLicense($codLicense);
	}

	public function UpdatePaymenteCliente($codLicense)
	{
		$license = new Licenses();
		$license = $license->PaymenteCliente($codLicense);
		return $license;
	}
}