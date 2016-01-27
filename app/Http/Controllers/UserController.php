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
		$getUser = $this->userModel->getUser($email);

		if ($getUser && is_array($getUser)) {
			$result['response'] = true;
			$result['data'] = $getUser[0];
		} else {
			$result['response'] = false;
			$result['data'] = array();
		}

		return json_encode($result);
	}

	public function insertUser()
	{
		$data = Request::all();
		$result = array();

		if (!$this->getUser($data['email'])) {
			$insertResponse = $this->userModel->insertUser((object)($data));

			if ($insertResponse) {
				$result['response'] = true;
				$result['msg'] = 'User created successfully';
			}
		} else {
			$result['response'] = false;
			$result['msg'] = 'User exist';
		}

		return json_encode($result);
	}
}
