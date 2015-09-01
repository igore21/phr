<?php
define('DB_CONN_STRING', 'mysql:host=localhost;dbname=phr;charset=utf8');
define('DB_USER',        'root');
define('DB_PASS',        '');


class DB {
	
	private static function getDB() {
		static $db = null;
		if($db == null) {
			$db = new PDO(DB_CONN_STRING, DB_USER, DB_PASS);
		}
		return $db;
	}
	
	public static function bla() {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('select * from user');
		$stm->execute();
		return $stm->fetchAll();
	}
	
	public static function getUserByMail($mail) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			select * from user 
			where email = :mail
		');
		$stm->bindParam(':mail', $mail);
		
		if ($stm->execute()) {
			$result = $stm->fetch();
			if ($result == false) return null;
		}
		return $result;
	}
	
	public static function createUser($first_name, $last_name, $email, $password, $role) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			insert into user (first_name, last_name, email, password, role)
			values (:first_name, :last_name, :email, :password, :role)
		');
		$stm->bindParam(':first_name', $first_name);
		$stm->bindParam(':last_name', $last_name);
		$stm->bindParam(':email', $email);
		$stm->bindParam(':password', $password);
		$stm->bindParam(':role', $role);
	
		try {
			echo '123';
			$res = $stm->execute();
			echo '46';
			return $res;
		} catch(PDOException $Exception ) {
			echo 'sldkjf';
		} catch (Exception $e) {
			echo 'pukla baza';
			//TODO uradi...
		}
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
		//select assignment.*, user.first_name, user.last_name from assignment inner join user on assignment.doctor_id = user.id;
	}
	
	public static function getDoctorAssignmentsTable($userId, $active) {
		$result = array();
		$db = self::getDB();
		$currentTime = date('y-m-d h:i:s a', time());
		
		if ($active) {
			$stm = $db->prepare('
					 select assignment.start_time, end_time, name, description, frequency, max_delay, comment, user.first_name as doctor_first_name, user.last_name as doctor_last_name
					 from assignment
					 inner join user on assignment.doctor_id = user.id
					 where start_time > :currentTime
			');
		}
		else {
			$stm = $db->prepare('
					 select assignment.start_time, end_time, name, description, frequency, max_delay, comment, user.first_name as doctor_first_name, user.last_name as doctor_last_name
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
	
	public static function getAssignmentId($assignment) {
		$result = null;
		$db = self::getDB();
	
		$stm = $db->prepare('
				 select id
				 from assignment
		');
		
		if ($stm->execute()){
			$result = $stm->fetchAll();
		}
		return $result;
	}
	
	
// 	insert into assignment (patient_id, doctor_id, name, description, actions, start_time, end_time, frequency, max_delay, comment)
// 	values (3, 2, 'bi', 'jb k', 'jhb', '2015-7-16', '2015-7-26', 8, 1, 'bjhbj');
	
	//$stm->bindValue(':valid_from', date('Y-m-d H:i:s', strtotime($campaign['valid_from'])));
	
	
	public static function createAssignment($assignment) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			insert into assignment (patient_id, doctor_id, name, description,  start_time, end_time, frequency, max_delay, comment)
			values (:patient_id, :doctor_id, :name, :description, :start_time, :end_time, :frequency, :max_delay, :comment)
		');
		$stm->bindParam(':patient_id', $assignment['patient_id']);
		$stm->bindParam(':doctor_id', $assignment['doctor_id']);
		$stm->bindParam(':name', $assignment['name']);
		$stm->bindParam(':description', $assignment['description']);
		$stm->bindValue(':start_time', date('Y-m-d H:i:s', strtotime($assignment['start_time'])));
 		$stm->bindValue(':end_time', date('Y-m-d H:i:s', strtotime($assignment['end_time'])));
		$stm->bindParam(':frequency', $assignment['frequency']);
		$stm->bindParam(':max_delay', $assignment['max_delay']);
		$stm->bindParam(':comment', $assignment['comment']);
	
		try {
			echo '123';
			//$res = $stm->execute();
			if (!$stm->execute()) {
				print_r($stm->errorInfo());
			}
			echo '46';
			return $stm->errorInfo();
			//return $res;
		} catch(PDOException $Exception ) {
			echo 'sldkjf';
		} catch (Exception $e) {
			echo 'pukla baza';
			//TODO uradi...
		}
	}
	
	public static function getParameters() {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('select * from parameter');
		$stm->execute();
		return $stm->fetchAll();
	}
	
	public static function addParameter($parameters, $assignmentId) {
		$result = null;
		$db = self::getDB();
		$paramPlaceholders = implode(', ', array_fill(0, count($parameters), '(?, ?)'));
		var_dump($paramPlaceholders);
		$stm = $db->prepare('INSERT INTO assignment_parameter (assignment_id, parameter_id) VALUES ' . $paramPlaceholders);
		foreach ($parameters as $pak => $pav) {
			$stm->bindValue(2 * ($pak-1) + 1, $assignmentId);
			$stm->bindValue(2 * ($pak-1) + 2, $pav);
		}
		
	try {
			echo '123';
			if (!$stm->execute()) {
				print_r($stm->errorInfo());
				echo 'majmun';
			}
			echo '46';
			return $stm->errorInfo();
		} catch(PDOException $Exception ) {
			echo 'sldkjf';
		} catch (Exception $e) {
			echo 'pukla baza';
			//TODO uradi...
		}
	}
	
	//insert into assignment_parameter (assignment_id, parameter_id) values (1, 1),
	//(1, 3), (3, 2), (3, 4);
	
	public static function getUser($search) {
		$result = array();
		$condition = '';
		$conds = array();
		
		if (!empty($search['id'])) {
			$conds [] = 'file_id =' .$search['id'];
		}
		if (!empty($search['email'])) {
			$conds [] = 'email =' . '\''.$search['email'].'\'';
		}
		if (!empty($search['first_name'])) {
			$conds [] = 'first_name =' .'\''.$search['first_name'].'\'';
		}
		if (!empty($search['last_name'])) {
			$conds [] = 'last_name =' .'\''.$search['last_name'].'\'';
		}
		if (!empty($search['role'])) {
			$conds [] = 'role =' . $search['role'];
		}
		
		$condition = implode(' AND ', $conds);
		$db = self::getDB();
		$stm = $db->prepare('
			select * from user
			where ' .$condition
		);
		if ($stm->execute()) {
			$result = $stm->fetchAll();
		}
		
		return $result;
	}
	
	public static function getUserById($ID) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			select * from user
			where id = :id
		');
		$stm->bindParam(':id', $ID);
	
		if ($stm->execute()) {
			$result = $stm->fetch();
			if ($result == false) return null;
		}
		return $result;
	}
	
	public static function editUser($user, $userID) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			update user 
			set	first_name = :first_name, last_name = :last_name, email = :email
			where id = :id
		');
		
		$stm->bindParam(':first_name', $user['first_name']);
		$stm->bindParam(':last_name', $user['last_name']);
		$stm->bindParam(':email', $user['email']);
		$stm->bindParam(':id', $userID);
		
	
	try {
			echo '123';
			$res = $stm->execute();
			echo '46';
			return $res;
		} catch(PDOException $Exception ) {
			echo 'sldkjf';
		} catch (Exception $e) {
			echo 'pukla baza';
			//TODO uradi...
		}
	}
	
	public static function changePassword($password, $userID) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			update user
			set	password = :password
			where id = :id
		');
	
		$stm->bindParam(':password', $password);
		$stm->bindParam(':id', $userID);
	
	
		try {
			echo '123';
			$res = $stm->execute();
			echo '46';
			return $res;
		} catch(PDOException $Exception ) {
			echo 'sldkjf';
		} catch (Exception $e) {
			echo 'pukla baza';
			//TODO uradi...
		}
	}
	
}