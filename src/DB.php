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
	
	public static function getAllParameters() {
		$db = self::getDB();
		$stm = $db->prepare('select * from parameter');
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		
		$result = array();
		$params = $stm->fetchAll();
		foreach ($params as $index => $param) {
			$result[$param['id']] = $param;
		}
		return $result;
	}
	
	public static function getAssignment($assignmentId) {
		$db = self::getDB();
		$stm = $db->prepare('select * from assignment where id = :assignment_id');
		$stm->bindParam(':assignment_id', $assignmentId);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		
		$result = $stm->fetch();
		if (empty($result)) return $result;
		$result['params'] = DB::getAssignmentParameters($assignmentId);
		return $result;
	}
	
	public static function getAssignments($userId, $isDoctor, $active) {
		$db = self::getDB();
		$currentTime = date('y-m-d h:i:s a', time());
		
		if ($isDoctor) $condition = 'ass.doctor_id = :user_id';
		else $condition = 'ass.patient_id = :user_id';
		
		$condition .= ' and ';
		if ($active) $condition .= 'end_time > :current_time';
		else $condition .= 'end_time < :current_time';
		
		$query = '
			select
				ass.id,
				ass.name,
				ass.description,
				ass.start_time,
				ass.end_time,
				doctor.first_name as doctor_first_name,
				doctor.last_name as doctor_last_name,
				patient.first_name as patient_first_name,
				patient.last_name as patient_last_name,
				patient.id as patient_id
			from assignment as ass
				inner join user as doctor on ass.doctor_id = doctor.id
				inner join user as patient on ass.patient_id = patient.id
			where :condition
		';
		$query = str_replace(':condition', $condition, $query);
		
		$stm = $db->prepare($query);
		$stm->bindParam(':user_id', $userId);
		$stm->bindParam(':current_time', $currentTime);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		$assignments = $stm->fetchAll();
		
		foreach ($assignments as &$ass) {
			$ass['params'] = DB::getAssignmentParameters($ass['id']);
		}
		
		return $assignments;
	}
	
	public static function getAssignmentParameters($assignmentId) {
		$db = self::getDB();
		$stm = $db->prepare('
			select *
			from assignment_parameter
			where assignment_id = :assignment_id
		');
		$stm->bindParam(':assignment_id', $assignmentId);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		return $stm->fetchAll();
	}
	
	public static function createAssignment($assignment) {
		$db = self::getDB();
		$stm = $db->prepare('
			insert into assignment (patient_id, doctor_id, name, description,  start_time, end_time)
			values (:patient_id, :doctor_id, :name, :description, :start_time, :end_time)
		');
		$stm->bindParam(':patient_id', $assignment['patient_id']);
		$stm->bindParam(':doctor_id', $assignment['doctor_id']);
		$stm->bindParam(':name', $assignment['name']);
		$stm->bindParam(':description', $assignment['description']);
		$stm->bindValue(':start_time', date('Y-m-d H:i:s', strtotime($assignment['start_time'])));
		$stm->bindValue(':end_time', date('Y-m-d H:i:s', strtotime($assignment['end_time'])));
		
		if (!$stm->execute()) { throw new Exception($stm->errorInfo()); }
		$assignmentId = $db->lastInsertId();
		
		DB::attachParametersToAssignment($assignment['params'], $assignmentId);
		
		return $assignmentId;
	}
	
	public static function attachParametersToAssignment($parameters, $assignmentId) {
		$db = self::getDB();
	
		$paramPlaceholders = implode(', ', array_fill(0, count($parameters), '(?, ?, ?, ?, ?)'));
		$stm = $db->prepare('
			INSERT INTO assignment_parameter (assignment_id, parameter_id, execute_after, time_unit, comment)
			VALUES ' . $paramPlaceholders
		);
	
		$index = 0;
		foreach ($parameters as $id => $param) {
			$stm->bindValue(5 * $index + 1, $assignmentId);
			$stm->bindValue(5 * $index + 2, $param['parameter_id']);
			$stm->bindValue(5 * $index + 3, $param['execute_after']);
			$stm->bindValue(5 * $index + 4, $param['time_unit']);
			$stm->bindValue(5 * $index + 5, $param['comment']);
			$index++;
		}
	
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
	
		return true;
	}
	
	public static function updateAssignment($assignment) {
		$db = self::getDB();
		$stm = $db->prepare('
			update assignment set
				doctor_id = :doctor_id,
				name = :name,
				description = :description,
				start_time = :start_time,
				end_time = :end_time
			where id = :assignment_id
		');
		$stm->bindParam(':doctor_id', $assignment['doctor_id']);
		$stm->bindParam(':name', $assignment['name']);
		$stm->bindParam(':description', $assignment['description']);
		$stm->bindValue(':start_time', date('Y-m-d H:i:s', strtotime($assignment['start_time'])));
		$stm->bindValue(':end_time', date('Y-m-d H:i:s', strtotime($assignment['end_time'])));
		$stm->bindParam(':assignment_id', $assignment['assignment_id']);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		DB::deleteAssignmentParameters($assignment['assignment_id']);
		return DB::attachParametersToAssignment($assignment['params'], $assignment['assignment_id']);
	}
	
	public static function deleteAssignmentParameters($assignmentId) {
		$db = self::getDB();
		$stm = $db->prepare('delete from assignment_parameter where assignment_id = :assignment_id');
		$stm->bindParam(':assignment_id', $assignmentId);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		return true;
	}
	
	
	//=============================
	// Data
	//=============================
	
	public static function insertAssignmentData($data) {
		$db = self::getDB();
		
		if (empty($data)) return true;
		
		$paramPlaceholders = implode(', ', array_fill(0, count($data), '(?, ?, ?, ?, ?)'));
		$stm = $db->prepare('
			INSERT INTO data (
				patient_id,
				assignment_id,
				parameter_id,
				scheduled_time,
				data_type
			)
			VALUES ' . $paramPlaceholders
		);
		
		foreach ($data as $index => $dataRow) {
			$stm->bindValue(5 * $index + 1, $dataRow['patient_id']);
			$stm->bindValue(5 * $index + 2, $dataRow['assignment_id']);
			$stm->bindValue(5 * $index + 3, $dataRow['parameter_id']);
			$stm->bindValue(5 * $index + 4, $dataRow['scheduled_time']);
			$stm->bindValue(5 * $index + 5, $dataRow['data_type']);
		}
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		return true;
	}
	
	public static function deleteData($assignmentId) {
		$db = self::getDB();
		$currentTime = date('y-m-d h:i:s a', time());
		$stm = $db->prepare('
			DELETE FROM data
			WHERE assignment_id = :assignment_id AND scheduled_time > :current_time
		');
		$stm->bindParam(':assignment_id', $assignmentId);
		$stm->bindParam(':current_time', $currentTime);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		return true;
	}
	
	public static function getData($search) {
		$db = self::getDB();
		
		$conds = array();
		if (!empty($search['patient_id'])) {
			$conds [] = 'ass.patient_id = ' . $search['patient_id'];
		}
		if (!empty($search['doctor_id'])) {
			$conds [] = 'ass.doctor_id = ' . $search['doctor_id'];
		}
		if (!empty($search['assignment_id'])) {
			$conds [] = 'ass.id = ' . $search['assignment_id'];
		}
		if (!empty($search['from'])) {
			$conds [] = 'data.scheduled_time > \'' . $search['from'] . '\'';
		}
		if (!empty($search['to'])) {
			$conds [] = 'data.scheduled_time < \'' . $search['to'] . '\'';
		}
		if (!empty($search['completed'])) {
			$conds [] = 'data.completed = ' . $search['completed'];
		}
		
		$condition = implode(' AND ', $conds);
// 		echo $condition . '<br>';
		
		$query = '
			SELECT
				ass.name,
				data.*,
				ap.comment
			FROM assignment as ass
				INNER JOIN data ON data.assignment_id = ass.id
				INNER JOIN assignment_parameter as ap ON data.parameter_id = ap.parameter_id
		';
		
		if (!empty($condition)) $query .= ' WHERE ' . $condition;
		$query .= ' ORDER BY data.scheduled_time';
		if (!empty($search['limit'])) $query .= ' LIMIT ' . $search['limit'];
// 		echo $query . '<br>';
		
		$stm = $db->prepare($query);
		
		if (!$stm->execute()) throw new Exception($stm->errorInfo());
		return $stm->fetchAll();
	}
}
