<?php
	class Adminmodel extends CI_Model {

		function getTeachers($limit = null, $offset = null, $search) {
			$query = $this->db->query("SELECT *
			FROM TEACHER
			WHERE TEACHER_ID != 13 AND (IFNULL(TEACHER_NAME, '') LIKE '%$search%' OR IFNULL(TEACHER_LOGIN, '') LIKE '%$search%' )
			ORDER BY TEACHER_NAME
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalTeachers($search) {
			$query = $this->db->query("SELECT *
			FROM TEACHER
			WHERE TEACHER_ID != 13 AND (IFNULL(TEACHER_NAME, '') LIKE '%$search%' OR IFNULL(TEACHER_LOGIN, '') LIKE '%$search%' )");
			return $query->num_rows();
		}

		function getSubjects($limit = null, $offset = null, $search) {
			$query = $this->db->query("SELECT * FROM SUBJECT WHERE IFNULL(SUBJECT_NAME, '') LIKE '%$search%' ORDER BY SUBJECT_NAME
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalSubjects($search) {
			$this->db->like('SUBJECT_NAME', $search);
			$this->db->from('SUBJECT');
			return $this->db->count_all_results();
		}

		function getRooms($limit = null, $offset = null, $search) {
			$query = $this->db->query("SELECT * FROM ROOM WHERE IFNULL(ROOM_NAME, '') LIKE '%$search%' ORDER BY ROOM_NAME
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalRooms($search) {
			$this->db->like('ROOM_NAME', $search);
			$this->db->from('ROOM');
			return $this->db->count_all_results();
		}

		function getAllTeachers() {
			$query = $this->db->query("SELECT *
			FROM TEACHER
			WHERE TEACHER_ID != 13
			ORDER BY TEACHER_NAME");
			return $query->result_array();
		}


		function getTypes($limit = null, $offset = null, $search) {
			$query = $this->db->query("SELECT * FROM TYPE WHERE IFNULL(TYPE_NAME, '') LIKE '%$search%' ORDER BY TYPE_NAME
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function totalTypes($search) {
			$this->db->like('TYPE_NAME', $search);
			$this->db->from('TYPE');
			return $this->db->count_all_results();
		}

		function responseSubjectName($subject) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM SUBJECT
			WHERE SUBJECT_NAME = '$subject'");
			return $query->row_array();
		}

		function addSubject($subject) {
			$this->db->set('SUBJECT_NAME', $subject);
			$this->db->insert('SUBJECT');
			return $this->db->insert_id();
		}

		function getSubjectById($id) {
			$query = $this->db->query("SELECT * FROM SUBJECT
			WHERE SUBJECT_ID = '$id'");
			return $query->row_array();
		}


		function getRoomById($id) {
			$query = $this->db->query("SELECT * FROM ROOM
			WHERE ROOM_ID = '$id'");
			return $query->row_array();
		}

		function getTypeById($id) {
			$query = $this->db->query("SELECT * FROM TYPE
			WHERE TYPE_ID = '$id'");
			return $query->row_array();
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

		function getClasses($limit = null, $offset = null, $search) {
			$query = $this->db->query("SELECT c.CLASS_ID, c.YEAR_ID, YEAR_FINISH, YEAR_START, t.TEACHER_ID, TEACHER_NAME, CLASS_LETTER, CLASS_NUMBER,
			CLASS_STATUS
			FROM CLASS c LEFT JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID LEFT JOIN TEACHER t ON c.TEACHER_ID = t.TEACHER_ID
			WHERE CLASS_STATUS = 1 AND (IFNULL(CLASS_NUMBER, '') LIKE '%$search%' OR IFNULL(CLASS_LETTER, '') LIKE '%$search%' OR IFNULL(TEACHER_NAME, '') LIKE '%$search%'
			OR IFNULL(YEAR(YEAR_START), '') LIKE '%$search%' OR IFNULL(YEAR(YEAR_FINISH), '') LIKE '%$search%')
			ORDER BY CLASS_STATUS DESC, YEAR_START DESC, CLASS_NUMBER DESC, CLASS_LETTER
			LIMIT $offset, $limit");
			return $query->result_array();
		}

		function getAllClasses() {
			$query = $this->db->query("SELECT * FROM CLASS c LEFT JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID ORDER BY YEAR_START DESC, CLASS_NUMBER DESC, CLASS_LETTER");
			return $query->result_array();
		}

		function totalClasses($search) {
			$query = $this->db->query("SELECT *
			FROM CLASS c LEFT JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID LEFT JOIN TEACHER t ON c.TEACHER_ID = t.TEACHER_ID
			WHERE IFNULL(CLASS_NUMBER, '') LIKE '%$search%' OR IFNULL(CLASS_LETTER, '') LIKE '%$search%' OR IFNULL(TEACHER_NAME, '') LIKE '%$search%'
			OR IFNULL(YEAR(YEAR_START), '') LIKE '%$search%' OR IFNULL(YEAR(YEAR_FINISH), '') LIKE '%$search%'");
			return $query->num_rows();
		}

		function getClassById($id) {
			$query = $this->db->query("SELECT c.CLASS_ID, c.YEAR_ID, YEAR_FINISH, YEAR_START, t.TEACHER_ID, TEACHER_NAME, CLASS_LETTER, CLASS_NUMBER,
		    CLASS_STATUS FROM CLASS c LEFT JOIN YEAR y ON y.YEAR_ID = c.YEAR_ID LEFT JOIN TEACHER t ON c.TEACHER_ID = t.TEACHER_ID
			WHERE c.CLASS_ID = '$id'");
			return $query->row_array();
		}


		function getTeacherById($id) {
			$query = $this->db->query("SELECT * FROM TEACHER
			WHERE TEACHER_ID = '$id'");
			return $query->row_array();
		}


		function getYears() {
			$query = $this->db->query("SELECT * FROM YEAR ORDER BY YEAR_START DESC");
			return $query->result_array();
		}


		/*function getPeriods($id) {
			$query = $this->db->query("SELECT * FROM PERIOD WHERE YEAR_ID ='$id'");
			return $query->result_array();
		}*/



		private function _showDate($date) {
			$day = date('d', strtotime($date));
			$mounth = date('m', strtotime($date));
			$year = date('Y', strtotime($date));
			$data = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня',
			'07'=>'июля', '08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');
			foreach ($data as $key=>$value) {
				if ($key==$mounth) return ltrim($day, '0')." $value $year года";
			}
		}

		function getYearsLimit($limit = null, $offset = null) {
			$query = $this->db->query("SELECT * FROM YEAR ORDER BY YEAR_START DESC
			LIMIT $offset, $limit");

			$arr = $query->result_array();
			$result = array();
			$i = 0;
			foreach($arr as $year) {
				$year_id = $year['YEAR_ID'];
				$result[$i]["id"] = $year_id;
				$result[$i]["fifth"]["start"] = $this->_showDate($year['YEAR_START']);
				$result[$i]["fifth"]["finish"] = $this->_showDate($year['YEAR_FINISH']);
				$periods = $this->getPeriods($year_id);
				foreach($periods as $period) {
					if($period['PERIOD_NAME'] =="I четверть") {
						$result[$i]["first"]["start"] = $this->_showDate($period['PERIOD_START']);
						$result[$i]["first"]["finish"] = $this->_showDate($period['PERIOD_FINISH']);
					}
					if($period['PERIOD_NAME'] =="II четверть") {
						$result[$i]["second"]["start"] = $this->_showDate($period['PERIOD_START']);
						$result[$i]["second"]["finish"]= $this->_showDate($period['PERIOD_FINISH']);
					}
					if($period['PERIOD_NAME'] =="III четверть") {
						$result[$i]["third"]["start"] = $this->_showDate($period['PERIOD_START']);
						$result[$i]["third"]["finish"] = $this->_showDate($period['PERIOD_FINISH']);
					}
					if($period['PERIOD_NAME'] =="IV четверть") {
						$result[$i]["forth"]["start"] = $this->_showDate($period['PERIOD_START']);
						$result[$i]["forth"]["finish"] = $this->_showDate($period['PERIOD_FINISH']);
					}
				}
				$i++;
			}
			return $result;
		}

		function totalYears() {
			$this->db->from('YEAR');
			return $this->db->count_all_results();
		}



		function getYearById($id) {
			$query = $this->db->query("SELECT * FROM YEAR WHERE YEAR_ID = '$id'");
			$year = $query->row_array();
			if (isset($year)) {
				$result = array();
				$result["id"] = $year['YEAR_ID'];
				$result["fifth"]["start"] = $year['YEAR_START'];
				$result["fifth"]["finish"] = $year['YEAR_FINISH'];

				$periods = $this->getPeriods($year['YEAR_ID']);
				foreach($periods as $period) {
					if($period['PERIOD_NAME'] =="I четверть") {
						$result["first"]["start"] = $period['PERIOD_START'];
						$result["first"]["finish"] = $period['PERIOD_FINISH'];
					}
					if($period['PERIOD_NAME'] =="II четверть") {
						$result["second"]["start"] = $period['PERIOD_START'];
						$result["second"]["finish"]= $period['PERIOD_FINISH'];
					}
					if($period['PERIOD_NAME'] =="III четверть") {
						$result["third"]["start"] = $period['PERIOD_START'];
						$result["third"]["finish"] = $period['PERIOD_FINISH'];
					}
					if($period['PERIOD_NAME'] =="IV четверть") {
						$result["forth"]["start"] = $period['PERIOD_START'];
						$result["forth"]["finish"] = $period['PERIOD_FINISH'];
					}
				}
				return $result;
			} else {
				return null;
			}
		}


		function getClassesInYear($year) {
			$query = $this->db->query("SELECT * FROM CLASS WHERE YEAR_ID ='$year' ORDER BY CLASS_NUMBER, CLASS_LETTER");
			return $query->result_array();
		}

		function getPupilsInClass($class_id) {
			$query = $this->db->query("SELECT * FROM PUPILS_CLASS pc JOIN PUPIL p ON p.PUPIL_ID = pc.PUPIL_ID WHERE CLASS_ID = '$class_id' ORDER BY PUPIL_NAME");
			return $query->result_array();
		}


		function getPeriodsInYear($year) {
			$query = $this->db->query("SELECT * FROM PERIOD WHERE YEAR_ID = '$year'
			ORDER BY PERIOD_NAME");
			return $query->result_array();
		}


		function getProgressMark($class_id, $mark, $period) {
			$query = $this->db->query("SELECT PROGRESS_ID, p.PUPIL_ID, PUPIL_NAME, PROGRESS_MARK, SUBJECT_NAME
			FROM PROGRESS p JOIN PUPIL pu ON pu.PUPIL_ID = p.PUPIL_ID
			JOIN PUPILS_CLASS pc ON pc.PUPIL_ID = pu.PUPIL_ID
			JOIN SUBJECTS_CLASS sc ON p.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			LEFT JOIN SUBJECT s ON sc.SUBJECT_ID = s.SUBJECT_ID
			WHERE pc.CLASS_ID = '$class_id' AND PERIOD_ID = '$period' AND PROGRESS_MARK = '$mark'
			ORDER BY PUPIL_NAME, SUBJECT_NAME");
			return $query->result_array();
		}

		function getCountProgressMark($class_id, $period) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT
			FROM PROGRESS p JOIN PUPIL pu ON pu.PUPIL_ID = p.PUPIL_ID
			JOIN PUPILS_CLASS pc ON pc.PUPIL_ID = pu.PUPIL_ID
			WHERE CLASS_ID = '$class_id' AND PERIOD_ID = '$period'");
			return $query->row_array();
		}

		function getPupilProgress($pupil_id, $period) {
			$query = $this->db->query("SELECT PROGRESS_MARK
			FROM PROGRESS
			WHERE PERIOD_ID = '$period' AND PUPIL_ID = '$pupil_id'
			ORDER BY PROGRESS_MARK");
			return $query->result_array();
		}

		/*function getClassPass($year, $period, $pass) {
			$query = $this->db->query("SELECT COUNT(ATTENDANCE_ID) AS PASS, pc.CLASS_ID, CLASS_NUMBER, CLASS_LETTER
			FROM ATTENDANCE a JOIN PUPIL p ON p.PUPIL_ID = a.PUPIL_ID
			JOIN PUPILS_CLASS pc ON pc.PUPIL_ID = p.PUPIL_ID JOIN CLASS c ON c.CLASS_ID = pc.CLASS_ID
			JOIN LESSON l ON l.LESSON_ID = a.LESSON_ID
			WHERE ATTENDANCE_PASS = '$pass' AND YEAR_ID ='$year' AND
			LESSON_DATE >= (SELECT PERIOD_START FROM PERIOD WHERE PERIOD_ID = '$period') AND
			LESSON_DATE <= (SELECT PERIOD_FINISH FROM PERIOD WHERE PERIOD_ID = '$period')
			GROUP BY pc.CLASS_ID
			ORDER BY 1 DESC");
			return $query->result_array();

		}*/

	}
?>