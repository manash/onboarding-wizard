<?php namespace App\Http\Controllers;
use App\Models\Store;
use App\Models\Wizard;
use Request, Auth;

class ApiController extends Controller {

	private $wizardName, $storeModel, $wizardModel, $storeSetupOrder;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
		$this->storeModel = new Store();
		$this->wizardModel = new Wizard();

		$this->wizardName = 'Restaurant Onboarding';
		$this->storeSetupOrder = array(
			'Restaurant Outlet Detail',
			'Restaurant Menu Details'
		);
	}

	public function checkIfStorePresent ($id, $storeName) {
		$result = array();
		$response = $this->storeModel->getStoreDetails($id, urldecode($storeName));

		if ($response && count($response)) {
			$result['response'] = false;
			$result['msg'] = 'Store already exist';
		} else {
			$result['response'] = true;
			$result['msg'] = 'Store not available against the user';
		}

		return json_encode($result);
	}

	public function insertNewStore() {
		$data = Request::all();

		if (!empty($data) && is_array($data) &&
			array_key_exists('userId', $data) && $data['userId'] &&
			array_key_exists('name', $data) && $data['name'] &&
			array_key_exists('address', $data) && $data['address'] &&
			array_key_exists('city', $data) && $data['city'] &&
			array_key_exists('phone', $data) && $data['phone'] &&
			array_key_exists('pin', $data) && $data['pin'] ) {

			$storePresent = $this->checkIfStorePresent($data['userId'], $data['name']);

			if ($storePresent && !json_decode($storePresent, TRUE)['response']) {
				return $storePresent;
			}
			$storeId = $this->storeModel->insertStoreDetails((object)($data));

			if ($storeId) {
				$this->userStoreSetupCounter($data['userId'], $storeId);
			}

			$result['response'] = true;
			$result['msg'] = 'Store detail saved';
		} else {
			$result['response'] = false;
			$result['msg'] = 'Invalid Request.';
		}

		return json_encode($result);
	}

	public function userStoreSetupCounter($userId, $storeId) {
		$setupDetail = array(
			'userId' => $userId,
			'storeId' => $storeId
		);

		return $this->storeModel->updateUserStoreSetupStep((object) $setupDetail);
	}

	public function checkIfStoreItemPresent ($storeId, $menuName) {
		$result = array();

		$detail = array (
			'storeId' => $storeId,
			'itemName' => urldecode($menuName),
		);
		$response = $this->storeModel->getStoreProduct((object) $detail);

		if ($response && count($response)) {
			$result['response'] = false;
			$result['msg'] = 'Item already exist';
		} else {
			$result['response'] = true;
			$result['msg'] = 'Item not available against the store';
		}

		return json_encode($result);
	}

	public function getStoreMenuItems($storeId) {
		$data = array(
			'storeId' => $storeId
		);

		$response = $this->storeModel->getAllStoreProduct((object) $data);

		if ($response && count($response)) {
			$result['response'] = true;
			$result['data'] = $response;
		} else {
			$result['response'] = false;
			$result['msg'] = 'No items available in the store';
		}

		return json_encode($result);
	}
}