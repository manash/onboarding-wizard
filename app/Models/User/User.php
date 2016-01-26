<?php
namespace App\Models;
use DB;

class User
{
	public function getUser($email)
	{
		return DB::select('
			SELECT u.name, u.email, u.phone
			FROM user AS u
			WHERE u.email = :email AND u.status = :status', [':email' => $email, ':status' => 1]);
	}

	public function insertUser($user) {
		return DB::insert('
			INSERT INTO user (name, email, phone, password)
			VALUES (:uname, :email, :phone, :pwd)',
				[
					':uname' => $user->name,
					':email' => $user->email,
					':phone' => $user->phoneNumber,
					':pwd' => MD5($user->password)]);
	}
}