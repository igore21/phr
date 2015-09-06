<?php

define('DB_CONN_STRING', 'mysql:host=localhost;dbname=phr;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');


class DB {
	
	private static function getDB() {
		static $db = null;
		if($db == null) {
			$db = new PDO(DB_CONN_STRING, DB_USER, DB_PASS);
		}
		return $db;
	}
	
	//=============================
	// User
	//=============================
	
	public static function getUsers($search) {
		$result = array();
		$condition = '';
		$conds = array();
		
		if (!empty($search['user_id'])) {
			$conds [] = 'id =' . $search['user_id'];
		}
		if (!empty($search['email'])) {
			$conds [] = 'email =\'' . $search['email'] .'\'';
		}
		if (!empty($search['file_id'])) {
			$conds [] = 'file_id =' . $search['file_id'];
		}
		if (!empty($search['first_name'])) {
			$conds [] = 'first_name =\'' . $search['first_name'] . '\'';
		}
		if (!empty($search['last_name'])) {
			$conds [] = 'last_name =\'' . $search['last_name'] . '\'';
		}
		if (!empty($search['role'])) {
			$conds [] = 'role =' . $search['role'];
		}
		
		$condition = implode(' AND ', $conds);
		$db = self::getDB();
		$stm = $db->prepare('
			select * from user
			where ' . $condition
		);
		
		if ($stm->execute()) {
			$result = $stm->fetchAll();
		}
		
		return $result;
	}
	
	public static function getUser($search) {
		$users = DB::getUsers($search);
		if (!empty($users)) return $users[0];
		return null;
	}
	
	public static function editUser($user, $userId) {
		$db = self::getDB();
		$stm = $db->prepare('
			update user
			set	first_name = :first_name, last_name = :last_name, email = :email
			where id = :id
		');
		
		$stm->bindParam(':first_name', $user['first_name']);
		$stm->bindParam(':last_name', $user['last_name']);
		$stm->bindParam(':email', $user['email']);
		$stm->bindParam(':id', $userId);
		
		return $stm->execute();
	}
	
	public static function changePassword($password, $userId) {
		$db = self::getDB();
		$stm = $db->prepare('
			update user
			set password = :password
			where id = :id
		');
		
		$stm->bindParam(':password', $password);
		$stm->bindParam(':id', $userId);
		return $stm->execute();
	}
	
	public static function createUser($user) {
		$db = self::getDB();
		$stm = $db->prepare('
			insert into user (first_name, last_name, file_id, email, password, role)
			values (:first_name, :last_name, :file_id, :email, :password, :role)
		');
		
		$stm->bindParam(':first_name', $user['first_name']);
		$stm->bindParam(':last_name', $user['last_name']);
		$stm->bindParam(':file_id', $user['file_id']);
		$stm->bindParam(':email', $user['email']);
		$stm->bindParam(':password', $user['password']);
		$stm->bindParam(':role', $user['role']);
		
		return $stm->execute();
	}
	
	
	//=============================
	// Assignments
	//=============================
	
	public static function getParameters() {
		$result = array();
		$db = self::getDB();
		$stm = $db->prepare('select * from parameter');
		if ($stm->execute()) {
			$params = $stm->fetchAll();
			foreach ($params as $index => $param) {
				$result[$param['id']] = $param;
			}
		}
		return $result;
	}
	
	public static function getAssignments($userId) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			select assignment.*, user.first_name as doctor_first_name, user.last_name as doctor_last_name 
			from assignment
			inner join user on assignment.doctor_id = user.id 
			where patient_id = :patient_id
		');
		$stm->bindParam(':patient_id', $userId);
		if ($stm->execute()){
			$result = $stm->fetchAll();
		}
		return $result;
	}
	
	public static function getDoctorAssignmentsTable($userId, $active) {
		$result = array();
		$db = self::getDB();
		$currentTime = date('y-m-d h:i:s a', time());
		
		if ($active) {
			$stm = $db->prepare('
				select assignment.start_time, end_time, name, description, frequency, comment, user.first_name as doctor_first_name, user.last_name as doctor_last_name
				from assignment
				inner join user on assignment.doctor_id = user.id
				where start_time > :currentTime
			');
		}
		else {
			$stm = $db->prepare('
				select assignment.start_time, end_time, name, description, frequency, comment, user.first_name as doctor_first_name, user.last_name as doctor_last_name
				from assignment
				inner join user on assignment.doctor_id = user.id
				where start_time < :currentTime
			');
		}
		$stm->bindParam(':currentTime', $currentTime);
		if ($stm->execute()){
			$result = $stm->fetchAll();
		}
		return $result;
	}
	
	public static function getPatientAssignmentsTable($userId, $active) {
		$result = null;
		$db = self::getDB();
		$currentTime = date('y-m-d h:i:s a', time());
	
		if ($active) {
			$stm = $db->prepare('
				select assignment.*, user.first_name as doctor_first_name, user.last_name as doctor_last_name 
				from assignment
				inner join user on assignment.doctor_id = user.id 
				where start_time > :currentTime and patient_id = :userId
			');
		}
		else {
			$stm = $db->prepare('
				select assignment.*, user.first_name as doctor_first_name, user.last_name as doctor_last_name 
				from assignment
				inner join user on assignment.doctor_id = user.id 
				where start_time < :currentTime and patient_id = :userId
			');
		}
		$stm->bindParam(':currentTime', $currentTime);
		$stm->bindParam(':userId', $userId);
		
		if ($stm->execute()){
			$result = $stm->fetchAll();
		}
		return $result;
	}
	
	public static function createAssignment($assignment) {
		$db = self::getDB();
		$stm = $db->prepare('
			insert into assignment (patient_id, doctor_id, name, description,  start_time, end_time, frequency, comment)
			values (:patient_id, :doctor_id, :name, :description, :start_time, :end_time, :frequency, :comment)
		');
		$stm->bindParam(':patient_id', $assignment['patient_id']);
		$stm->bindParam(':doctor_id', $assignment['doctor_id']);
		$stm->bindParam(':name', $assignment['name']);
		$stm->bindParam(':description', $assignment['description']);
		$stm->bindValue(':start_time', date('Y-m-d H:i:s', strtotime($assignment['start_time'])));
 		$stm->bindValue(':end_time', date('Y-m-d H:i:s', strtotime($assignment['end_time'])));
		$stm->bindParam(':frequency', $assignment['frequency']);
		$stm->bindParam(':comment', $assignment['comment']);
		
		if (!$stm->execute()) { throw new Exception($stm->errorInfo()); }
		$assignmentId = $db->lastInsertId();
		
		return DB::attachParametersToAssignment($assignment['paramIds'], $assignmentId);
	}
	
	public static function attachParametersToAssignment($parameters, $assignmentId) {
		$db = self::getDB();
		
		$paramPlaceholders = implode(', ', array_fill(0, count($parameters), '(?, ?)'));
		$stm = $db->prepare('INSERT INTO assignment_parameter (assignment_id, parameter_id) VALUES ' . $paramPlaceholders);
		
		foreach ($parameters as $pak => $pav) {
			$stm->bindValue(2 * ($pak-1) + 1, $assignmentId);
			$stm->bindValue(2 * ($pak-1) + 2, $pav);
		}
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		
		return true;
	}
	
}