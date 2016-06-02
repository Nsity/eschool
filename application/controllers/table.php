<?php
	class Table extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('tablemodel', 'table');
        }

        //$table - из какой таблицы удаляем, $id - id записи
		function del($table, $id) {
			switch($table) {
				case 'subject': {
					$this->table->deleteSubject($id);
					break;
				}
				case 'room': {
					$this->table->deleteRoom($id);
					break;
				}
				case 'type': {
					$this->table->deleteType($id);
					break;
				}
				case 'news': {
					$this->table->deleteNews($id);
					break;
				}
				case 'class': {
					$this->table->deleteClass($id);
					break;
				}
				case 'teacher': {
					$this->table->deleteTeacher($id);
					break;
				}
				case 'year': {
					$this->table->deleteYear($id);
					break;
				}
				case 'pupil': {
					$this->table->deletePupil($id);
					break;
				}
				case 'subjectsclass': {
					$this->table->deleteSubjectsClass($id);
					break;
				}
				case 'timetable': {
					$this->table->deleteTimetable($id);
					break;
				}
				case 'message': {
					$role = $this->session->userdata('role');
					switch($role) {
						case 4: {
							$this->table->deleteMessage($id, 'PUPIL', 'TEACHER');
							break;
						}
						case 1: case 3: {
							$this->table->deleteMessage($id, 'TEACHER', 'PUPIL');
							break;
						}
					}
					break;
				}
				case 'lesson': {
					$this->table->deleteLesson($id);
					break;
				}
				case 'mark': {
					$this->table->deleteMark($id);
					break;
				}
				case 'conversation': {
					$user = $this->session->userdata('id');
					$role = $this->session->userdata('role');
					switch($role) {
						case 4: {
							$this->table->deleteConversation($user, $id, 'PUPIL', 'TEACHER');
							break;
						}
						case 1: case 3: {
							$this->table->deleteConversation($user, $id, 'TEACHER', 'PUPIL');
							break;
						}
					}
					break;
				}

			}
		}
		//проверяет, есть ли уже такой общий предмет
		function responsesubject() {
			$answer = $this->table->responseSubjectName($_POST['name'], $_POST['id'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}
		/*//добавлем новый общий предмет
		function addsubject() {
			$name = $_POST['name'];
			$this->table->addSubject($name);
		}
		//обновляем общий предмет
		function updatesubject() {
			$name = $_POST['name'];
			$id = $_POST['id'];
			$this->table->updateSubject($name, $id);
		}*/

		//проверяет, есть ли уже такой кабинет
		function responseroom() {
			$answer = $this->table->responseRoomName($_POST['name'], $_POST['id'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}
		/*//добавлем новый кабинет
		function addroom() {
			$name = $_POST['name'];
			$this->table->addRoom($name);
		}
		//обновляем кабинет
		function updateroom() {
			$name = $_POST['name'];
			$id = $_POST['id'];
			$this->table->updateRoom($name, $id);
		}*/

		//проверяет, есть ли уже такой тип оценки
		function responsetype() {
			$answer = $this->table->responseTypeName($_POST['name'], $_POST['id'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}
		/*//добавлем новый тип оценки
		function addtype() {
			$name = $_POST['name'];
			$this->table->addType($name);
		}
		//обновляем тип оценки
		function updatetype() {
			$name = $_POST['name'];
			$id = $_POST['id'];
			$this->table->updateType($name, $id);
		}*/


		/*//добавлем новость
		function addnews() {
			$admin = $this->session->userdata('id');

			$theme = $_POST['theme'];
			$text = $_POST['text'];
			$date = $_POST['date'];
			$this->table->addNews($theme, $date, $text, $admin);
		}
		//обновляем новость
		function updatenews() {
			$admin = $this->session->userdata('id');

			$theme = $_POST['theme'];
			$text = $_POST['text'];
			$date = $_POST['date'];
			$id = $_POST['id'];
			$this->table->updateNews($id, $theme, $date, $text, $admin);
		}*/
		//проверяет, есть ли уже такой класс
		function responseclass() {
			$answer = $this->table->responseClass($_POST['id'], $_POST['number'], $_POST['letter'], $_POST['year'], $_POST['status'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}

		/*//добавлем класс
		function addclass() {
			$number = $_POST['number'];
			$letter = $_POST['letter'];
			$year = $_POST['year'];
			$status = $_POST['status'];
			$teacher = $_POST['teacher'];
			$previous = $_POST['previous'];
			$this->table->addClass($number, $letter, $year, $status, $teacher, $previous);
		}
		//обновляем класс
		function updateclass() {
			$number = $_POST['number'];
			$letter = $_POST['letter'];
			$year = $_POST['year'];
			$status = $_POST['status'];
			$teacher = $_POST['teacher'];
			$id = $_POST['id'];
			$previous = $_POST['previous'];

			$this->table->updateClass($id, $number, $letter, $year, $status, $teacher, $previous);
		}*/

		//проверяет, есть ли уже такой логин
		function responseteacherlogin() {
			$answer = $this->table->responseTeacherLogin($_POST['id'], $_POST['login'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}

		/*//добавлем учителя
		function addteacher() {
			$name = $_POST['name'];
			$password = $_POST['password'];
			$login = $_POST['login'];
			$status = $_POST['status'];
			$this->table->addTeacher($name, $password, $login, $status, md5($password));
		}
		//обновляем учителя
		function updateteacher() {
			$name = $_POST['name'];
			$password = $_POST['password'];
			$login = $_POST['login'];
			$status = $_POST['status'];
			$id = $_POST['id'];
			$this->table->updateTeacher($id, $name, $password, $login, $status, md5($password));
		}*/


		function responseclassteacher() {
			$year = $_POST['year'];
			$teacher = $_POST['teacher'];
			$id = $_POST['id'];
			$answer = $this->table->responseClassTeacher($id, $year, $teacher)['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}


		/*function addyear() {
			$year_start = $_POST['year_start'];
			$year_finish = $_POST['year_finish'];

			$first_start = $_POST['first_start'];
			$first_finish = $_POST['first_finish'];

			$second_start = $_POST['second_start'];
			$second_finish = $_POST['second_finish'];

			$third_start = $_POST['third_start'];
			$third_finish = $_POST['third_finish'];

			$forth_start = $_POST['forth_start'];
			$forth_finish = $_POST['forth_finish'];
			$this->table->addYearAndPeriods($year_start, $year_finish,
			$first_start, $first_finish, $second_start, $second_finish, $third_start,$third_finish, $forth_start, $forth_finish);
		}

		function updateyear() {
			$year_start = $_POST['year_start'];
			$year_finish = $_POST['year_finish'];

			$first_start = $_POST['first_start'];
			$first_finish = $_POST['first_finish'];

			$second_start = $_POST['second_start'];
			$second_finish = $_POST['second_finish'];

			$third_start = $_POST['third_start'];
			$third_finish = $_POST['third_finish'];

			$forth_start = $_POST['forth_start'];
			$forth_finish = $_POST['forth_finish'];
			$id = $_POST['id'];
			$this->table->updateYearAndPeriods($id, $year_start, $year_finish,
			$first_start, $first_finish, $second_start, $second_finish, $third_start,$third_finish, $forth_start, $forth_finish);
		}*/


		function responseclassprevious() {
			$previous = $_POST['previous'];
			$answer = $this->table->responseClassPrevious($previous)['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}

		//проверяет, есть ли уже такой логин
		function responsepupillogin() {
			$answer = $this->table->responsePupilLogin($_POST['id'], $_POST['login'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}

		/*//добавлем учащегося
		function addpupil() {
			$name = $_POST['name'];
			$password = $_POST['password'];
			$login = $_POST['login'];
			$status = $_POST['status'];
			$address = $_POST['address'];
			$phone = $_POST['phone'];
			$birthday = $_POST['birthday'];

			$class_id = $this->session->userdata('class_id');
			$this->table->addPupil($name, $password, $login, $status, md5($password), $address, $phone, $birthday, $class_id);
		}
		//обновляем учащегося
		function updatepupil() {
			$name = $_POST['name'];
			$password = $_POST['password'];
			$login = $_POST['login'];
			$status = $_POST['status'];
			$address = $_POST['address'];
			$phone = $_POST['phone'];
			$id = $_POST['id'];
			$birthday = $_POST['birthday'];
			$this->table->updatePupil($id, $name, $password, $login, $status, md5($password), $address, $phone, $birthday);
		}*/


		function responsesubjectsclass() {
			$class_id = $this->session->userdata('class_id');
			$answer = $this->table->responseSubjectsClass($_POST['id'], $_POST['teacher'], $_POST['subject'], $class_id)['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}

		/*function addsubjectsclass() {
			$teacher = $_POST['teacher'];
			$subject = $_POST['subject'];
			$class_id = $this->session->userdata('class_id');
			$this->table->addSubjectsClass($teacher, $subject, $class_id);
		}

		function updatesubjectsclass() {
			$teacher = $_POST['teacher'];
			$subject = $_POST['subject'];
			$id = $_POST['id'];
			$class_id = $this->session->userdata('class_id');
			$this->table->updateSubjectsClass($id, $teacher, $subject, $class_id);
		}*/

		function responsetimetable() {
			$class_id = $this->session->userdata('class_id');
			$answer = $this->table->responseTimetable($_POST['id'], $_POST['time'], $_POST['day'], $class_id)['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}


		/*function addtimetable() {
			$time = $_POST['time'];
			$subject = $_POST['subject'];
			$day = $_POST['day'];
			$room = $_POST['room'];
			$this->table->addTimetable($time, $subject, $day, $room);
		}

		function updatetimetable() {
			$time = $_POST['time'];
			$subject = $_POST['subject'];
			$day = $_POST['day'];
			$room = $_POST['room'];
			$id = $_POST['id'];
			$this->table->updateTimetable($id, $time, $subject, $day, $room);
		}*/

		function responseyear() {
			$answer = $this->table->responseYear($_POST['id'],  date('Y', strtotime($_POST['yearstart'])),  date('Y', strtotime($_POST['yearfinish'])))['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;
		}

		function search() {
			$search = $_POST['search'];
			$role = $this->session->userdata('role');
			switch($role) {
					case 4: {
						$contacts = $this->table->getSearchTeachers($search);
						break;
					}
					case 1: case 3: {
						$contacts = $this->table->getSearchPupils($search);
						break;
					}
				}
			if(count($contacts) == 0) {
				echo "Поиск не дал результатов";
			} else {
				foreach($contacts as $row) {
					echo "<a href='#'><span id='name'>".$row['NAME']."</span><span hidden id='id'>".$row['ID']."</span></a></br>";
				}
			}
		}

		function addmessage() {
			$role = $this->session->userdata('role');
			$user = $this->session->userdata('id');
			$text = $_POST['text'];
			$id = $_POST['id'];
			date_default_timezone_set('Europe/Moscow');
			$date = date('Y-m-d H:i:s');
			switch($role) {
				case 4: {
					$this->table->addMessage($user, $id, $text, $date, 'PUPIL', 'TEACHER');
					break;
				}
				case 1: case 3: {
					$message_id = $this->table->addMessage($user, $id, $text, $date, 'TEACHER', 'PUPIL');

					$json = array("ТекстСообщения" => $text, "ДатаСообщения" => $date, "УчительИд" => $user, "Ид" => $message_id, "ТипСообщения" => 1, "Прочтено" => 0);

					$this->load->library('gcm');
				    $this->gcm->send($id, $json, "message");

					break;
				}
			}



				/*$subject = $this->table->getSubjectNameByLessonId($lesson_id)['SUBJECT_NAME'];
				$type = $this->table->getTypeById($type)['TYPE_NAME'];
				$message = "Новая оценка ".$mark." "."(".$type.")"." по предмету ".$subject;


				$result = $this->table->getLessonById($lesson_id);
				$lesson_date = $result['LESSON_DATE'];
				$time_id = $result['TIME_ID'];
				$day_of_week = date('N', strtotime($lesson_date));

				$json = array("Текст" => $message, "День" => $lesson_date, "ВремяИд" => $time_id, "ДеньНедели" => $day_of_week);*/
		}


		function readmessage($id) {
			$role = $this->session->userdata('role');
			switch($role) {
				case 4: {
					$this->table->readMessage($id, 'PUPIL', 'TEACHER');
					break;
				}
				case 1: case 3: {
					$this->table->readMessage($id, 'TEACHER', 'PUPIL');
					break;
				}
			}
		}


		function readconversation($id) {
			$user = $this->session->userdata('id');
			$role = $this->session->userdata('role');
			switch($role) {
				case 4: {
					$this->table->readConversation($user, $id, 'PUPIL', 'TEACHER');
					break;
				}
				case 1: case 3: {
					$this->table->readConversation($user, $id, 'TEACHER', 'PUPIL');
					break;
				}
	    	}
		}


		function changeprogress() {
			$mark = $_POST['mark'];
			$pupil_id = $_POST['pupil_id'];
			$subject_id = $_POST['subject_id'];
			$period = $_POST['period'];
			$class_id = $_POST['class_id'];
			$this->table->changeProgress($pupil_id, $subject_id, $period, $class_id, $mark);


			$this->load->library('gcm');
			if($mark != "") {

				$progress = $this->table->getPupilProgressMark($pupil_id, $subject_id, $period, $class_id, $mark);
				$json = array("ПредметИд" => $subject_id, "Оценка" => $mark, "ПериодИд" => $progress['PERIOD_ID'], "Ид" => $progress['PROGRESS_ID']);

				$this->gcm->send($pupil_id, $json, "progress");

			} else {


			}

		}

		function responselesson() {
			/*$answer = $this->table->responseLesson($_POST['id'], $_POST['date'], $_POST['time'], $_POST['subject'])['COUNT'];
			if($answer > 0) {
				echo true;
			}
			else echo false;*/

			$id = $_POST['id'];
			$date = $_POST['date'];
			$subject = $_POST['subject'];
			$time = $_POST['time'];
			echo $this->table->responseLesson($id, $date, $time, $subject);
		}

		function changeattendance() {
			$pass = $_POST['pass'];
			$pupil_id = $_POST['pupil_id'];
			$lesson_id = $_POST['lesson_id'];
			$attendance_id = $_POST['attendance'];
			$this->table->changeAttendance($pupil_id, $lesson_id, $attendance_id, $pass);
		}


		function changelessonstatus() {
			$lesson_id = $_POST['lesson_id'];
			$status = $_POST['status'];
			$this->table->changeLessonStatus($lesson_id, $status);
		}


		function changemark() {
			$mark = $_POST['mark'];
			$pupil_id = $_POST['pupil_id'];
			$lesson_id = $_POST['lesson_id'];
			$achievement_id = $_POST['achievement'];
			$type = $_POST['type'];
			$this->table->changeAchievement($pupil_id, $lesson_id, $achievement_id, $mark, $type);


			if(!(isset($achievement_id) && $achievement_id != "")) {
				$subject = $this->table->getSubjectNameByLessonId($lesson_id)['SUBJECT_NAME'];
				$type = $this->table->getTypeById($type)['TYPE_NAME'];
				$message = "Новая оценка ".$mark." "."(".$type.")"." по предмету ".$subject;


				$result = $this->table->getLessonById($lesson_id);
				$lesson_date = $result['LESSON_DATE'];
				$time_id = $result['TIME_ID'];
				$day_of_week = date('N', strtotime($lesson_date));

				$json = array("Текст" => $message, "День" => $lesson_date, "ВремяИд" => $time_id, "ДеньНедели" => $day_of_week);


				$this->load->library('gcm');
				$this->gcm->send($pupil_id, $json, "lesson");
			}
		}

		function changenote() {
			$note = $_POST['note'];
			$pupil_id = $_POST['pupil_id'];
			$lesson_id = $_POST['lesson_id'];
			$note_id = $_POST['note_id'];
			$this->table->changeNote($pupil_id, $lesson_id, $note_id, $note);
		}




	}
?>