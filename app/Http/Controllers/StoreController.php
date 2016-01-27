<?php namespace App\Http\Controllers;
use App\Models\Store;
use App\Models\Wizard;
use Request, Auth;

class StoreController extends Controller {

	private $wizardName, $loginUserId, $storeModel, $wizardModel, $storeSetupOrder;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->storeModel = new Store();
		$this->wizardModel = new Wizard();

		$this->wizardName = 'Restaurant Onboarding';
		$this->loginUserId = auth::user() ? auth::user()->id : 0;

		$this->storeSetupOrder = array(
			'Restaurant Outlet Detail',
			'Restaurant Menu Details'
		);
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function startOnboarding()
	{
		$data = array(
			'wizardStep' => 1,
			'storeSetupOrder' => $this->storeSetupOrder
		);
		$wizardStepsInvolved = $this->wizardModel->getAllStepsInvolved($this->wizardName);

		if (!empty($wizardStepsInvolved) && is_array($wizardStepsInvolved)) {
			foreach ($wizardStepsInvolved as $value) {
				$data['wizardStepDetail'][$value->name] = $value;
			}

			$incompleteSetup = $this->storeModel->checkIncompleteStoreSetup($this->loginUserId);

			if ($incompleteSetup && is_array($incompleteSetup) && array_key_exists(0, $incompleteSetup) &&
				$incompleteSetup[0]->step < COUNT($data['wizardStepDetail'])) {
				$data['storeId'] = $incompleteSetup[0]->fk_store_id;
				$data['storeName'] = $incompleteSetup[0]->store_name;
				$data['wizardStep'] = $incompleteSetup[0]->step + 1;

				$data['detail'] = array(
					'name' => $incompleteSetup[0]->store_name,
					'address' => $incompleteSetup[0]->address,
					'city' => $incompleteSetup[0]->city,
					'pin' => $incompleteSetup[0]->pincode,
					'phone' => $incompleteSetup[0]->phone

				);
			}

			return view('storeOnboarding', ['data' => $data]);
		} else {
			return redirect('wizard/dashboard');
		}
	}

	public function dashboard() {
		return view('dashboard');
	}

	public function addStore()
	{
		$data = Request::all();
		$result = array(
			'fieldName' => array()
		);

		$data['detail']['userId'] = $this->loginUserId;

		if ($data &&
			array_key_exists('setupDetail', $data) && array_key_exists('storeId', $data['setupDetail']) && $data['setupDetail']['storeId']) {
			$result['response'] = true;
			$result['storeId'] = $data['setupDetail']['storeId'];
			$result['msg'] = 'Store already exists';
		} else if ($data && array_key_exists('detail', $data) &&
				array_key_exists('name', $data['detail']) && $data['detail']['name'] &&
				array_key_exists('address', $data['detail']) && $data['detail']['address'] &&
				array_key_exists('city', $data['detail']) && $data['detail']['city'] &&
				array_key_exists('phone', $data['detail']) && $data['detail']['phone'] &&
				array_key_exists('pin', $data['detail']) && $data['detail']['pin']) {
			$storeAlreadyPresent = $this->checkIfStorePresent($data['detail']['name']);

			if (!empty($storeAlreadyPresent)) {
				$storeId = $this->storeModel->insertStoreDetails((object)($data['detail']));

				if ($storeId) {
					$this->userStoreSetupCounter($storeId);
				}

				$result['response'] = true;
				$result['storeId'] = $storeId;
				$result['msg'] = 'Store detail saved';
			} else {
				$result['response'] = false;
				$result['fieldName'] = array('name');
				$result['msg'] = 'Store already exist';
			}
		} else {
			$result['response'] = false;
			$result['msg'] = 'Invalid Request.';
			$field = array();

			if (!array_key_exists('name', $data['detail'])) {
				array_push($field, 'name');
 			}
			if (!array_key_exists('address', $data['detail'])) {
				array_push($field, 'address');
			}
			if (!array_key_exists('city', $data['detail'])) {
				array_push($field, 'city');
			}
			if (!array_key_exists('phone', $data['detail'])) {
				array_push($field, 'phone');
			}
			if (!array_key_exists('pin', $data['detail'])) {
				array_push($field, 'pin');
			}

			if ($field) {
				$result['fieldName'] = $field;
				$result['msg'] .= ' Please select ' . implode(", ", $field);
			}
		}

		return json_encode($result);
	}

	public function addStoreItem()
	{
		$data = Request::all();
		$result = array(
			'fieldName' => array()
		);

		if ($data && array_key_exists('newitem', $data) &&
			array_key_exists('name', $data['newitem']) && $data['newitem']['name'] &&
			array_key_exists('price', $data['newitem']) && $data['newitem']['price'] &&
			array_key_exists('setupDetail', $data) && array_key_exists('storeId', $data['setupDetail']) && $data['setupDetail']['storeId']) {

			$detail = array (
				'storeId' => $data['setupDetail']['storeId'],
				'itemName' => $data['newitem']['name'],
				'price' => $data['newitem']['price']
			);

			if (!$this->storeModel->getStoreProduct((object) $detail)) {
				$response = $this->storeModel->insertStoreProduct((object)$detail);

				if ($response) {
					$this->userStoreSetupCounter($data['setupDetail']['storeId']);
				}

				$result['response'] = true;
				$result['msg'] = 'Item detail saved';
			} else {
				$result['response'] = false;
				$result['msg'] = 'Item already exist for the store';
			}
		} else {
			$field = array();
			$result['response'] = false;
			$result['msg'] = 'Invalid Request';

			if (!array_key_exists('newitem', $data)) {
				array_push($field, 'name', 'price');
			} else if (array_key_exists('newitem', $data) && !array_key_exists('name', $data['newitem'])){
				array_push($field, 'name');
			} else if (array_key_exists('newitem', $data) && !array_key_exists('price', $data['newitem'])){
				array_push($field, 'price');
			}

			if ($field) {
				$result['fieldName'] = $field;
				$result['msg'] .= ' Please select ' . implode(", ", $field);
			}
		}

		return json_encode($result);
	}

	public function userStoreSetupCounter($storeId) {
		$setupDetail = array(
			'userId' => $this->loginUserId,
			'storeId' => $storeId
		);

		return $this->storeModel->updateUserStoreSetupStep((object) $setupDetail);
	}

	public function checkIfStorePresent ($storeName) {
		$result = array();
		$response = $this->storeModel->getStoreDetails($this->loginUserId, $storeName);

		if ($response && count($response)) {
			$result['response'] = false;
			$result['fieldName'] = 'name';
			$result['msg'] = 'Store already exist';
		}

		return json_encode($result);
	}

	public function getAllStoreDetails () {
		return json_encode($this->storeModel->getAllStore($this->loginUserId));
	}

	public function getStoreMenuItems($storeId) {
		$data = array(
			'storeId' => $storeId
		);

		return json_encode($this->storeModel->getAllStoreProduct((object) $data));
	}

	public function skipStep() {
		$data = Request::all();
		$result = array();

		if ($data && is_array($data) && array_key_exists('step', $data) && $data['step'] &&
			array_key_exists('storeId', $data) && $data['storeId']) {
			$setupDetail = array(
				'userId' => $this->loginUserId,
				'storeId' => $data['storeId'],
				'step' =>  $data['step']
			);
			$queryResponse = $this->storeModel->updateUserStoreSetupStep((object) $setupDetail);

			if ($queryResponse) {
				$result['response'] = true;
				$result['msg'] = 'Step marked skip';
			}
		} else {
			$result['response'] = false;
			$result['msg'] = 'Invalid Request';
		}

		return json_encode($result);
	}
}