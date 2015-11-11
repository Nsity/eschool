<?php

	class Pupilmodel extends CI_Model {


		function getNews($limit = null, $offset = null){
			$query = $this->db->query("SELECT * FROM NEWS n JOIN TEACHER t ON t.TEACHER_ID = n.TEACHER_ID
			ORDER BY NEWS_TIME DESC, NEWS_THEME  LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalNews() {
			$this->db->like('TEACHER_ID', '13');
			$this->db->from('NEWS');
			return $this->db->count_all_results();
		}

		function getNewsById($id) {
			$query = $this->db->query("SELECT * FROM NEWS n JOIN TEACHER t ON t.TEACHER_ID = n.TEACHER_ID
			WHERE n.NEWS_ID = '$id'");
			return $query->row_array();
		}

		function getYears() {
			$query = $this->db->query("SELECT * FROM YEAR ORDER BY YEAR_START DESC");
			return $query->result_array();
		}

		function getClassInYear($pupil, $year) {
			$query = $this->db->query("SELECT c.CLASS_ID
			FROM CLASS c JOIN PUPILS_CLASS pc ON pc.CLASS_ID = c.CLASS_ID
			WHERE c.YEAR_ID = '$year' AND pc.PUPIL_ID = '$pupil'");
			return $query->result_array();
		}

		function getSubjectsClass($class_id) {
			$query = $this->db->query("SELECT s.SUBJECT_NAME, sc.SUBJECTS_CLASS_ID
			FROM SUBJECTS_CLASS sc JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			WHERE sc.CLASS_ID = '$class_id' ORDER BY 1");
			return $query->result_array();
		}

		function getProgressMarks($subject, $pupil_id) {
			$query = $this->db->query("SELECT p.PROGRESS_MARK, p.PERIOD_ID, PERIOD_NAME
			FROM PROGRESS p JOIN PERIOD pe ON pe.PERIOD_ID = p.PERIOD_ID
			WHERE p.SUBJECTS_CLASS_ID = '$subject' AND p.PUPIL_ID = '$pupil_id'");
			return $query->result_array();
		}

		function getTimetable($class_id, $day)
		{
			$query = $this->db->query("SELECT sc.SUBJECTS_CLASS_ID, r.ROOM_NAME, s.SUBJECT_NAME, tm.TIME_START, tm.TIME_FINISH, tm.TIME_ID
			FROM TIMETABLE t JOIN SUBJECTS_CLASS sc ON t.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			LEFT JOIN ROOM r ON r.ROOM_ID = t.ROOM_ID
			JOIN TIME tm ON tm.TIME_ID = t.TIME_ID
			WHERE t.DAYOFWEEK_ID = '$day' AND sc.CLASS_ID = '$class_id'
			ORDER BY 4");
			return $query->result_array();
		}

		function getPass($lesson, $pupil) {
			$query = $this->db->query("SELECT ATTENDANCE_PASS
			FROM ATTENDANCE a
			WHERE LESSON_ID = '$lesson' AND PUPIL_ID = '$pupil'");
			return $query->row_array();
		}


		function getNote($lesson, $pupil) {
			$query = $this->db->query("SELECT NOTE_TEXT
			FROM NOTE
			WHERE LESSON_ID = '$lesson' AND PUPIL_ID = '$pupil'");
			return $query->row_array();
		}

		function getMarks($lesson, $pupil) {
			$query = $this->db->query("SELECT ACHIEVEMENT_MARK, a.ACHIEVEMENT_ID, a.TYPE_ID, t.TYPE_NAME
			FROM ACHIEVEMENT a LEFT JOIN TYPE t ON a.TYPE_ID = t.TYPE_ID
			WHERE LESSON_ID = '$lesson' AND PUPIL_ID = '$pupil'");
			return $query->result_array();
		}

		function getLessonByDate($subject, $day, $time) {
			$query = $this->db->query("SELECT *
			FROM LESSON WHERE LESSON_DATE = '$day' AND SUBJECTS_CLASS_ID = '$subject' AND TIME_ID = '$time'");
			return $query->row_array();
		}


		function getPeriods($year) {
			$query = $this->db->query("SELECT p.PERIOD_ID, p.PERIOD_FINISH, p.PERIOD_NAME, p.PERIOD_START
			FROM PERIOD p JOIN YEAR y ON p.YEAR_ID = y.YEAR_ID
			AND PERIOD_NAME != 'Итоговая' AND y.YEAR_ID = '$year' ORDER BY PERIOD_START");
			return $query->result_array();
		}


		function getPeriodById($period) {
			$query = $this->db->query("SELECT * FROM PERIOD WHERE PERIOD_ID = '$period'");
			return $query->row_array();
		}


		/*function getAllMarks($pupil, $subject, $start, $end) {
			$query = $this->db->query("SELECT ACHIEVEMENT_MARK, TYPE_NAME
			FROM ACHIEVEMENT a JOIN TYPE t ON t.TYPE_ID = a.TYPE_ID JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$end'");
			return $query->result_array();
		}*/

		function getAllPasses($pupil, $subject, $start, $end) {
			$query = $this->db->query("SELECT COUNT(ATTENDANCE_ID) AS 'PASS'
			FROM ATTENDANCE a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$end'");
			return $query->result_array();
		}

		function getIllPasses($pupil, $subject, $start, $end) {
			$query = $this->db->query("SELECT COUNT(ATTENDANCE_ID) AS 'PASS'
			FROM ATTENDANCE a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$end' AND ATTENDANCE_PASS = 'б'");
			return $query->result_array();
		}

		function getAverageMarkForPupil($pupil, $subject, $start, $end) {
			$query = $this->db->query("SELECT AVG(ACHIEVEMENT_MARK) AS MARK
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$end'");
			return $query->result_array();

		}

		function getAverageMarkForClass($class_id, $subject, $start, $end) {
			$query = $this->db->query("SELECT max(MARK) AS MAX,min(MARK) AS MIN FROM(
			SELECT AVG(ACHIEVEMENT_MARK) AS MARK, PUPIL_ID
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID JOIN SUBJECTS_CLASS sc
			ON sc.SUBJECTS_CLASS_ID = l.SUBJECTS_CLASS_ID
			WHERE l.SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$end' AND CLASS_ID = '$class_id'
			GROUP BY PUPIL_ID) t");
			return $query->result_array();
		}

		function getCountPupilInClassByMark($mark, $pupil, $class_id, $subject, $start, $finish) {
			$result = array();

			$query = $this->db->query("SELECT COUNT(MARK) AS COUNT FROM( SELECT AVG(ACHIEVEMENT_MARK) AS MARK, PUPIL_ID
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID JOIN SUBJECTS_CLASS sc
			ON sc.SUBJECTS_CLASS_ID = l.SUBJECTS_CLASS_ID
			WHERE l.SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$finish' AND CLASS_ID = '$class_id' AND PUPIL_ID != '$pupil'
			GROUP BY PUPIL_ID
			HAVING AVG(ACHIEVEMENT_MARK) < $mark) t");
			$arr = $query->row_array();
			$result["min"] = $arr['COUNT'];

			$query = $this->db->query("SELECT COUNT(MARK) AS COUNT FROM( SELECT AVG(ACHIEVEMENT_MARK) AS MARK, PUPIL_ID
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID JOIN SUBJECTS_CLASS sc
			ON sc.SUBJECTS_CLASS_ID = l.SUBJECTS_CLASS_ID
			WHERE l.SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$finish' AND CLASS_ID = '$class_id' AND PUPIL_ID != '$pupil'
			GROUP BY PUPIL_ID
			HAVING AVG(ACHIEVEMENT_MARK) = $mark) t");
			$arr = $query->row_array();
			$result["same"] = $arr['COUNT'];

			$query = $this->db->query("SELECT COUNT(MARK) AS COUNT FROM( SELECT AVG(ACHIEVEMENT_MARK) AS MARK, PUPIL_ID
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID JOIN SUBJECTS_CLASS sc
			ON sc.SUBJECTS_CLASS_ID = l.SUBJECTS_CLASS_ID
			WHERE l.SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$finish' AND CLASS_ID = '$class_id' AND PUPIL_ID != '$pupil'
			GROUP BY PUPIL_ID
			HAVING AVG(ACHIEVEMENT_MARK) > $mark) t");
			$arr = $query->row_array();
			$result["max"] = $arr['COUNT'];

			return $result;
		}


		function getClassByDate($pupil_id, $monday){
			$query = $this->db->query("SELECT pc.CLASS_ID, YEAR_START, YEAR_FINISH
			FROM PUPILS_CLASS pc JOIN CLASS c ON c.CLASS_ID = pc.CLASS_ID
			JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID
			WHERE PUPIL_ID = '$pupil_id' AND '$monday' BETWEEN YEAR_START AND YEAR_FINISH");
			return $query->row_array();
		}


		function getFilesForHomework($lesson_id) {
			$query = $this->db->query("SELECT * FROM FILE WHERE LESSON_ID = '$lesson_id'");
			return $query->result_array();
		}


		function getClasses($pupil_id) {
			$query = $this->db->query("SELECT c.CLASS_ID, CLASS_NUMBER, CLASS_LETTER, YEAR(YEAR_START) AS YEAR_START, c.YEAR_ID,
			YEAR(YEAR_FINISH) AS YEAR_FINISH
			FROM CLASS c JOIN PUPILS_CLASS pc ON pc.CLASS_ID = c.CLASS_ID LEFT JOIN YEAR y ON c.YEAR_ID = y.YEAR_ID
			WHERE PUPIL_ID = '$pupil_id'
			ORDER BY YEAR_START DESC");
			return $query->result_array();
		}


		function getMarksForSubject($id, $subject_id, $start, $finish) {
			$query = $this->db->query("SELECT ACHIEVEMENT_MARK, TYPE_NAME, LESSON_DATE
			FROM ACHIEVEMENT a LEFT JOIN TYPE t ON t.TYPE_ID = a.TYPE_ID
			JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$id' AND SUBJECTS_CLASS_ID = '$subject_id' AND
			LESSON_DATE >= '$start' AND LESSON_DATE <= '$finish' ORDER BY LESSON_DATE DESC");
			return $query->result_array();
		}

		function getPassForSubject($id, $subject_id, $start, $finish) {
			$query = $this->db->query("SELECT ATTENDANCE_PASS, COUNT(*) AS COUNT
			FROM ATTENDANCE a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$id' AND SUBJECTS_CLASS_ID = '$subject_id' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$finish'
			GROUP BY ATTENDANCE_PASS");
			return $query->result_array();
		}


		function getBorders($class_id) {
			$query = $this->db->query("SELECT * FROM PERIOD
			WHERE YEAR_ID = (SELECT YEAR_ID FROM CLASS WHERE CLASS_ID = '$class_id')
			ORDER BY PERIOD_NAME");
			return $query->result_array();
		}

	}
	?>