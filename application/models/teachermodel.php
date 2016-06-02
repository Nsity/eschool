<?php

	class Teachermodel extends CI_Model {

		function getPupils($limit = null, $offset = null, $class, $search) {
			$query = $this->db->query("SELECT *
			FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID
			WHERE CLASS_ID = '$class' AND (IFNULL(PUPIL_NAME, '') LIKE '%$search%' OR IFNULL(PUPIL_LOGIN, '') LIKE '%$search%' OR IFNULL(PUPIL_ADDRESS, '') LIKE '%$search%' OR IFNULL(PUPIL_BIRTHDAY, '') LIKE '%$search%'  OR IFNULL(PUPIL_PHONE, '') LIKE '%$search%')
			LIMIT $offset, $limit");
			return $query->result_array();
		}


		function getAllPupils($class_id) {
			$query = $this->db->query("SELECT *
			FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID
			WHERE CLASS_ID = '$class_id' ORDER BY PUPIL_NAME");
			return $query->result_array();
		}



		function getPupilsFromAllClasses() {
			$query = $this->db->query("SELECT *
			FROM PUPIL");
			return $query->result_array();
		}

		function totalPupils($class, $search) {
			$query = $this->db->query("SELECT *
			FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID
			WHERE CLASS_ID = '$class' AND (IFNULL(PUPIL_NAME, '') LIKE '%$search%' OR IFNULL(PUPIL_LOGIN, '') LIKE '%$search%' OR IFNULL(PUPIL_ADDRESS, '') LIKE '%$search%' OR IFNULL(PUPIL_BIRTHDAY, '') LIKE '%$search%' OR IFNULL(PUPIL_PHONE, '') LIKE '%$search%')");
			return $query->num_rows();
		}

		function getPupilById($id, $class_id) {
			$query = $this->db->query("SELECT * FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID
			WHERE p.PUPIL_ID = '$id' AND CLASS_ID = '$class_id'");
			return $query->row_array();
		}

		function getSubjectsClass($limit = null, $offset = null, $class, $search) {
			$query = $this->db->query("SELECT sc.SUBJECTS_CLASS_ID, s.SUBJECT_ID, s.SUBJECT_NAME, sc.TEACHER_ID, t.TEACHER_NAME
			FROM SUBJECTS_CLASS sc LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			LEFT JOIN TEACHER t ON t.TEACHER_ID = sc.TEACHER_ID
			WHERE CLASS_ID = '$class' AND (IFNULL(TEACHER_NAME, '') LIKE '%$search%' OR IFNULL(SUBJECT_NAME, '') LIKE '%$search%' )
			ORDER BY 5, 3
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalSubjectsClass($class, $search) {
			$query = $this->db->query("SELECT *
			FROM SUBJECTS_CLASS sc LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			LEFT JOIN TEACHER t ON t.TEACHER_ID = sc.TEACHER_ID
			WHERE CLASS_ID = '$class' AND (IFNULL(TEACHER_NAME, '') LIKE '%$search%' OR IFNULL(SUBJECT_NAME, '') LIKE '%$search%' )");
			return $query->num_rows();
		}

		function getSubjectById($id, $class_id) {
			$query = $this->db->query("SELECT sc.SUBJECTS_CLASS_ID, s.SUBJECT_ID, s.SUBJECT_NAME, sc.TEACHER_ID, t.TEACHER_NAME
			FROM SUBJECTS_CLASS sc LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			LEFT JOIN TEACHER t ON t.TEACHER_ID = sc.TEACHER_ID
			WHERE sc.SUBJECTS_CLASS_ID = '$id' AND CLASS_ID = '$class_id'");
			return $query->row_array();
		}

		function getTeachers() {
			$query = $this->db->query("SELECT TEACHER_ID, TEACHER_NAME
			FROM TEACHER WHERE TEACHER_ID != 13 ORDER BY TEACHER_NAME");
			return $query->result_array();
		}
		function getSubjects() {
			$query = $this->db->query("SELECT SUBJECT_NAME, SUBJECT_ID
			FROM SUBJECT ORDER BY SUBJECT_NAME");
			return $query->result_array();
		}


		function getTimetable($class_id, $day) {
			$query = $this->db->query("SELECT t.TIMETABLE_ID, sc.SUBJECTS_CLASS_ID, r.ROOM_NAME, s.SUBJECT_NAME, tm.TIME_START, tm.TIME_FINISH
			FROM TIMETABLE t JOIN SUBJECTS_CLASS sc ON t.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			LEFT JOIN ROOM r ON r.ROOM_ID = t.ROOM_ID
			JOIN TIME tm ON tm.TIME_ID = t.TIME_ID
			WHERE t.DAYOFWEEK_ID = '$day' AND sc.CLASS_ID = '$class_id'
			ORDER BY 5");
			return $query->result_array();
		}

		function getTimes()
		{
			$query = $this->db->query("SELECT * FROM TIME ORDER BY TIME_START");
			return $query->result_array();
		}

		function getRooms() {
			$query = $this->db->query("SELECT * FROM ROOM ORDER BY ROOM_NAME");
			return $query->result_array();
		}

		function getAllSubjectsClass($class_id) {
			$query = $this->db->query("SELECT sc.SUBJECTS_CLASS_ID, s.SUBJECT_NAME
			FROM SUBJECTS_CLASS sc LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			WHERE CLASS_ID = '$class_id' ORDER BY 2");
			return $query->result_array();
		}


		function getTimetableById($id, $class_id) {
			$query = $this->db->query("SELECT * FROM TIMETABLE t JOIN SUBJECTS_CLASS sc ON t.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			WHERE TIMETABLE_ID = '$id' AND CLASS_ID = '$class_id'");
			return $query->row_array();
		}


		function getClasses($teacher) {
			$query = $this->db->query("SELECT distinct sc.CLASS_ID , c.CLASS_LETTER, c.CLASS_NUMBER, c.YEAR_ID, y.YEAR_START, y.YEAR_FINISH
			FROM SUBJECTS_CLASS sc JOIN CLASS c ON c.CLASS_ID = sc.CLASS_ID LEFT JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID
			WHERE sc.TEACHER_ID = '$teacher' ORDER BY 5 DESC, 3, 2 ");
			return $query->result_array();
		}

		function getSubjectsForClass($class_id, $teacher) {
			$query = $this->db->query("SELECT sc.SUBJECTS_CLASS_ID, s.SUBJECT_NAME
			FROM SUBJECTS_CLASS sc JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID
			WHERE CLASS_ID = '$class_id' AND TEACHER_ID = '$teacher' ORDER BY 2");
			return $query->result_array();
		}
		function getPupilsForClass($class_id) {
			$query = $this->db->query("SELECT p.PUPIL_ID, PUPIL_NAME
			FROM PUPIL p JOIN PUPILS_CLASS pc ON p.PUPIL_ID = pc.PUPIL_ID
			WHERE CLASS_ID = '$class_id' ORDER BY 2");
			return $query->result_array();
		}

		/*function getPupilMarks($pupil_id, $class_id, $subject_id) {
			$query = $this->db->query("SELECT PROGRESS_MARK, p.PROGRESS_ID, p.PERIOD_ID, pe.PERIOD_NAME, PERIOD_START, PERIOD_FINISH
			FROM PROGRESS p JOIN PERIOD pe ON pe.PERIOD_ID = p.PERIOD_ID
			WHERE p.PUPIL_ID = '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id'
			AND YEAR_ID = (SELECT YEAR_ID FROM CLASS WHERE CLASS_ID = '$class_id') ORDER BY PERIOD_NAME");
			return $query->result_array();
		}*/

		function getPupilProgressMark($pupil_id, $subject_id, $period_id) {
			$query = $this->db->query("SELECT PROGRESS_MARK AS MARK
			FROM PROGRESS
			WHERE PUPIL_ID = '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id' AND PERIOD_ID = '$period_id'");
			return $query->row_array();
		}


		function getAverageMarkForPupil($pupil, $subject, $start, $end) {
			$query = $this->db->query("SELECT AVG(ACHIEVEMENT_MARK) AS MARK
			FROM ACHIEVEMENT a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE >= '$start'
			AND LESSON_DATE <= '$end'");
			return $query->row_array();

		}

		function getLessons($limit = null, $offset = null, $subject, $search) {
			$query = $this->db->query("SELECT *
			FROM LESSON l JOIN TIME t ON t.TIME_ID = l.TIME_ID
			WHERE SUBJECTS_CLASS_ID = '$subject' AND (IFNULL(LESSON_THEME, '') LIKE '%$search%' OR IFNULL(LESSON_HOMEWORK, '') LIKE '%$search%' OR
			IFNULL(LESSON_DATE, '') LIKE '%$search%')
			ORDER BY LESSON_DATE DESC, TIME_START
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalLessons($subject, $search) {
			$query = $this->db->query("SELECT *
			FROM LESSON
			WHERE SUBJECTS_CLASS_ID = '$subject' AND (IFNULL(LESSON_THEME, '') LIKE '%$search%' OR IFNULL(LESSON_HOMEWORK, '') LIKE '%$search%' OR
			IFNULL(LESSON_DATE, '') LIKE '%$search%')");
			return $query->num_rows();
		}


		function getPupilMarksForLesson($pupil_id, $lesson_id) {
			$query = $this->db->query("SELECT *
			FROM ACHIEVEMENT a LEFT JOIN TYPE t ON t.TYPE_ID = a.TYPE_ID
			WHERE LESSON_ID = '$lesson_id' AND PUPIL_ID = '$pupil_id'");
			return $query->result_array();
		}

		function getPupilPassForLesson($pupil_id, $lesson_id) {
			$query = $this->db->query("SELECT *
			FROM ATTENDANCE
			WHERE LESSON_ID = '$lesson_id' AND PUPIL_ID = '$pupil_id'");
			return $query->row_array();
		}


		function checkLessonsForTeacher($subject, $id) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT
			FROM LESSON l JOIN SUBJECTS_CLASS sc ON sc.SUBJECTS_CLASS_ID = l.SUBJECTS_CLASS_ID
			WHERE TEACHER_ID = '$id' AND l.SUBJECTS_CLASS_ID ='$subject'");
			return $query->row_array();
		}

		/*function getFiles($lesson) {
			$query = $this->db->query("SELECT *
			FROM FILE
			WHERE LESSON_ID = '$lesson'");
			return $query->result_array();
		}*/

		function getLessonById($id, $subject, $user) {
			$query = $this->db->query("SELECT *
			FROM LESSON l JOIN SUBJECTS_CLASS sc ON l.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			JOIN CLASS c ON c.CLASS_ID = sc.CLASS_ID JOIN TIME t ON t.TIME_ID = l.TIME_ID LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECTS_CLASS_ID
			WHERE sc.TEACHER_ID = '$user' AND l.SUBJECTS_CLASS_ID = '$subject' AND LESSON_ID = '$id'");
			return $query->row_array();
		}

		function getPupilMarksForSubject($pupil_id, $subject_id, $start, $finish) {
			$query = $this->db->query("SELECT ACHIEVEMENT_MARK, TYPE_NAME, LESSON_DATE
			FROM ACHIEVEMENT a LEFT JOIN TYPE t ON t.TYPE_ID = a.TYPE_ID
			JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id' AND
			LESSON_DATE >= '$start' AND LESSON_DATE <= '$finish' ORDER BY LESSON_DATE DESC");
			return $query->result_array();
		}

		function getPupilPassForSubject($pupil_id, $subject_id, $start, $finish) {
			$query = $this->db->query("SELECT ATTENDANCE_PASS, COUNT(*) AS COUNT
			FROM ATTENDANCE a JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE PUPIL_ID = '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id' AND LESSON_DATE >= '$start'
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

		function getPupilProgressForSubject($pupil_id, $subject_id, $period) {
			$query = $this->db->query("SELECT PROGRESS_MARK FROM PROGRESS
			WHERE PUPIL_ID = '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id' AND PERIOD_ID = '$period'");
			return $query->row_array();
		}

		function getAverageForSubject($class_id, $subject_id, $period) {
			$query = $this->db->query("SELECT AVG(PROGRESS_MARK) AS MARK
			FROM PROGRESS pr JOIN PUPIL p ON p.PUPIL_ID = pr.PUPIL_ID JOIN PUPILS_CLASS pc ON pc.PUPIL_ID = p.PUPIL_ID
			WHERE SUBJECTS_CLASS_ID = '$subject_id' AND PERIOD_ID = '$period' AND CLASS_ID = '$class_id'");
			return $query->row_array();
		}

		function getClassBySubject($subject) {
			$query = $this->db->query("SELECT CLASS_ID FROM SUBJECTS_CLASS WHERE SUBJECTS_CLASS_ID = '$subject'");
			return $query->row_array();
		}


		function getTypes() {
			$query = $this->db->query("SELECT * FROM TYPE ORDER BY TYPE_NAME");
			return $query->result_array();
		}


		function getCountProgressMark($subject_id, $period_id, $mark) {
			$query = $this->db->query("SELECT COUNT(PROGRESS_MARK) AS COUNT FROM PROGRESS
			WHERE PERIOD_ID = '$period_id' AND PROGRESS_MARK = '$mark' AND SUBJECTS_CLASS_ID = '$subject_id'");
			return $query->row_array();
		}

		function getSubjectInfo($subject, $id) {
			$query = $this->db->query("SELECT SUBJECT_NAME, sc.SUBJECT_ID, sc.CLASS_ID, CLASS_LETTER, CLASS_NUMBER,
			YEAR(YEAR_START) AS YEAR_START, YEAR(YEAR_FINISH) AS YEAR_FINISH
			FROM SUBJECTS_CLASS sc LEFT JOIN SUBJECT s ON s.SUBJECT_ID = sc.SUBJECT_ID JOIN CLASS c ON c.CLASS_ID = sc.CLASS_ID
			JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID
			WHERE SUBJECTS_CLASS_ID = '$subject' AND sc.TEACHER_ID = '$id'");
			return $query->row_array();
		}

		function getClassesByDate($date, $id) {
			$query = $this->db->query("SELECT distinct c.CLASS_ID, CLASS_NUMBER, CLASS_LETTER
			FROM CLASS c JOIN YEAR y ON c.YEAR_ID = y.YEAR_ID JOIN SUBJECTS_CLASS sc ON sc.CLASS_ID =c.CLASS_ID
			WHERE '$date' >= YEAR_START AND '$date' <= YEAR_FINISH AND sc.TEACHER_ID = '$id'");
			return $query->result_array();
		}


		function getTimetableForSubject($subject) {
			$query =  $this->db->query("SELECT *
			FROM TIMETABLE t JOIN TIME tm ON t.TIME_ID = tm.TIME_ID
			WHERE SUBJECTS_CLASS_ID = '$subject'");
			return $query->result_array();
		}

		function getNews($limit = null, $offset = null, $id, $search) {
			$query = $this->db->query("SELECT *
			FROM NEWS
			WHERE TEACHER_ID = '$id' AND
			(IFNULL(NEWS_THEME, '') LIKE '%$search%' OR IFNULL(NEWS_TEXT, '') LIKE '%$search%' OR IFNULL(NEWS_TIME, '') LIKE '%$search%')
			ORDER BY NEWS_TIME DESC
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalNews($id, $search) {
			$query = $this->db->query("SELECT * FROM NEWS WHERE TEACHER_ID = '$id' AND
			(IFNULL(NEWS_THEME, '') LIKE '%$search%' OR IFNULL(NEWS_TEXT, '') LIKE '%$search%' OR IFNULL(NEWS_TIME, '') LIKE '%$search%')");
			return $query->num_rows();
		}


		function getNewsById($id, $user) {
			$query = $this->db->query("SELECT * FROM NEWS
			WHERE NEWS_ID = '$id' AND TEACHER_ID = '$user'");
			return $query->row_array();
		}

		function getPupilNoteForLesson($pupil_id, $lesson_id) {
			$query = $this->db->query("SELECT *
			FROM NOTE
			WHERE LESSON_ID = '$lesson_id' AND PUPIL_ID = '$pupil_id'");
			return $query->row_array();
		}

	}
?>