<?php

	class Usermodel extends CI_Model {

		function getTeacher($login, $hash) {
			/* SELECT TEACHER_LOGIN, TEACHER_HASH, ROLE_ID, CLASS_ID, TEACHER_STATUS, TEACHER_ID
			FROM TEACHER
			WHERE TEACHER_LOGIN collate utf8_bin = '".$login."' AND TEACHER_HASH collate utf8_bin = '".$hash."'
			LIMIT 1*/
			$query = $this->db->query("SELECT * FROM TEACHER WHERE TEACHER_LOGIN collate utf8_bin = '$login'
			AND TEACHER_HASH collate utf8_bin = '$hash'");
			return $query->row_array();
		}

		function getPupil($login, $hash) {
			$query = $this->db->query("SELECT p.PUPIL_LOGIN, p.PUPIL_HASH, p.ROLE_ID, p.PUPIL_STATUS, p.PUPIL_ID, pc.CLASS_ID
			FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID JOIN CLASS c ON c.CLASS_ID = pc.CLASS_ID
			WHERE PUPIL_LOGIN collate utf8_bin = '$login' AND PUPIL_HASH = '$hash' AND CLASS_STATUS = 1");
			return $query->row_array();
		}

		function getTeacherClass($id) {
			$query = $this->db->query("SELECT CLASS_ID FROM CLASS WHERE TEACHER_ID = '$id' AND CLASS_STATUS = 1");
			return $query->row_array();
		}
	}

/* "SELECT ROLE_ID, CLASS.CLASS_ID, TEACHER.TEACHER_ID, TEACHER.TEACHER_LOGIN, TEACHER.TEACHER_STATUS
				FROM TEACHER LEFT JOIN CLASS ON CLASS.TEACHER_ID = TEACHER.TEACHER_ID
				WHERE TEACHER_LOGIN collate utf8_bin = '$login' AND TEACHER_HASH collate utf8_bin = '$hash'"*/
	?>