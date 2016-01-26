<?php namespace App\Http\Controllers;
use App\Models\User;
use Request, Auth, Session;

class UserController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
		$this->userModel = new User();
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index () {
		if (Auth::user()) {
			return redirect('wizard/onboarding');
		} else {
			return view('login');
		}
	}

	public function register () {
		if (Auth::user()) {
			return redirect('wizard/onboarding');
		} else {
			return view('registration');
		}
	}

	public function getUser($email)
	{
		return $this->userModel->getUser($email);
	}

	public function insertUser()
	{
		$data = Request::all();

		if (!$this->getUser($data['email'])) {
			$result = $this->userModel->insertUser((object)($data));
		} else {
			echo "User exist";
		}

	}
}
