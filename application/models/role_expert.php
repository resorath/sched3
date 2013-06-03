<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function set_role($userId, $roleId)
	{
		$sql = "INSERT INTO `userRole` (`id`, `userId`, `roleId`) VALUES (NULL, ?, ?)";
		$this->db->query($sql, array($userId, $roleId));
	}

	function remove_role($userId, $roleId)
	{
		$sql = "DELETE FROM `userRole` WHERE `userId` = ? AND `roleId` = ?";
		$this->db->query($sql, array($userId, $roleId));
	}

	function add_role($roleName, $roleDescription)
	{
		$sql = "INSERT INTO `role` (`id`, `roleName`, `roleDescription`) VALUES (NULL, ?, ?)";
		$this->db->query($sql, array($roleName, $roleDescription));
	}

	function add_controller_role($roleId, $controllerName)
	{
		$sql = "INSERT INTO `controllerRole` (`id`, `roleId`, `controllerName`) VALUES (NULL, ?, ?)";
		$this->db->query($sql, array($roleId, $controllerName));
	}

	function getRoles($userId)
	{
		$sql = "SELECT `role`.`roleName` FROM `role` JOIN `userRole` ON `role`.`id` = `userRole`.`roleId` WHERE `userId` = ?";

		$result = $this->db->query($sql, array($userId));

		$returnVal = array();

		if($result->num_rows() > 0)
		{
			foreach($result->result_array() as $rolename)
			{
				$returnVal[] = $rolename;
			}
		}

		return $returnVal;

	}

	function add_hour($sessionId, $userId, $time, $date, $day)
	{
		$sql = "INSERT INTO `hour` (`id`, `userId`, `sessionId`, `time`, `date`, `day`) VALUES (NULL, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($sessionId, $userId, $time, $date, $day));
	}

	function truncate_roles()
	{
		$sql = "truncate `role`";
		$this->db->query($sql);

		$sql = "truncate `userRole`";
		$this->db->query($sql);

		$sql = "truncate `controllerRole`";
		$this->db->query($sql);
	}

	function getControllerRoles($controllerName)
	{
		$sql = "SELECT `role`.`roleName` FROM `role` JOIN `controllerRole` ON `role`.`id` = `controllerRole`.`roleId` WHERE `controllerName` = ?";

		$result = $this->db->query($sql, array($controllerName));

		$returnVal = array();

		if($result->num_rows() > 0)
		{
			foreach($result->result_array() as $rolename)
			{
				$returnVal[] = $rolename;
			}
		}

		return $returnVal;
	}

}

?>