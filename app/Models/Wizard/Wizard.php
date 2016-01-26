<?php
namespace App\Models;
use DB;

class Wizard
{
	public function getAllStepsInvolved($wizardName)
	{
		return DB::select('
			SELECT ws.id, ws.name, ws.display_order, ws.skippable
			FROM wizard wz INNER JOIN wizard_steps ws ON wz.id = ws.fk_wizard_id
			WHERE wz.name = :wizardName AND wz.status = 1 AND ws.status = 1', [':wizardName' => $wizardName]);
	}
}