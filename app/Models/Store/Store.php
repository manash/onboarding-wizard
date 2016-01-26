<?php
namespace App\Models;
use DB;

class Store
{

	public function getAllStore($userId)
	{
		return DB::select('
			SELECT s.id, s.name, s.address, s.city, s.pincode, s.status
			FROM store_details AS s
			where s.fk_user_id = :userId', [':userId' => $userId]);
	}

	public function getStoreDetails($userId, $storeName)
	{
		return DB::select('
			SELECT s.id, s.address, s.city, s.pincode, s.status
			FROM store_details AS s
			where s.fk_user_id = :userId AND s.name = :storeName', [':userId' => $userId, ':storeName' => $storeName]);
	}

	public function insertStoreDetails($store) {
		DB::insert('
			INSERT INTO store_details (fk_user_id, name, address, city, phone, pincode)
				VALUES (:uId, :sname, :address, :city, :phone, :pincode)',
				[
					':uId' => $store->userId,
					':sname' => $store->name,
					':address' => $store->address,
					':city' => $store->city,
					':phone' => $store->phone,
					':pincode' => $store->pin
				]
		);

		return DB::getPdo()->lastInsertId();
	}

	public function getAllStoreProduct($details)
	{
		return DB::select('
			SELECT id, name, price
			FROM store_products
			WHERE fk_store_id = :storeId AND status = :status',
				[':storeId' => $details->storeId, ':status' => 1]);
	}

	public function getStoreProduct($details)
	{
		return DB::select('
			SELECT id
			FROM store_products
			WHERE fk_store_id = :storeId AND name = :itemName AND status = :status',
			[':storeId' => $details->storeId, ':itemName' => $details->itemName, ':status' => 1]);
	}

	public function insertStoreProduct($item) {
		DB::insert('
			INSERT INTO store_products (fk_store_id, name, price)
				VALUES (:storeId, :name, :price)',
				[
					':storeId' => $item->storeId,
					':name' => $item->itemName,
					':price' => $item->price
				]
		);

		return DB::getPdo()->lastInsertId();
	}

	public function checkIncompleteStoreSetup($userId)
	{
		return DB::select('
			SELECT uss.fk_store_id, uss.step, sd.name as store_name, sd.address, sd.city, sd.phone, sd.pincode
			FROM user_store_setup uss INNER JOIN store_details sd ON uss.fk_store_id = sd.id
			WHERE uss.fk_user_id = :userId
			ORDER BY uss.id DESC LIMIT 0, 1', [':userId' => $userId]);
	}

	public function updateUserStoreSetupStep($details) {
		if (property_exists($details, 'step') && isset($details->step)) {
			return DB::insert('
			INSERT INTO user_store_setup (fk_user_id, fk_store_id)
				VALUES (:userId, :storeId)
				ON DUPLICATE KEY UPDATE step = :step',
					[
						':userId' => $details->userId,
						':storeId' => $details->storeId,
						':step' => $details->step
					]
			);
		} else {
			return DB::insert('
				INSERT INTO user_store_setup (fk_user_id, fk_store_id)
					VALUES (:userId, :storeId)
					ON DUPLICATE KEY UPDATE step = step + 1',
					[
						':userId' => $details->userId,
						':storeId' => $details->storeId
					]
			);
		}
	}
}