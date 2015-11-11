<?php

	class Apimodel extends CI_Model {

		function getTimetable($class_id, $day) {
			$query = $this->db->query("SELECT sc.SUBJECTS_CLASS_ID, r.ROOM_NAME, s.SUBJECT_NAME, tm.TIME_START, tm.TIME_FINISH, t.TIME_ID
			FROM TIMETABLE t JOIN SUBJECTS_CLASS sc ON t.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			JOIN ROOM r ON r.ROOM_ID = t.ROOM_ID
			JOIN TIME tm ON tm.TIME_ID = t.TIME_ID
			WHERE t.DAYOFWEEK_ID = '".$day."' AND sc.CLASS_ID = '".$class_id."'
			UNION
			SELECT sc.SUBJECTS_CLASS_ID, ROOM_ID, s.SUBJECT_NAME, tm.TIME_START, tm.TIME_FINISH, t.TIME_ID
			FROM TIMETABLE t JOIN SUBJECTS_CLASS sc ON t.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			JOIN TIME tm ON tm.TIME_ID = t.TIME_ID
			WHERE t.DAYOFWEEK_ID = '".$day."' AND sc.CLASS_ID = '".$class_id."' AND ROOM_ID IS NULL
			ORDER BY 4");
			return $query->result_array();
		}


		function getMarks($subject, $current, $id, $time) {
			$query = $this->db->query("SELECT ACHIEVEMENT_MARK
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE LESSON_DATE = '$current' AND PUPIL_ID = '$id' AND SUBJECTS_CLASS_ID = '$subject' AND TIME_ID = '$time'");
			return $query->result_array();
		}

		function getBorders($class_id, $current) {
			$query = $this->db->query("SELECT * FROM PERIOD
			WHERE YEAR_ID = (SELECT c.YEAR_ID
			FROM YEAR y JOIN CLASS c ON c.YEAR_ID = y.YEAR_ID
			WHERE CLASS_ID = '$class_id') AND '$current' >= PERIOD_START AND '$current' <= PERIOD_FINISH");
			return $query->row_array();
		}

		function getAverageMark($start, $current, $class_id, $pupil, $subject) {
			$query = $this->db->query("SELECT AVG(ACHIEVEMENT_MARK) AS MARK
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID JOIN SUBJECTS_CLASS sc
			ON sc.SUBJECTS_CLASS_ID = l.SUBJECTS_CLASS_ID
			WHERE l.SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$current' AND CLASS_ID = '$class_id' AND PUPIL_ID = '$pupil'
			GROUP BY PUPIL_ID");
			return $query->row_array();

		}

		function getPupils($class_id) {
			$query = $this->db->query("SELECT p.PUPIL_ID, PUPIL_NAME
			FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID
			WHERE CLASS_ID = '$class_id' ORDER BY PUPIL_NAME");
			return $query->result_array();
		}

		function getPasses($pupil_id, $subject, $period, $pass) {
			$query = $this->db->query("SELECT COUNT(ATTENDANCE_PASS) AS COUNT
			FROM ATTENDANCE a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject' AND ATTENDANCE_PASS = '$pass' AND
			LESSON_DATE >= (SELECT PERIOD_START FROM PERIOD WHERE PERIOD_ID = '$period') AND
			LESSON_DATE <= (SELECT PERIOD_FINISH FROM PERIOD WHERE PERIOD_ID = '$period')");
			return $query->row_array();
		}

		function getAllPasses($pupil_id, $period, $pass) {
			$query = $this->db->query("SELECT COUNT(ATTENDANCE_PASS) AS COUNT
			FROM ATTENDANCE a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil_id'  AND ATTENDANCE_PASS = '$pass' AND
			LESSON_DATE >= (SELECT PERIOD_START FROM PERIOD WHERE PERIOD_ID = '$period') AND
			LESSON_DATE <= (SELECT PERIOD_FINISH FROM PERIOD WHERE PERIOD_ID = '$period')");
			return $query->row_array();
		}
	}

	?>