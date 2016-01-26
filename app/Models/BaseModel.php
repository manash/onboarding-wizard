<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class BaseModel extends Model
{
	/* make a curl call to APIs for post requests
	 *
	 * @param endpoint string : API's url.
	 * @param type string : post/get
	 * @param input json
	 * @param encryptionMethod string
	 * @return array
	 *  0 => status int : http response code
	 *  1 => response json
	 */
	public function curlApiCall($apiEndPoint, $type, $input = '')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiEndPoint);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($type));

		if ("POST" == strtoupper($type)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $input);

			$headerPost = array(
				'Accept: application/json',
				'Content-Type: application/json',
				'Content-Length: ' . strlen($input)
			);

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headerPost);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		return array(
			"status" => $status,
			"response" => $response
		);
	}
}
