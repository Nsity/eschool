<?php
	class Tablemodel extends CI_Model {

		public function __construct() {
			$this->load->library("roleenum");
		}


		function deleteRoom($id) {
			$this->db->where('ROOM_ID', $id);
			$this->db->delete('ROOM');
		}

		function deleteSubject($id) {
			$this->db->where('SUBJECT_ID', $id);
			$this->db->delete('SUBJECT');
		}

		function deleteType($id) {
			$this->db->where('TYPE_ID', $id);
			$this->db->delete('TYPE');
		}

		function deleteLesson($id) {
			$this->db->where('LESSON_ID', $id);
			$this->db->delete('LESSON');
		}

		function deleteMark($id) {
			$this->db->where('ACHIEVEMENT_ID', $id);
			$this->db->delete('ACHIEVEMENT');
		}


		function deleteYear($id) {
			$this->db->where('YEAR_ID', $id);
			$this->db->delete('YEAR');

		}

		function deleteNews($id) {
			$this->db->where('NEWS_ID', $id);
			$this->db->delete('NEWS');
		}

		function deleteClass($id) {
			$this->db->where('CLASS_ID', $id);
			$this->db->delete('CLASS');
		}

		function deletePupil($id) {
			$this->db->where('PUPIL_ID', $id);
			$this->db->delete('PUPIL');
		}

		function deleteTeacher($id) {
			$this->db->where('TEACHER_ID', $id);
			$this->db->delete('TEACHER');
		}

		function deleteTimetable($id) {
			$this->db->where('TIMETABLE_ID', $id);
			$this->db->delete('TIMETABLE');
		}

		function deleteSubjectsClass($id) {
			$this->db->where('SUBJECTS_CLASS_ID', $id);
			$this->db->delete('SUBJECTS_CLASS');
		}

		function deleteMessage($id, $from, $to) {
			$query = $this->db->query("SELECT MESSAGE_ID FROM ".$from."S_MESSAGE WHERE ".$from."S_MESSAGE_ID = '$id'");
			$message_id = $query->row_array()['MESSAGE_ID'];
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM ".$to."S_MESSAGE WHERE MESSAGE_ID = '$message_id'");
			$count = $query->row_array()['COUNT'];
			if($count == 0) {
				$this->db->where('MESSAGE_ID', $message_id);
				$this->db->delete('MESSAGE');
			}
			$this->db->where($from."S_MESSAGE_ID", $id);
			$this->db->delete($from."S_MESSAGE");

		}



		function deleteConversation($user, $id, $from, $to) {
			$query = $this->db->query("SELECT ".$from."S_MESSAGE_ID
			AS USER_MESSAGE_ID FROM ".$from."S_MESSAGE WHERE ".$from."_ID = '$user' AND ".$to."_ID = '$id'");
			$messages = $query->result_array();

			foreach($messages as $message) {
				$message_id = $message['USER_MESSAGE_ID'];
				$this->deleteMessage($message_id, $from, $to);
			}
		}

		function deleteTeacherMessage($id) {
			$query = $this->db->query("SELECT MESSAGE_ID FROM TEACHERS_MESSAGE WHERE TEACHERS_MESSAGE_ID = '$id'");
			$message_id = $query->row_array()['MESSAGE_ID'];
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM PUPILS_MESSAGE WHERE MESSAGE_ID = '$message_id'");
			$count = $query->row_array()['COUNT'];
			if($count == 0) {
				$this->db->where('MESSAGE_ID', $message_id);
				$this->db->delete('MESSAGE');
			}
			$this->db->where('TEACHERS_MESSAGE_ID', $id);
			$this->db->delete('TEACHERS_MESSAGE');

		}

		function responseSubjectName($subject, $id) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM SUBJECT
			WHERE SUBJECT_NAME = '$subject' AND SUBJECT_ID != '$id'");
			return $query->row_array();
		}

		function addSubject($subject) {
			$this->db->set('SUBJECT_NAME', $subject);
			$this->db->insert('SUBJECT');
		}

		function updateSubject($subject, $id) {
			$this->db->set('SUBJECT_NAME', $subject);
			$this->db->where('SUBJECT_ID', $id);
			$this->db->update('SUBJECT');
		}

		function responseRoomName($room, $id) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM ROOM
			WHERE ROOM_NAME = '$room' AND ROOM_ID != '$id'");
			return $query->row_array();
		}

		function addRoom($room) {
			$this->db->set('ROOM_NAME', $room);
			$this->db->insert('ROOM');
		}

		function updateRoom($room, $id) {
			$this->db->set('ROOM_NAME', $room);
			$this->db->where('ROOM_ID', $id);
			$this->db->update('ROOM');
		}

		function responseTypeName($name, $id) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM TYPE
			WHERE TYPE_NAME = '$name' AND TYPE_ID != '$id'");
			return $query->row_array();
		}

		function addType($name) {
			$this->db->set('TYPE_NAME', $name);
			$this->db->insert('TYPE');
		}

		function updateType($name, $id) {
			$this->db->set('TYPE_NAME', $name);
			$this->db->where('TYPE_ID', $id);
			$this->db->update('TYPE');
		}

		function addNews($theme, $date, $text, $user) {
			$this->db->set('NEWS_THEME', $theme);
			$this->db->set('NEWS_TIME', $date);
			$this->db->set('NEWS_TEXT', $text);
			$this->db->set('TEACHER_ID', $user);
			$this->db->insert('NEWS');
		}

		function updateNews($id, $theme, $date, $text, $user) {
			$this->db->set('NEWS_THEME', $theme);
			$this->db->set('NEWS_TIME', $date);
			$this->db->set('NEWS_TEXT', $text);
			$this->db->set('TEACHER_ID', $user);
			$this->db->where('NEWS_ID', $id);
			$this->db->update('NEWS');
		}

		function responseClass($id, $number, $letter, $year, $status) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM CLASS
			WHERE CLASS_NUMBER = '$number' AND CLASS_LETTER = '$letter' AND CLASS_STATUS = '$status' AND YEAR_ID = '$year' AND CLASS_ID != '$id'");
			return $query->row_array();
		}


		function addClass($number, $letter, $year, $status, $teacher, $previous) {
		    $this->db->set('CLASS_NUMBER', $number);
			$this->db->set('CLASS_LETTER', $letter);
			if($year != "") {
				$this->db->set('YEAR_ID', $year);
			}
			if($status !="") {
				$this->db->set('CLASS_STATUS', $status);
			}
			$this->db->set('TEACHER_ID', $teacher);
			if($previous == "") {
				$this->db->insert('CLASS');
			} else {
				$this->db->set('CLASS_PREVIOUS', $previous);
				$this->db->insert('CLASS');
				$id = $this->db->insert_id();

				$query = $this->db->query("SELECT PUPIL_ID FROM PUPILS_CLASS WHERE CLASS_ID = '$previous'");
				$pupils = $query->result_array();
				foreach($pupils as $pupil) {
					$pupil_id = $pupil['PUPIL_ID'];
					$this->db->set('PUPIL_ID', $pupil_id);
					$this->db->set('CLASS_ID', $id);
					$this->db->insert('PUPILS_CLASS');
				}

				$this->db->set('CLASS_STATUS', 0);
				$this->db->where('CLASS_ID', $previous);
				$this->db->update('CLASS');
			}
		}

		function updateClass($id, $number, $letter, $year, $status, $teacher, $previous) {
		    $this->db->set('CLASS_NUMBER', $number);
			$this->db->set('CLASS_LETTER', $letter);
			if($year != "") {
				$this->db->set('YEAR_ID', $year);
			}
			if($status !="") {
				$this->db->set('CLASS_STATUS', $status);
			}
		    $this->db->set('TEACHER_ID', $teacher);
			if($previous == "") {
				$this->db->where('CLASS_ID', $id);
				$this->db->update('CLASS');
			} else {
				$this->db->set('CLASS_PREVIOUS', $previous);
				$this->db->where('CLASS_ID', $id);
				$this->db->update('CLASS');
				$query = $this->db->query("SELECT PUPIL_ID FROM PUPILS_CLASS WHERE CLASS_ID = '$previous'");
				$pupils = $query->result_array();
				foreach($pupils as $pupil) {
					$pupil_id = $pupil['PUPIL_ID'];
					$this->db->set('PUPIL_ID', $pupil_id);
					$this->db->set('CLASS_ID', $id);
					$this->db->insert('PUPILS_CLASS');
				}
				$this->db->set('CLASS_STATUS', 0);
				$this->db->where('CLASS_ID', $previous);
				$this->db->update('CLASS');
			}
		}

		function responseTeacherLogin($id, $login) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM TEACHER
			WHERE TEACHER_LOGIN = '$login' AND TEACHER_ID != '$id'");
			return $query->row_array();
		}

		function responsePupilLogin($id, $login) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM PUPIL
			WHERE PUPIL_LOGIN = '$login' AND PUPIL_ID != '$id'");
			return $query->row_array();
		}

		function addTeacher($name, $password, $login, $status, $hash) {
			$this->db->set('TEACHER_NAME', $name);
			$this->db->set('TEACHER_PASSWORD', $password);
			$this->db->set('TEACHER_LOGIN', $login);
			$this->db->set('TEACHER_STATUS', $status);
			$this->db->set('TEACHER_HASH', $hash);
			$this->db->set('ROLE_ID', Roleenum::Teacher);
			$this->db->insert('TEACHER');
		}

		function updateTeacher($id, $name, $password, $login, $status, $hash) {
			$this->db->set('TEACHER_NAME', $name);
			$this->db->set('TEACHER_PASSWORD', $password);
			$this->db->set('TEACHER_LOGIN', $login);
			$this->db->set('TEACHER_STATUS', $status);
			$this->db->set('TEACHER_HASH', $hash);
			$this->db->set('ROLE_ID', Roleenum::Teacher);
			$this->db->where('TEACHER_ID', $id);
			$this->db->update('TEACHER');
		}


		function responseClassTeacher($id, $year, $teacher) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM CLASS
			WHERE TEACHER_ID = '$teacher' AND CLASS_ID != '$id' AND YEAR_ID = '$year'");
			return $query->row_array();
		}


		function addYearAndPeriods($year_start, $year_finish, $first_start, $first_finish, $second_start, $second_finish, $third_start,$third_finish, $forth_start, $forth_finish) {
			$this->db->set('YEAR_START', $year_start);
			$this->db->set('YEAR_FINISH', $year_finish);
			$this->db->insert('YEAR');
			$id = $this->db->insert_id();

			$this->db->set('PERIOD_START', $first_start);
			$this->db->set('PERIOD_FINISH', $first_finish);
			$this->db->set('PERIOD_NAME', 'I четверть');
			$this->db->set('YEAR_ID', $id);
			$this->db->insert('PERIOD');

			$this->db->set('PERIOD_START', $second_start);
			$this->db->set('PERIOD_FINISH', $second_finish);
			$this->db->set('PERIOD_NAME', 'II четверть');
			$this->db->set('YEAR_ID', $id);
			$this->db->insert('PERIOD');

			$this->db->set('PERIOD_START', $third_start);
			$this->db->set('PERIOD_FINISH', $third_finish);
			$this->db->set('PERIOD_NAME', 'III четверть');
			$this->db->set('YEAR_ID', $id);
			$this->db->insert('PERIOD');

			$this->db->set('PERIOD_START', $forth_start);
			$this->db->set('PERIOD_FINISH', $forth_finish);
			$this->db->set('PERIOD_NAME', 'IV четверть');
			$this->db->set('YEAR_ID', $id);
			$this->db->insert('PERIOD');

			$this->db->set('PERIOD_START', $year_start);
			$this->db->set('PERIOD_FINISH', $year_finish);
			$this->db->set('PERIOD_NAME', 'Итоговая');
			$this->db->set('YEAR_ID', $id);
			$this->db->insert('PERIOD');
		}

		function updateYearAndPeriods($id, $year_start, $year_finish, $first_start, $first_finish, $second_start, $second_finish, $third_start,$third_finish, $forth_start, $forth_finish) {
			$this->db->set('YEAR_START', $year_start);
			$this->db->set('YEAR_FINISH', $year_finish);
			$this->db->where('YEAR_ID', $id);
			$this->db->update('YEAR');

			$this->db->set('PERIOD_START', $first_start);
			$this->db->set('PERIOD_FINISH', $first_finish);
			$this->db->where('PERIOD_NAME', 'I четверть');
			$this->db->where('YEAR_ID', $id);
			$this->db->update('PERIOD');

			$this->db->set('PERIOD_START', $second_start);
			$this->db->set('PERIOD_FINISH', $second_finish);
			$this->db->where('PERIOD_NAME', 'II четверть');
			$this->db->where('YEAR_ID', $id);
			$this->db->update('PERIOD');

			$this->db->set('PERIOD_START', $third_start);
			$this->db->set('PERIOD_FINISH', $third_finish);
			$this->db->where('PERIOD_NAME', 'III четверть');
			$this->db->where('YEAR_ID', $id);
			$this->db->update('PERIOD');

			$this->db->set('PERIOD_START', $forth_start);
			$this->db->set('PERIOD_FINISH', $forth_finish);
			$this->db->where('PERIOD_NAME', 'IV четверть');
			$this->db->where('YEAR_ID', $id);
			$this->db->update('PERIOD');

			$this->db->set('PERIOD_START', $year_start);
			$this->db->set('PERIOD_FINISH', $year_finish);
			$this->db->where('PERIOD_NAME', 'Итоговая');
			$this->db->where('YEAR_ID', $id);
			$this->db->update('PERIOD');
		}
		//$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM PUPILS_CLASS
			//WHERE CLASS_ID = '$previous'");

