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
				 where pacient_id = :pacient_id
		');
		$stm->bindParam(':pacient_id', $userId);
		if ($stm->execute()){
			$result = $stm->fetchAll();
		}
		return $result;
		//select assignment.*, user.first_name, user.last_name from assignment inner join user on assignment.doctor_id = user.id;
	}
	
	public static function getAssignmentsTable($userId, $active) {
		$result = null;
		$db = self::getDB();
		$currentTime = date('y-m-d h:i:s a', time());
		
		if ($active) {
			$stm = $db->prepare('
					 select assignment.start_time, end_time, name, description, actions, frequency, max_delay, comment, user.first_name as doctor_first_name, user.last_name as doctor_last_name
					 from assignment
					 inner join user on assignment.doctor_id = user.id
					 where start_time > :currentTime
			');
		}
		else {
			$stm = $db->prepare('
					 select assignment.start_time, end_time, name, description, actions, frequency, max_delay, comment, user.first_name as doctor_first_name, user.last_name as doctor_last_name
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
	
// 	insert into assignment (pacient_id, doctor_id, name, description, actions, start_time, end_time, frequency, max_delay, comment)
// 	values (3, 2, 'bi', 'jb k', 'jhb', '2015-7-16', '2015-7-26', 8, 1, 'bjhbj');
	
	//$stm->bindValue(':valid_from', date('Y-m-d H:i:s', strtotime($campaign['valid_from'])));
	
	
	public static function createAssignment($assignment) {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('
			insert into assignment (pacient_id, doctor_id, name, description, actions, start_time, end_time, frequency, max_delay, comment)
			values (:pacient_id, :doctor_id, :name, :description, :actions, :start_time, :end_time, :frequency, :max_delay, :comment)
		');
		$stm->bindParam(':pacient_id', $assignment['pacient_id']);
		$stm->bindParam(':doctor_id', $assignment['doctor_id']);
		$stm->bindParam(':name', $assignment['name']);
		$stm->bindParam(':description', $assignment['description']);
		$stm->bindParam(':actions', $assignment['actions']);
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
	
	public static function par() {
		$result = null;
		$db = self::getDB();
		$stm = $db->prepare('select * from parameter');
		$stm->execute();
		return $stm->fetchAll();
	}
}