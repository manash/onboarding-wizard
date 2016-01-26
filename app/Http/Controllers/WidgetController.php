<?php namespace App\Http\Controllers;
use App\Models\Wizard;
use Request, Auth;

class WidgetController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->wizardModel = new Wizard();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getWizardSteps()
	{

	}

	public function dashboard() {
		return view('dashboard');
	}
}