//SELECT COUNT(*) AS COUNT FROM CLASS
			//WHERE CLASS_PREVIOUS = '$previous'
		function responseClassPrevious($previous) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM CLASS
			WHERE CLASS_PREVIOUS = '$previous'");
			return $query->row_array();
		}


		function addPupil($name, $password, $login, $status, $hash, $address, $phone, $birthday, $class_id) {
			$this->db->set('PUPIL_NAME', $name);
			$this->db->set('PUPIL_PASSWORD', $password);
			$this->db->set('PUPIL_LOGIN', $login);
			$this->db->set('PUPIL_STATUS', $status);
			$this->db->set('PUPIL_HASH', $hash);
			$this->db->set('ROLE_ID', Roleenum::Pupil);
			$this->db->set('PUPIL_ADDRESS', $address);
			if($birthday == "") {
				$this->db->set('PUPIL_BIRTHDAY', NULL);
			} else {
				$this->db->set('PUPIL_BIRTHDAY', $birthday);
			}
			$this->db->set('PUPIL_PHONE', $phone);
			$this->db->insert('PUPIL');
			$id = $this->db->insert_id();

			$this->db->set('PUPIL_ID', $id);
			$this->db->set('CLASS_ID', $class_id);
			$this->db->insert('PUPILS_CLASS');
		}

		function updatePupil($id, $name, $password, $login, $status, $hash, $address, $phone, $birthday) {
			$this->db->set('PUPIL_NAME', $name);
			$this->db->set('PUPIL_PASSWORD', $password);
			$this->db->set('PUPIL_LOGIN', $login);
			$this->db->set('PUPIL_STATUS', $status);
			$this->db->set('PUPIL_HASH', $hash);
			$this->db->set('ROLE_ID', Roleenum::Pupil);
			$this->db->set('PUPIL_ADDRESS', $address);
			if($birthday == "") {
				$this->db->set('PUPIL_BIRTHDAY', NULL);
			} else {
				$this->db->set('PUPIL_BIRTHDAY', $birthday);
			}
			$this->db->set('PUPIL_PHONE', $phone);
			$this->db->where('PUPIL_ID', $id);
			$this->db->update('PUPIL');
		}


		function responseSubjectsClass($id, $teacher, $subject, $class_id) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM SUBJECTS_CLASS
			WHERE SUBJECTS_CLASS_ID != '$id' AND TEACHER_ID = '$teacher' AND SUBJECT_ID = '$subject' AND CLASS_ID = '$class_id'");
			return $query->row_array();
		}

		function addSubjectsClass($teacher, $subject, $class_id) {
			$this->db->set('TEACHER_ID', $teacher);
			$this->db->set('SUBJECT_ID', $subject);
			$this->db->set('CLASS_ID', $class_id);
			$this->db->insert('SUBJECTS_CLASS');
		}

		function updateSubjectsClass($id, $teacher, $subject, $class_id) {
			$this->db->set('TEACHER_ID', $teacher);
			$this->db->set('SUBJECT_ID', $subject);
			$this->db->set('CLASS_ID', $class_id);
			$this->db->where('SUBJECTS_CLASS_ID', $id);
			$this->db->update('SUBJECTS_CLASS');
		}

		function responseTimetable($id, $time, $day, $class_id) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM TIMETABLE t JOIN SUBJECTS_CLASS sc ON t.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID
			WHERE t.TIMETABLE_ID != '$id' AND TIME_ID = '$time' AND DAYOFWEEK_ID = '$day' AND CLASS_ID = '$class_id'");
			return $query->row_array();
		}

		function addTimetable($time, $subject, $day, $room) {
			$this->db->set('TIME_ID', $time);
			$this->db->set('SUBJECTS_CLASS_ID', $subject);
			$this->db->set('DAYOFWEEK_ID', $day);
			if($room == "") {
				$this->db->set('ROOM_ID', NULL);
			} else {
				$this->db->set('ROOM_ID', $room);
			}
			$this->db->insert('TIMETABLE');
		}

		function updateTimetable($id, $time, $subject, $day, $room) {
			$this->db->set('TIME_ID', $time);
			$this->db->set('SUBJECTS_CLASS_ID', $subject);
			$this->db->set('DAYOFWEEK_ID', $day);
			if($room == "") {
				$this->db->set('ROOM_ID', NULL);
			} else {
				$this->db->set('ROOM_ID', $room);
			}
			
			$this->db->where('TIMETABLE_ID', $id);
			$this->db->update('TIMETABLE');
		}


		function responseYear($id, $start, $finish) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM YEAR
				WHERE YEAR_ID != '$id' AND YEAR(YEAR_START) = '$start' AND YEAR(YEAR_FINISH) = '$finish'");
			
			return $query->row_array();
		}


		function getSearchTeachers($search) {
			$query = $this->db->query("SELECT TEACHER_ID AS ID, TEACHER_NAME AS NAME
				FROM TEACHER
				WHERE TEACHER_ID != '13' AND IFNULL(TEACHER_NAME, '') LIKE '%$search%'
				ORDER BY TEACHER_NAME");
			
			return $query->result_array();
		}

		function getSearchPupils($search) {
			$query = $this->db->query("SELECT PUPIL_ID AS ID, PUPIL_NAME AS NAME
				FROM PUPIL
				WHERE IFNULL(PUPIL_NAME, '') LIKE '%$search%'
				ORDER BY PUPIL_NAME
			");
			
			return $query->result_array();
		}

		/*function addPupilMessage($from, $to, $text, $date) {
			$this->db->set('MESSAGE_TEXT', $text);
			$this->db->set('MESSAGE_DATE', $date);
			$this->db->insert('MESSAGE');
			$message_id = $this->db->insert_id();

			$this->db->set('MESSAGE_FOLDER', 2);
			$this->db->set('MESSAGE_ID', $message_id);
			$this->db->set('TEACHER_ID', $to);
			$this->db->set('PUPIL_ID', $from);
			$this->db->set('MESSAGE_READ', 0);
			$this->db->insert('PUPILS_MESSAGE');


			$this->db->set('MESSAGE_FOLDER', 1);
			$this->db->set('MESSAGE_ID', $message_id);
			$this->db->set('TEACHER_ID', $to);
			$this->db->set('PUPIL_ID', $from);
			$this->db->set('MESSAGE_READ', 0);
			$this->db->insert('TEACHERS_MESSAGE');
		}

		function addTeacherMessage($from, $to, $text, $date) {
			$this->db->set('MESSAGE_TEXT', $text);
			$this->db->set('MESSAGE_DATE', $date);
			$this->db->insert('MESSAGE');
			$message_id = $this->db->insert_id();

			$this->db->set('MESSAGE_FOLDER', 2);
			$this->db->set('MESSAGE_ID', $message_id);
			$this->db->set('PUPIL_ID', $to);
			$this->db->set('TEACHER_ID', $from);
			$this->db->set('MESSAGE_READ', 0);
			$this->db->insert('TEACHERS_MESSAGE');


			$this->db->set('MESSAGE_FOLDER', 1);
			$this->db->set('MESSAGE_ID', $message_id);
			$this->db->set('PUPIL_ID', $to);
			$this->db->set('TEACHER_ID', $from);
			$this->db->set('MESSAGE_READ', 0);
			$this->db->insert('PUPILS_MESSAGE');
		}*/

		function readMessage($id, $from, $to) {
			$this->db->set('MESSAGE_READ', 1);
			$this->db->where($from."S_MESSAGE_ID", $id);
			$this->db->update($from."S_MESSAGE");
		}

		function changeLessonStatus($lesson, $status) {
			$this->db->set('LESSON_STATUS', $status);
			$this->db->where("LESSON_ID", $lesson);
			$this->db->update("LESSON");
		}


		function changeProgress($pupil_id, $subject_id, $period, $class_id, $mark) {
			$query = $this->db->query("SELECT PROGRESS_ID, PROGRESS_MARK
			FROM PROGRESS p JOIN PERIOD pe ON p.PERIOD_ID = pe.PERIOD_ID
			WHERE PUPIL_ID =  '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id' AND PERIOD_NAME = '$period'
			AND YEAR_ID = (SELECT YEAR_ID FROM CLASS WHERE CLASS_ID = '$class_id')");
			$progress = $query->row_array();
			if(isset($progress)) {
				if($mark == "") {
					//удаление
					$this->db->where('PROGRESS_ID', $progress['PROGRESS_ID']);
			        $this->db->delete('PROGRESS');
				} else {
					//обновление
					$this->db->set('PROGRESS_MARK', $mark);
					$this->db->where('PROGRESS_ID', $progress['PROGRESS_ID']);
					$this->db->update('PROGRESS');
				}
			} else {
				//добавление
				$query = $this->db->query("SELECT PERIOD_ID FROM PERIOD
				WHERE YEAR_ID = (SELECT YEAR_ID FROM CLASS WHERE CLASS_ID = '$class_id') AND PERIOD_NAME = '$period'");
				$this->db->set('PUPIL_ID', $pupil_id);
				$this->db->set('PROGRESS_MARK', $mark);
				$this->db->set('SUBJECTS_CLASS_ID', $subject_id);
				$this->db->set('PERIOD_ID', $query->row_array()['PERIOD_ID']);
				$this->db->insert('PROGRESS');

			}
		}

		function changeAttendance($pupil_id, $lesson_id, $attendance_id, $pass) {
			if($attendance_id != "") {
				if ($pass == "") {
					//удаление
					$this->db->where('ATTENDANCE_ID', $attendance_id);
			        $this->db->delete('ATTENDANCE');
				} else {
					//обновление
					$this->db->set('ATTENDANCE_PASS', $pass);
					$this->db->where('ATTENDANCE_ID', $attendance_id);
					$this->db->update('ATTENDANCE');
				}
			} else {
				//добавление
				$this->db->set('PUPIL_ID', $pupil_id);
				$this->db->set('ATTENDANCE_PASS', $pass);
				$this->db->set('LESSON_ID', $lesson_id);
				$this->db->insert('ATTENDANCE');

			}
		}



		function readConversation($user, $id, $from, $to) {
			$this->db->set('MESSAGE_READ', 1);
			$this->db->where($from."_ID", $user);
			$this->db->where($to."_ID", $id);
			$this->db->update($from."S_MESSAGE");
		}


		function addMessage($id, $user, $text, $date, $from, $to) {
			$this->db->set('MESSAGE_TEXT', $text);
			$this->db->set('MESSAGE_DATE', $date);
			$this->db->insert('MESSAGE');
			$message_id = $this->db->insert_id();

			$this->db->set('MESSAGE_FOLDER', 2);
			$this->db->set('MESSAGE_ID', $message_id);
			$this->db->set($to."_ID", $user);
			$this->db->set($from."_ID", $id);
			$this->db->set('MESSAGE_READ', 0);
			$this->db->insert($from."S_MESSAGE");


			$this->db->set('MESSAGE_FOLDER', 1);
			$this->db->set('MESSAGE_ID', $message_id);
			$this->db->set($to."_ID", $user);
			$this->db->set($from."_ID", $id);
			$this->db->set('MESSAGE_READ', 0);
			$this->db->insert($to."S_MESSAGE");

			$message_id = $this->db->insert_id();
			return $message_id;
		}


		/*function responseLesson($id, $date, $time, $subject) {
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM LESSON
			WHERE LESSON_ID != '$id' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE = '$date' AND TIME_ID  = '$time'");
			return $query->row_array();
		}*/


		function responseLesson($id, $date, $time, $subject) {
			$day = date("w", strtotime($date));
			$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM LESSON
			WHERE LESSON_ID != '$id' AND SUBJECTS_CLASS_ID = '$subject' AND LESSON_DATE = '$date' AND TIME_ID  = '$time'");
			$arr = $query->row_array();
			if($arr['COUNT'] == 0) {
				$query = $this->db->query("SELECT COUNT(*) AS COUNT FROM TIMETABLE
				WHERE SUBJECTS_CLASS_ID = '$subject' AND DAYOFWEEK_ID = '$day' AND TIME_ID  = '$time'");
				$arr = $query->row_array();
				if($arr['COUNT'] == 0) {
					return 2;
				} else {
					return 0;
				}
			} else {
				return 1;
			}
		}


		function addLesson($subject, $theme, $date, $time, $homework, $status) {
			$this->db->set('LESSON_THEME', $theme);
			$this->db->set('LESSON_DATE', $date);
			$this->db->set('LESSON_HOMEWORK', $homework);
			$this->db->set('TIME_ID', $time);
			$this->db->set('SUBJECTS_CLASS_ID', $subject);
			$this->db->set('LESSON_STATUS', $status);
			$this->db->insert('LESSON');
			return $this->db->insert_id();
		}

		function updateLesson($id, $subject, $theme, $date, $time, $homework, $status) {
			$this->db->set('LESSON_THEME', $theme);
			$this->db->set('LESSON_DATE', $date);
			$this->db->set('LESSON_HOMEWORK', $homework);
			$this->db->set('TIME_ID', $time);
			$this->db->set('SUBJECTS_CLASS_ID', $subject);
			$this->db->set('LESSON_STATUS', $status);
			$this->db->where('LESSON_ID', $id);
			$this->db->update('LESSON');
		}
		function addFile($size, $ext, $name, $id) {
			$this->db->set('FILE_NAME', $name);
			$this->db->set('FILE_SIZE', $size);
			$this->db->set('FILE_EXTENSION', $ext);
			$this->db->set('LESSON_ID', $id);
			$this->db->insert('FILE');
			return $this->db->insert_id();
		}

		function changeAchievement($pupil_id, $lesson_id, $achievement_id, $mark, $type) {
			if(isset($achievement_id) && $achievement_id != "") {
				//обновление
				$this->db->set('ACHIEVEMENT_MARK', $mark);
				$this->db->set('TYPE_ID', $type);
				$this->db->where('ACHIEVEMENT_ID', $achievement_id);
				$this->db->update('ACHIEVEMENT');
			} else {
				//добавление
				$this->db->set('PUPIL_ID', $pupil_id);
				$this->db->set('ACHIEVEMENT_MARK', $mark);
				$this->db->set('LESSON_ID', $lesson_id);
				$this->db->set('TYPE_ID', $type);
				$this->db->insert('ACHIEVEMENT');

			}
		}



		function changeNote($pupil_id, $lesson_id, $note_id, $note) {
			if($note_id != "") {
				if ($note == "") {
					//удаление
					$this->db->where('NOTE_ID', $note_id);
			        $this->db->delete('NOTE');
				} else {
					//обновление
					$this->db->set('NOTE_TEXT', $note);
					$this->db->where('NOTE_ID', $note_id);
					$this->db->update('NOTE');
				}
			} else {
				//добавление
				$this->db->set('PUPIL_ID', $pupil_id);
				$this->db->set('NOTE_TEXT', $note);
				$this->db->set('LESSON_ID', $lesson_id);
				$this->db->insert('NOTE');

			}
		}

		function getGCMIDs($pupil_id) {
			$query = $this->db->query("SELECT * FROM GCM_USERS WHERE PUPIL_ID = '$pupil_id'");
			return $query->result_array();
		}


		function getSubjectNameByLessonId($lesson_id) {
			$query = $this->db->query("SELECT SUBJECT_NAME FROM SUBJECT s JOIN SUBJECTS_CLASS sc ON s.SUBJECT_ID = sc.SUBJECT_ID
			JOIN LESSON l ON l.SUBJECTS_CLASS_ID = sc.SUBJECTS_CLASS_ID WHERE LESSON_ID = '$lesson_id'");
			return $query->row_array();
		}

		function getTypeById($type_id) {
			$query = $this->db->query("SELECT TYPE_NAME FROM TYPE WHERE TYPE_ID = '$type_id'");
			return $query->row_array();
		}


		function getLessonById($lesson_id) {
			$query = $this->db->query("SELECT * FROM LESSON WHERE LESSON_ID = '$lesson_id'");
			return $query->row_array();
		}


		function getPupilProgressMark($pupil_id, $subject_id, $period, $class_id, $mark) {
			$query = $this->db->query("SELECT PROGRESS_ID, p.PERIOD_ID
			FROM PROGRESS p JOIN PERIOD pe ON p.PERIOD_ID = pe.PERIOD_ID
			WHERE PUPIL_ID =  '$pupil_id' AND SUBJECTS_CLASS_ID = '$subject_id' AND PERIOD_NAME = '$period'
			AND YEAR_ID = (SELECT YEAR_ID FROM CLASS WHERE CLASS_ID = '$class_id')");

			return $query->row_array();
		}
	}
