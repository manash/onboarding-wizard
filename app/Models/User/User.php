<?php
namespace App\Models;
use DB;

class User
{
	public function getUser($email)
	{
		return DB::select('
			SELECT u.name, u.email, u.phone
			FROM users AS u
			WHERE u.email = :email', [':email' => $email]);
	}

	public function insertUser($user) {
		return DB::insert('
			INSERT INTO users (name, email, phone, password)
			VALUES (:uname, :email, :phone, :pwd)',
				[
					':uname' => $user->name,
					':email' => $user->email,
					':phone' => $user->phoneNumber,
					':pwd' => MD5($user->password)]);
	}
}