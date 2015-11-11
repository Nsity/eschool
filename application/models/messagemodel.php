<?php

	class Messagemodel extends CI_Model {

		function getFolderMessages($limit = null, $offset = null, $id, $type, $search, $from, $to) {
			$query = $this->db->query("SELECT ".$from."S_MESSAGE_ID AS USER_MESSAGE_ID, pm.MESSAGE_ID, MESSAGE_DATE, MESSAGE_TEXT, MESSAGE_READ, ".$to."_NAME AS USER_NAME
			FROM ".$from."S_MESSAGE pm JOIN MESSAGE m ON m.MESSAGE_ID = pm.MESSAGE_ID LEFT JOIN ".$to." t ON t.".$to."_ID = pm.".$to."_ID
			WHERE ".$from."_ID = '$id' AND MESSAGE_FOLDER = '$type' AND (IFNULL(MESSAGE_TEXT, '') LIKE '%$search%' OR IFNULL(".$to."_NAME, '') LIKE '%$search%' )
			ORDER BY MESSAGE_DATE DESC LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalFolderMessages($id, $type, $search, $from, $to) {
			$query = $this->db->query("SELECT *
			FROM ".$from."S_MESSAGE pm JOIN MESSAGE m ON m.MESSAGE_ID = pm.MESSAGE_ID LEFT JOIN ".$to." t ON t.".$to."_ID = pm.".$to."_ID
			WHERE ".$from."_ID = '$id' AND MESSAGE_FOLDER = '$type' AND (IFNULL(MESSAGE_TEXT, '') LIKE '%$search%' OR IFNULL(".$to."_NAME, '') LIKE '%$search%' )");
			return $query->num_rows();
		}

		function totalUnreadPupilMessages($id, $type) {
			$query = $this->db->query("SELECT COUNT(PUPILS_MESSAGE_ID) AS COUNT FROM PUPILS_MESSAGE
			WHERE PUPIL_ID = '$id' AND MESSAGE_READ = 0 AND MESSAGE_FOLDER = '$type'");
			$arr = $query->row_array();
			$count = $arr['COUNT'];
			return $count;
		}

		function totalUnreadTeacherMessages($id, $type) {
			$query = $this->db->query("SELECT COUNT(TEACHERS_MESSAGE_ID) AS COUNT FROM TEACHERS_MESSAGE
			WHERE TEACHER_ID = '$id' AND MESSAGE_READ = 0 AND MESSAGE_FOLDER = '$type'");
			$arr = $query->row_array();
			$count = $arr['COUNT'];
			return $count;
		}


		function totalMessages($id, $from, $to, $search) {
			$query = $this->db->query("SELECT *
			FROM ".$from."S_MESSAGE pm JOIN MESSAGE m ON m.MESSAGE_ID = pm.MESSAGE_ID LEFT JOIN ".$to." t ON t.".$to."_ID = pm.".$to."_ID
			WHERE ".$from."_ID = '$id' AND IFNULL(".$to."_NAME, '') LIKE '%$search%'
			GROUP BY pm.".$to."_ID");
			return $query->num_rows();
		}

		function getMessages($limit = null, $offset = null, $id, $from, $to, $search) {
			$query = $this->db->query("SELECT ".$to."_NAME AS USER_NAME, COUNT(pm.MESSAGE_ID) AS COUNT, pm.".$to."_ID AS USER_ID,
			MAX(MESSAGE_DATE) AS MAX
			FROM ".$from."S_MESSAGE pm JOIN MESSAGE m ON m.MESSAGE_ID = pm.MESSAGE_ID LEFT JOIN ".$to." t ON t.".$to."_ID = pm.".$to."_ID
			WHERE ".$from."_ID = '$id' AND IFNULL(".$to."_NAME, '') LIKE '%$search%'
			GROUP BY pm.".$to."_ID ORDER BY MAX(MESSAGE_DATE) DESC
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function getNewMessages($user, $id, $from, $to) {
			$query = $this->db->query("SELECT *
			FROM ".$from."S_MESSAGE
			WHERE ".$from."_ID = '$id' AND ".$to."_ID = '$user' AND MESSAGE_READ = 0 AND MESSAGE_FOLDER = 1");
			return $query->result_array();
		}


		function getConversationMessages($limit = null, $offset = null, $id, $user, $search, $from, $to) {
			$query = $this->db->query("SELECT ".$from."S_MESSAGE_ID AS USER_MESSAGE_ID, pm.MESSAGE_ID, MESSAGE_DATE, MESSAGE_TEXT,
			MESSAGE_READ, ".$to."_NAME AS USER_NAME, MESSAGE_FOLDER, pm.".$to."_ID AS USER_ID
			FROM ".$from."S_MESSAGE pm JOIN MESSAGE m ON m.MESSAGE_ID = pm.MESSAGE_ID LEFT JOIN ".$to." t ON t.".$to."_ID = pm.".$to."_ID
			WHERE ".$from."_ID = '$id' AND IFNULL(MESSAGE_TEXT, '') LIKE '%$search%' AND pm.".$to."_ID = '$user'
			ORDER BY MESSAGE_DATE DESC LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalConversationMessages($id, $user, $search, $from, $to) {
			$query = $this->db->query("SELECT *
			FROM ".$from."S_MESSAGE pm JOIN MESSAGE m ON m.MESSAGE_ID = pm.MESSAGE_ID
			WHERE ".$from."_ID = '$id' AND IFNULL(MESSAGE_TEXT, '') LIKE '%$search%' AND pm.".$to."_ID = '$user'");
			return $query->num_rows();
		}


		function getUserById($id, $from, $to) {
			$query = $this->db->query("SELECT ".$to."_NAME AS USER_NAME
			FROM ".$from."S_MESSAGE pm JOIN ".$to." p ON p.".$to."_ID = pm.".$to."_ID
			WHERE pm.".$to."_ID = '$id'");
			return $query->row_array();
		}



	}
?>