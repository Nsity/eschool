<?php
	
	class Teacher extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->model('teachermodel', 'teacher');
			$this->load->model('tablemodel', 'tablemodel');
			$this->load->library("roleenum");
			//$this->load->library('javascript');
		}

		function _remap($method, $params = array()) {
			$login = $this->session->userdata('login');
			$role = $this->session->userdata('role');
			$roleEnum = $this->roleenum;

			if(isset($login) && isset($role) && ($role == Roleenum::ClassTeacher || $role == Roleenum::Teacher)) {
				$data['role'] = $role;
				$data['mainlogin'] = $login;

				$pageTitles = array(
					'pupils' => "Список учащихся",
					'subjects' => "Список предметов в классе",
					'journal' => "Журнал",
					'progress' => "Итоговые оценки",
					'timetable' => "Расписание",
					'lessons' => "Список учебных занятий",
					'statistics' => "Статистика",
					'pupil' => "Учащийся",
					'subject' => "Предмет в классе",
					'timetableitem' => "Предмет в расписании", 
					'lesson' => "Учебное занятие",
					'lessonpage' => "Учебное занятие",
				);

				if(array_key_exists($method, $pageTitles)) {
					$data['title'] = $pageTitles[$method];
				}

				$this->load->view('header', $data);
				
				if (method_exists($this, $method)) {
					call_user_func_array(array($this, $method), $params);
				} else {
					redirect(base_url()."teacher/journal");
				}

				$this->load->view('footer');
			}
			else {
				redirect('auth/logout');
			}

		}

		function pupils($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."teacher/pupils");
					} else redirect(base_url()."teacher/pupils?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}
			$class_id = $login = $this->session->userdata('class_id');
			$num = 10;

			$config['total_rows'] = $this->teacher->totalPupils($class_id, $search);
			$config['base_url'] = base_url()."teacher/pupils";
			$config['per_page'] = $num;
			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);
			$query = $this->teacher->getPupils($num, $offset * $num - $num, $class_id, $search);
			$data['pupils'] = array();
			if($query) {
				$data['pupils'] =  $query;
			}
			$this->load->view("teacher/pupilsview", $data);
		}


		private function _getPupilProgress($id, $start, $finish) {
			$result = array();
			$class_id = $login = $this->session->userdata('class_id');
			$subjects = $this->teacher->getAllSubjectsClass($class_id);
			$i = 0;
			foreach($subjects as $subject) {
				$result[$i]["subject"] = $subject["SUBJECT_NAME"];
				$subject_id = $subject["SUBJECTS_CLASS_ID"];
				$marks =  $this->teacher->getPupilMarksForSubject($id, $subject_id, $start, $finish);
				if(count($marks) == 0) {
					$result[$i]["marks"] = array();
				} else {
					$z = 0;
					foreach($marks as $mark) {
						$result[$i]["marks"][$z]["mark"] = $mark['ACHIEVEMENT_MARK'];
						if(isset($mark['TYPE_NAME'])) {
						$result[$i]["marks"][$z]["type"] = $mark['TYPE_NAME']." (".date('d.m', strtotime($mark['LESSON_DATE'])).")";
						} else {
							$result[$i]["marks"][$z]["type"] = date('d.m', strtotime($mark['LESSON_DATE']));
						}
						$z++;
					}
				}
				$passes = $this->teacher->getPupilPassForSubject($id, $subject_id, $start, $finish);
				if(count($passes) > 0) {
					foreach($passes as $pass) {
						if($pass['ATTENDANCE_PASS'] == 'н') {
							$result[$i]["pass"]['н'] = $pass['COUNT'];
						}
						if($pass['ATTENDANCE_PASS'] == 'б') {
							$result[$i]["pass"]['б'] = $pass['COUNT'];
						}
						if($pass['ATTENDANCE_PASS'] == 'у') {
							$result[$i]["pass"]['у'] = $pass['COUNT'];
						}

					}
				} else {
					$result[$i]["pass"] = null;
				}
				$i++;
			}
			return $result;
		}



		function pupil($id = null, $progress = null, $period = null) {
			if(isset($_POST['save'])) {
				$name = $_POST['inputName'];
				$password = $_POST['inputPassword'];
				$login = $_POST['inputLogin'];
				$status = $_POST['inputStatus'];
				$address = $_POST['inputAddress'];
				$phone = $_POST['inputPhone'];
				$birthday = $_POST['inputBirthday'];
				$class_id = $this->session->userdata('class_id');
				if(isset($id)) {
					$this->tablemodel->updatePupil($id, $name, $password, $login, $status, md5($password), $address, $phone, $birthday);
				} else {
					$this->tablemodel->addPupil($name, $password, $login, $status, md5($password), $address, $phone, $birthday, $class_id);
				}
				redirect(base_url()."teacher/pupils");
			} else {
			if(isset($id)) {
				$class_id = $login = $this->session->userdata('class_id');
				$pupil = $this->teacher->getPupilById($id, $class_id);
				if(isset($pupil)) {
					if(isset($progress)) {
						$borders = $this->teacher->getBorders($class_id);
						if(!isset($period)) {
							redirect(base_url()."teacher/pupil/".$id."/progress/".$borders[0]['PERIOD_ID']);
						} else {
							if(isset($_POST['period'])) {
								$period = $_POST['period'];
								redirect(base_url()."teacher/pupil/".$id."/progress/".$period);
							}

							foreach ($borders as $border) {
								if($period == $border['PERIOD_ID']) {
									$start = $border['PERIOD_START'];
									$finish = $border['PERIOD_FINISH'];
								}
							}
							//успеваемость учащегося
							$data['periods'] = $borders;
							$data['progress'] = $this->_getPupilProgress($id, $start, $finish);
							$data['name'] = $pupil['PUPIL_NAME'];
							$this->load->view("teacher/pupilprogressview", $data);
						}
					} else {
						//редактирование учащегося
						$data['name'] = $pupil['PUPIL_NAME'];
						$data['login'] = $pupil['PUPIL_LOGIN'];
						$data['password'] = $pupil['PUPIL_PASSWORD'];
						$data['address'] = $pupil['PUPIL_ADDRESS'];
						$data['phone'] = $pupil['PUPIL_PHONE'];
						$data['birthday'] = $pupil['PUPIL_BIRTHDAY'];
						$data['status'] = $pupil['PUPIL_STATUS'];
						$data['id'] = $pupil['PUPIL_ID'];
						$data['title'] = 'Редактирование учащегося';
						$this->load->view("blankview/blankpupilview", $data);
					}
				} else {
					//ошибка
					$data['error'] = "Такого учащегося не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				//добавление учащегося
				$data['title'] = 'Добавление нового учащегося';
				$this->load->view("blankview/blankpupilview", $data);
			}
			}
		}



		function subjects($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."teacher/subjects");
					} else redirect(base_url()."teacher/subjects?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}
			$class_id = $login = $this->session->userdata('class_id');
			$num = 10;

			$config['total_rows'] = $this->teacher->totalSubjectsClass($class_id, $search);
			$config['base_url'] = base_url()."teacher/subjects";
			$config['per_page'] = $num;
			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}
			$this->pagination->initialize($config);
			$query = $this->teacher->getSubjectsClass($num, $offset * $num - $num, $class_id, $search);
			$data['subjects'] = array();
			if($query) {
				$data['subjects'] =  $query;
			}
			$this->load->view("teacher/subjectsview", $data);
		}


		function subject($id = null) {
			$data['teachers'] = $this->teacher->getTeachers();
			$data['subjects'] = $this->teacher->getSubjects();
			if(isset($_POST['save'])) {
				$teacher = $_POST['inputTeacher'];
				$subject = $_POST['inputSubject'];
				$class_id = $login = $this->session->userdata('class_id');
				if(isset($id)) {
					$this->tablemodel->updateSubjectsClass($id, $teacher, $subject, $class_id);
				} else {
					$this->tablemodel->addSubjectsClass($teacher, $subject, $class_id);
				}
				redirect(base_url()."teacher/subjects");
			} else {
			if(isset($id)) {
				$class_id = $login = $this->session->userdata('class_id');
				$subject = $this->teacher->getSubjectById($id, $class_id);
				if(isset($subject)) {
					$data['teacher_name'] = $subject['TEACHER_NAME'];
					$data['teacher_id'] = $subject['TEACHER_ID'];
					$data['subject_name'] = $subject['SUBJECT_NAME'];
					$data['subject_id'] = $subject['SUBJECT_ID'];
					$data['id'] = $subject['SUBJECTS_CLASS_ID'];
					$data['title'] = 'Редактирование предмета в классе';
					$this->load->view("blankview/blanksubjectsclassview", $data);

				} else {
					//ошибка
					$data['error'] = "Такого предмета в классе не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				$data['title'] = 'Добавление нового предмета в классе';
				$this->load->view("blankview/blanksubjectsclassview", $data);
			}
			}
		}


		function timetable($day = null) {
			if($day != null && ($day == 1 || $day == 2 || $day == 3 || $day == 4 || $day == 5 || $day == 6)) {
				$class_id = $login = $this->session->userdata('class_id');
				$data['timetable'] = $this->teacher->getTimetable($class_id, $day);
				$this->load->view("teacher/timetableview", $data);
			}
			else {
				//ошибка
				$data['error'] = "Расписания не существует. Вернитесь обратно";
				$this->load->view("errorview", $data);
			}
		}


		function timetableitem($day = null, $id = null) {
			if(isset($_POST['save'])) {
				$time = $_POST['inputTime'];
				$subject = $_POST['inputSubject'];
				$room = $_POST['inputRoom'];
				if(isset($id)) {
					$this->tablemodel->updateTimetable($id, $time, $subject, $day, $room);
				} else {
					$this->tablemodel->addTimetable($time, $subject, $day, $room);
				}
				redirect(base_url()."teacher/timetable/".$day);
			} else {
			$dayName = "";
			switch($day) {
				case '1': $dayName = '<strong>понедельник</strong>'; break;
				case '2': $dayName = '<strong>вторник</strong>'; break;
				case '3': $dayName = '<strong>среду</strong>'; break;
				case '4': $dayName = '<strong>четверг</strong>'; break;
				case '5': $dayName = '<strong>пятницу</strong>'; break;
				case '6': $dayName = '<strong>субботу</strong>'; break;
			}


			$class_id = $login = $this->session->userdata('class_id');
			$data['times'] = $this->teacher->getTimes();
			$data['subjects'] = $this->teacher->getAllSubjectsClass($class_id);
			$data['rooms'] = $this->teacher->getRooms();
			if(isset($id) && isset($day)) {
				$timetable = $this->teacher->getTimetableById($id, $class_id);
				if(isset($timetable)) {
					$data['time_id'] = $timetable['TIME_ID'];
					$data['subject_id'] = $timetable['SUBJECTS_CLASS_ID'];
					$data['room_id'] = $timetable['ROOM_ID'];
					$data['id'] = $timetable['TIMETABLE_ID'];
					$data['title'] = 'Редактирование предмета в расписании на '.$dayName;
					$this->load->view("blankview/blanktimetableview", $data);

				} else {
					//ошибка
					$data['error'] = "Такого предмета в расписании не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				if(isset($day)) {
					$data['title'] = 'Добавление нового предмета в расписание на '.$dayName;
					$this->load->view("blankview/blanktimetableview", $data);
				} else {
					//ошибка
					$data['error'] = "Расписание на день не выбрано. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			}
			}
		}



		function progress($class_id = null, $subject_id = null) {
			$id = $login = $this->session->userdata('id');
			$classes = $this->teacher->getClasses($id);
			if($class_id == null || $subject_id == null) {
				if(count($classes) > 0) {
					$class_id = $classes[0]['CLASS_ID'];
					$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
					if(count($subjects) > 0) {
						$subject_id = $subjects[0]['SUBJECTS_CLASS_ID'];
						redirect(base_url()."teacher/progress/".$class_id."/".$subject_id);
					} else {
						//ошибка
						$data['error'] = "Ошибка";
						$this->load->view("errorview", $data);
					}
				} else {
					//ошибка
					$data['error'] = "Вы не преподаете ни в одном классе";
					$this->load->view("errorview", $data);
				}
			} else {
				if(isset($_POST["class"])) {
					$class_id = $_POST['class'];
					$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
					if(count($subjects) > 0) {
						$subject_id = $subjects[0]['SUBJECTS_CLASS_ID'];
						redirect(base_url()."teacher/progress/".$class_id."/".$subject_id);
					} else {
						//ошибка
						$data['error'] = "Ошибка";
						$this->load->view("errorview", $data);
					}
				}
				if(isset($_POST["subject"])) {
					$subject_id = $_POST['subject'];
					redirect(base_url()."teacher/progress/".$class_id."/".$subject_id);
				}
				$data['classes'] = $classes;
				$data['subjects'] = $this->teacher->getSubjectsForClass($class_id, $id);
				$pupils = $this->teacher->getPupilsForClass($class_id);
				$resultArr = array();
				$i = 0;
				$borders = $this->teacher->getBorders($class_id);
				foreach($pupils as $pupil) {
					$pupil_id = $pupil['PUPIL_ID'];
					$resultArr[$i]["pupil_id"] = $pupil_id;
					$resultArr[$i]["pupil_name"] = $pupil['PUPIL_NAME'];
					//$marks = $this->teacher->getPupilMarks($pupil_id, $class_id, $subject_id);
					foreach($borders as $border) {
						$period_id = $border['PERIOD_ID'];
						$start = $border["PERIOD_START"];
						$finish = $border["PERIOD_FINISH"];
						$resultArr[$i][$border['PERIOD_NAME']]["mark"] =
											$this->teacher->getPupilProgressMark($pupil_id, $subject_id, $period_id)['MARK'];
						$average = $this->teacher->getAverageMarkForPupil($pupil_id, $subject_id, $start, $finish);
						$resultArr[$i][$border['PERIOD_NAME']]["average"] = number_format($average['MARK'],1);
					}
					/*foreach($marks as $mark) {
						$resultArr[$i][$mark['PERIOD_NAME']]["mark"] = $mark['PROGRESS_MARK'];
						$start = $mark["PERIOD_START"];
						$finish = $mark["PERIOD_FINISH"];
						$average = $this->teacher->getAverageMarkForPupil($pupil_id, $subject_id, $start, $finish);
						$resultArr[$i][$mark['PERIOD_NAME']]["average"] = number_format($average['MARK'],1);
					}*/

					$i++;
				}
				$data['marks'] = $resultArr;
				//$data['stat'] = $this->_getProgressStatistics($class_id, $subject_id, $borders);
				$this->load->view("teacher/progressview", $data);

			}
		}

		private function _getProgressStatistics($class_id, $subject_id, $borders) {
			$result = array();
			$i = 0;
			foreach($borders as $border) {
				$period_id = $border['PERIOD_ID'];
				$period_name = $border['PERIOD_NAME'];
				$result[$i]["period"] = $period_name;
				for ($y = 2; $y <=5; $y++) {
					$result[$i][$y] = $this->teacher->getCountProgressMark($subject_id, $period_id, $y)['COUNT'];
				}
				if($result[$i]["5"] + $result[$i]["4"] + $result[$i]["3"]+ $result[$i]["2"] != 0) {
					$result[$i]["ach"] = round(($result[$i]["5"] + $result[$i]["4"] + $result[$i]["3"]) /
				($result[$i]["5"] + $result[$i]["4"] + $result[$i]["3"]+ $result[$i]["2"]) *100);
				} else {
					$result[$i]["ach"] = 0;
				}
				if( $result[$i]["5"] + $result[$i]["4"] + $result[$i]["3"]+ $result[$i]["2"] != 0) {
					$result[$i]["quality"] = round(($result[$i]["5"] + $result[$i]["4"]) /
				($result[$i]["5"] + $result[$i]["4"] + $result[$i]["3"]+ $result[$i]["2"]) *100);
				} else {
					$result[$i]["quality"] = 0;
				}

				$i++;
			}

			return $result;
		}



		function lessons($subject = null, $offset = 1) {
			$this->schedule();
			$id = $login = $this->session->userdata('id');
			$info = $this->teacher->getSubjectInfo($subject, $id);
			if(!isset($info)) {
				//ошибка
				$data['error'] = "У вас нет доступа к этой странице. Вернитесь обратно";
				$this->load->view("errorview", $data);
			}
			else {
				$search = "";
				if(isset($_GET['submit'])) {
					if(isset($_GET['search'])) {
						$search = urldecode($_GET['search']);
						$data['search'] = $search;
						if ($search == "") {
							redirect(base_url()."teacher/lessons/".$subject);
							} else redirect(base_url()."teacher/lessons/".$subject."?search=".$search);
					}
				}
				if(isset($_GET['search'])) {
					$search = $_GET['search'];
					$data['search'] = $search;
				}
				$data['subject'] = $info['SUBJECT_NAME'];
				$data['class'] = $info['CLASS_NUMBER']." ".$info['CLASS_LETTER']." (".$info['YEAR_START']." - ".$info['YEAR_FINISH']." гг.)";
			/*$id = $login = $this->session->userdata('id');
			$lesson = $this->teacher->checkLessonsForTeacher($subject, $id);
			if(isset($lesson) && $lesson['COUNT'] > 0) {*/
			$num = 10;
			$config['total_rows'] = $this->teacher->totalLessons($subject, $search);
			$config['base_url'] = base_url()."teacher/lessons/".$subject;
			$config['per_page'] = $num;
			$config['uri_segment'] = 4;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);
			$query = $this->teacher->getLessons($num, $offset * $num - $num, $subject, $search);
			$data['lessons'] = array();
			$data['files'] = array();
			$arrFiles = array();
			if($query) {
				$data['lessons'] =  $query;
				foreach($query as $lesson) {
					$lesson_id = $lesson['LESSON_ID'];
					//$files = $this->teacher->getFiles($lesson_id);
					//$arrFiles[$lesson_id] = $files;
				}
				//$data['files'] =  $arrFiles;
			}
			$this->load->view("teacher/lessonsview", $data);
			}
		}


		function upload($file, $id) {
			//создаем папку для пользователя
			//$user = $login = $this->session->userdata('id');
			$dir = "/Applications/MAMP/htdocs/ischool/files/";
			/*if(!is_dir($dir)) {
				mkdir($dir, 0700);
			}*/
			$filename = $file['name'];
			$ext = substr($file['name'], 1 + strrpos($file['name'], "."));
			$size = $file['size'];
			$name =  preg_replace("/\.[^.]+$/", "", $filename);
			$file_id = $this->tablemodel->addFile($size, $ext, $name, $id);

			if(move_uploaded_file($file['tmp_name'], $dir.$file_id.".".$ext)) {
				return $file_id;
			} else {
				return null;
			}

			/*$filename = $file['tmp_name'];
			$ext = substr($file['name'], 1 + strrpos($file['name'], "."));
			if (filesize($filename) > $max_image_size) {
				$error = 'Error: File size > 64K.';
				} elseif (!in_array($ext, $valid_types)) {
				   $error = 'Error: Invalid file type.';
				} else {
				&& ($size[1] < $max_image_height)) {
				if (@move_uploaded_file($filename, "/www/htdocs/upload/")) {
					echo 'File successful uploaded.';
				} else {
					echo 'Error: moving fie failed.';
				}
			} else {
				echo 'Error: invalid image properties.';
			}
		}*/
		}

		function lesson($subject = null, $id = null) {
			if(isset($_POST['save'])){
				/*echo "<pre>";
				print_r($_FILES);
				echo "</pre>";*/

				$theme = $_POST['inputTheme'];
				$date = $_POST['inputDate'];
				$time = $_POST['inputTime'];
				$homework = $_POST['inputHomework'];
				$status = $_POST['inputStatus'];

				if(isset($id)) {
					$this->tablemodel->updateLesson($id, $subject, $theme, $date, $time, $homework, $status);
				} else {
					$id = $this->tablemodel->addLesson($subject, $theme, $date, $time, $homework, $status);
				}

				//$this->load->library('../controllers/table');

				//загружаем файлы
				/*if(isset($_FILES['inputFile1']) && $_FILES['inputFile1']['error'] == 0) {
					$file1 = $this->upload($_FILES['inputFile1'], $id);
				}
				if(isset($_FILES['inputFile2']) && $_FILES['inputFile2']['error'] == 0) {
					$file2 = $this->upload($_FILES['inputFile2'], $id);
				}
				if(isset($_FILES['inputFile3']) && $_FILES['inputFile3']['error'] == 0) {
					$file3 = $this->upload($_FILES['inputFile3'], $id);
				}*/
				$back = $_POST['inputURL'];
				if(isset($back)) {
					redirect($back);
				} else
					redirect(base_url()."teacher/lessons/".$subject);
			} else {
				$this->schedule();
			$data['times'] = $this->teacher->getTimes();
			if(isset($subject)) {
				if(isset($id)) {
					$user = $login = $this->session->userdata('id');
					$lesson = $this->teacher->getLessonById($id, $subject, $user);
					if(isset($lesson)) {
						$data['theme'] = $lesson['LESSON_THEME'];
						$data['date'] = $lesson['LESSON_DATE'];
						$data['time_id'] = $lesson['TIME_ID'];
						$data['homework'] = $lesson['LESSON_HOMEWORK'];
						$data['status'] = $lesson['LESSON_STATUS'];
						$data['id'] = $lesson['LESSON_ID'];
						$data['title'] = 'Редактирование учебного занятия';
						if (!empty($_SERVER['HTTP_REFERER'])) {
							$data['back'] = $_SERVER['HTTP_REFERER'];
						}
						$this->load->view("blankview/blanklessonview", $data);
					} else {
						//ошибка
						$data['error'] = "Такого урока не существует. Вернитесь обратно";
						$this->load->view("errorview", $data);
					}
				} else {
					$data['title'] = 'Добавление нового учебного занятия';
					if (!empty($_SERVER['HTTP_REFERER'])) {
						$data['back'] = $_SERVER['HTTP_REFERER'];
					}
					$this->load->view("blankview/blanklessonview", $data);
				}
			} else {
				//ошибка
				$data['error'] = "Ошибка";
				$this->load->view("errorview", $data);
			}
			}
		}





		function classreport($period = null) {
			$class_id = $this->session->userdata('class_id');
			$borders = $this->teacher->getBorders($class_id);
			if(!isset($period)) {
				redirect(base_url()."teacher/classreport/".$borders[0]['PERIOD_ID']);
			} else {
				if(isset($_POST['period'])) {
					$period = $_POST['period'];
					redirect(base_url()."teacher/classreport/".$period);
				}
				$data['periods'] = $borders;
				//успеваемость

				$pupils = $this->teacher->getAllPupils($class_id);
				$subjects = $this->teacher->getAllSubjectsClass($class_id);
				if(count($pupils) > 0) {
					$result = array();
					$average = array();
					$i = 0;
					foreach($pupils as $pupil) {
						$pupil_id = $pupil['PUPIL_ID'];
						$result[$i]["pupil"] = $pupil['PUPIL_NAME'];
						$y = 0;
						foreach($subjects as $subject) {
							$subject_id = $subject['SUBJECTS_CLASS_ID'];
							$result[$i]['mark'][$y] = $this->teacher->getPupilProgressForSubject($pupil_id, $subject_id, $period)['PROGRESS_MARK'];

							$average[$y] = number_format($this->teacher->getAverageForSubject($class_id, $subject_id, $period)['MARK'],1);

							$y++;

						}
						$i++;
					}
					$data['progress'] = $result;
					$data['average'] = $average;
				} else {
					$data['progress'] = array();
				}
				$data['subjects'] = $subjects;
				$this->load->view("teacher/classreportview", $data);
			}
		}

		function _getJournal($class_id, $lessons) {
			$pupils = $this->teacher->getPupilsForClass($class_id);
			//$lessons = $this->teacher->getLessons($num, $offset * $num - $num, $subject_id);
			$result = array();
			$i = 0;
			foreach($pupils as $pupil) {
				$pupil_id = $pupil['PUPIL_ID'];
				$result[$i]["pupil_id"] = $pupil_id;
				$result[$i]["pupil_name"] = $pupil['PUPIL_NAME'];
				$y = 0;
				foreach($lessons as $lesson) {
					$lesson_id = $lesson['LESSON_ID'];
					$marks =  $this->teacher->getPupilMarksForLesson($pupil_id, $lesson_id);
					$z = 0;
					if(count($marks) > 0) {
						foreach($marks as $mark) {
							$result[$i]["lessons"][$y]["marks"][$z]["mark"] = $mark['ACHIEVEMENT_MARK'];
							$result[$i]["lessons"][$y]["marks"][$z]["type"] = $mark['TYPE_NAME'];
							$z++;
						}
					} else {
						$result[$i]["lessons"][$y]["marks"] = array();
					}

					$pass = $this->teacher->getPupilPassForLesson($pupil_id, $lesson_id);
					if(isset($pass)) {
						$result[$i]["lessons"][$y]['pass'] = $pass['ATTENDANCE_PASS'];
					} else {
						$result[$i]["lessons"][$y]['pass'] = null;
					}
					$y++;
				}
				$i++;
			}
			return $result;
		}



		function journal($class_id = null, $subject_id = null, $offset = 1) {
			$this->schedule();
			$num = 12;
			$id = $login = $this->session->userdata('id');
			$classes = $this->teacher->getClasses($id);
			if($class_id == null || $subject_id == null) {
				if(count($classes) > 0) {
					$class_id = $classes[0]['CLASS_ID'];
					$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
					if(count($subjects) > 0) {
						$subject_id = $subjects[0]['SUBJECTS_CLASS_ID'];
						redirect(base_url()."teacher/journal/".$class_id."/".$subject_id);
					} else {
						//ошибка
						$data['error'] = "Вы не преподаете ни одного предмета в классе";
						$this->load->view("errorview", $data);
					}
				} else {
					//ошибка
					$data['error'] = "Вы не преподаете ни в одном классе";
					$this->load->view("errorview", $data);
				}
			} else {
				if(isset($_POST["class"])) {
					$class_id = $_POST['class'];
					$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
					if(count($subjects) > 0) {
						$subject_id = $subjects[0]['SUBJECTS_CLASS_ID'];
						redirect(base_url()."teacher/journal/".$class_id."/".$subject_id);
					} else {
						//ошибка
						$data['error'] = "Ошибка";
						$this->load->view("errorview", $data);
					}
				}
				if(isset($_POST["subject"])) {
					$subject_id = $_POST['subject'];
					redirect(base_url()."teacher/journal/".$class_id."/".$subject_id);
				}
				$data['classes'] = $classes;
				$data['subjects'] = $this->teacher->getSubjectsForClass($class_id, $id);

				$lessons = $this->teacher->getLessons($num, $offset * $num - $num, $subject_id, "");
				$data['lessons'] = $lessons;

				$config['total_rows'] = $this->teacher->totalLessons($subject_id, "");
				$config['base_url'] = base_url()."teacher/journal/".$class_id."/".$subject_id;
				$config['per_page'] = $num;
				$config['uri_segment'] = 5;
				$this->pagination->initialize($config);

				$data['result'] = $this->_getJournal($class_id, $lessons);
				$this->load->view("teacher/journalview", $data);

			}
		}


		function attendance() {
			$class_id = $login = $this->session->userdata('class_id');
		}



		private function _getLessonPage($lesson, $subject) {
			$result = array();
			$pupils = $this->teacher->getPupilsForClass($this->teacher->getClassBySubject($subject)['CLASS_ID']);
			$i = 0;
			foreach ($pupils as $pupil) {
				$pupil_id = $pupil['PUPIL_ID'];
				$result[$i]['pupil_id'] = $pupil_id;
				$result[$i]['pupil_name'] = $pupil['PUPIL_NAME'];
				$marks = $this->teacher->getPupilMarksForLesson($pupil_id, $lesson);
				if(count($marks) == 0) {
					$result[$i]['marks'] = array();
				}  else {
					$y = 0;
					foreach($marks as $mark) {
						$result[$i]['marks'][$y]['mark'] = $mark['ACHIEVEMENT_MARK'];
						$result[$i]['marks'][$y]['type'] = $mark['TYPE_NAME'];
						$result[$i]['marks'][$y]['type_id'] = $mark['TYPE_ID'];
						$result[$i]['marks'][$y]['achievement'] = $mark['ACHIEVEMENT_ID'];
						$y++;
					}
				}
				$pass = $this->teacher->getPupilPassForLesson($pupil_id, $lesson);
				if(isset($pass)) {
					$result[$i]['pass_id'] = $pass['ATTENDANCE_ID'];
					$result[$i]['pass'] = $pass['ATTENDANCE_PASS'];
				} else {
					$result[$i]['pass_id'] = null;
					$result[$i]['pass'] = null;
				}

				$note = $this->teacher->getPupilNoteForLesson($pupil_id, $lesson);
				if(isset($note)) {
					$result[$i]['note_id'] = $note['NOTE_ID'];
					$result[$i]['note'] = $note['NOTE_TEXT'];
				} else {
					$result[$i]['note_id'] = null;
					$result[$i]['note'] = null;
				}
				$i++;
			}
			return $result;
		}


		function lessonpage($subject = null, $id = null) {
			if(isset($id) && isset($subject)) {
				$user = $login = $this->session->userdata('id');
				$lesson = $this->teacher->getLessonById($id, $subject, $user);
				if(isset($lesson)) {
					$data['theme'] = $lesson['LESSON_THEME'];
					$data['id'] = $lesson['LESSON_ID'];
					$data['date'] = $lesson['LESSON_DATE'];
					$data['time'] = date('H:i', strtotime($lesson['TIME_START']))." - ".date('H:i', strtotime($lesson['TIME_FINISH']));
					$data['homework'] = $lesson['LESSON_HOMEWORK'];
					$data['status'] = $lesson['LESSON_STATUS'];
					$data['class'] = $lesson['CLASS_NUMBER']." ".$lesson['CLASS_LETTER'];
					$data['subject'] = $lesson['SUBJECT_NAME'];
					//$data['files'] = $this->teacher->getFiles($id);
					$data['info'] = $this->_getLessonPage($id, $subject);
					$data['types'] = $this->teacher->getTypes();
					//$data['pupils'] = $this->teacher->getPupilsForClass($this->teacher->getClassBySubject($subject)['CLASS_ID']);
					$this->load->view("teacher/lessonpageview", $data);
				} else {
					//ошибка
					$data['error'] = "Такого урока не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
					}
			} else {
				//ошибка
				$data['error'] = "Ошибка";
				$this->load->view("errorview", $data);

			}

		}

		function statistics($class_id = null, $subject_id = null) {
			$id = $login = $this->session->userdata('id');
			$classes = $this->teacher->getClasses($id);
			if($class_id == null || $subject_id == null) {
				if(count($classes) > 0) {
					$class_id = $classes[0]['CLASS_ID'];
					$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
					if(count($subjects) > 0) {
						$subject_id = $subjects[0]['SUBJECTS_CLASS_ID'];
						redirect(base_url()."teacher/statistics/".$class_id."/".$subject_id);
					} else {
						//ошибка
						$data['error'] = "Ошибка";
						$this->load->view("errorview", $data);
					}
				} else {
					//ошибка
					$data['error'] = "Вы не преподаете ни в одном классе";
					$this->load->view("errorview", $data);
				}
			} else {
				if(isset($_POST["class"])) {
					$class_id = $_POST['class'];
					$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
					if(count($subjects) > 0) {
						$subject_id = $subjects[0]['SUBJECTS_CLASS_ID'];
						redirect(base_url()."teacher/statistics/".$class_id."/".$subject_id);
					} else {
						//ошибка
						$data['error'] = "Ошибка";
						$this->load->view("errorview", $data);
					}
				}
				if(isset($_POST["subject"])) {
					$subject_id = $_POST['subject'];
					redirect(base_url()."teacher/statistics/".$class_id."/".$subject_id);
				}
				$data['classes'] = $classes;
				$data['subjects'] = $this->teacher->getSubjectsForClass($class_id, $id);
				$borders = $this->teacher->getBorders($class_id);
				$data['stat'] = $this->_getProgressStatistics($class_id, $subject_id, $borders);
				$data['periods'] = $borders;
				$this->load->view("teacher/statisticsview", $data);
			}
		}


		function schedule() {
			$id = $login = $this->session->userdata('id');
			$today = date("Y-m-d");
			$classes = $this->teacher->getClassesByDate($today, $id);
			$result = array();
			foreach($classes as $class) {
				$class_id = $class['CLASS_ID'];
				$subjects = $this->teacher->getSubjectsForClass($class_id, $id);
				foreach($subjects as $subject) {
					$subject_id = $subject['SUBJECTS_CLASS_ID'];
					$timetable = $this->teacher->getTimetableForSubject($subject_id);
					foreach($timetable as $row) {
						$result[$row['DAYOFWEEK_ID']][$row['TIME_ID']]['subject'] = $subject['SUBJECT_NAME']." (".$class['CLASS_NUMBER']." ".$class['CLASS_LETTER'].")";
						$result[$row['DAYOFWEEK_ID']][$row['TIME_ID']]['time'] = date('H:i', strtotime($row['TIME_START']));
						$result[$row['DAYOFWEEK_ID']][$row['TIME_ID']]['class_id'] = $class['CLASS_ID'];
						$result[$row['DAYOFWEEK_ID']][$row['TIME_ID']]['subject_id'] = $subject_id;
					}
				}
			}
			$data['timetable'] = $result;
			$this->load->view("teacher/scheduleview", $data);
		}

		function news($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."teachers/news");
					} else redirect(base_url()."teachers/news?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}

			// Переменная хранит число сообщений выводимых на станице
			$num = 15;

			$id = $this->session->userdata('id');

			$config['total_rows'] = $this->teacher->totalNews($id, $search);
			$config['base_url'] = base_url()."teachers/news";
			$config['per_page'] = $num;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);

			$query = $this->teacher->getNews($num, $offset * $num - $num, $id, $search);
			$data['news'] = array();
			if($query) {
				$data['news'] =  $query;
			}
			$this->load->view("teacher/newsview", $data);
		}


		function newsitem($id = null) {
			if(isset($_POST['save'])) {
				$teacher = $this->session->userdata('id');
				$theme = $_POST['inputTheme'];
				$text = $_POST['inputText'];
				$date = $_POST['inputDate'];
				if(isset($id)) {
					$this->tablemodel->updateNews($id, $theme, $date, $text, $teacher);
				} else {
					$this->tablemodel->addNews($theme, $date, $text, $teacher);


					//news push
					$this->load->library('gcm');
					$json = array("Тема" => $theme);
					$pupils = $this->teacher->getPupilsFromAllClasses();

					foreach($pupils as $pupil) {
						$this->gcm->send($pupil['PUPIL_ID'], $json, "news");
					}
					//-----

				}
				redirect(base_url()."teacher/news");
			} else {
				if(isset($id)) {
					$teacher = $this->session->userdata('id');
					$news = $this->teacher->getNewsById($id, $teacher);
					if(isset($news)) {
						$data['date'] = $news['NEWS_TIME'];
						$data['id'] = $news['NEWS_ID'];
						$data['text'] = $news['NEWS_TEXT'];
						$data['theme'] = $news['NEWS_THEME'];
						$data['title'] = 'Редактирование новости';
						$this->load->view("blankview/blanknewsview", $data);
					} else {
					   //ошибка
						$data['error'] = "Такой новости не существует. Вернитесь обратно";
						$this->load->view("errorview", $data);
				}
				} else {
					$data['title'] = 'Добавление новой новости';
					$this->load->view("blankview/blanknewsview", $data);
				}
			}
		}



		function test1() {
			$this->load->library('unit_test');
			$test = array();
			$expected_result = $this->_getJournal(null, array());
			$test_name = 'Нулевой класс и пустой список учебных занятий';
			$this->unit->run($test, $expected_result, $test_name);
			echo $this->unit->report();
		}

		function test2() {
			$this->load->library('unit_test');
			$test = array(0 => array("pupil_id" => 26, "pupil_name" => "Бойцова Юлия", "lessons" => array (0 => array ("marks" => null, "pass" => "н"))), 1 => array ("pupil_id" => 28, "pupil_name" => "Бусова Анна", "lessons" => array(0 => array("marks" => array(0 => array("mark" => 5, "type" => "Сочинение")), "pass" => null))),  2 => array("pupil_id" => 2, "pupil_name" => "Морозова Анастасия", "lessons" => array(0 => array("marks" => null, "pass" => null))), 3 => array("pupil_id" => 27, "pupil_name" => "Пимурзина Виктория", "lessons" => array(0 => array("marks" => null, "pass" => null))));
			$expected_result = $this->_getJournal(3, $this->teacher->getLessons(1, 1, 26, ""));
			$test_name = 'Входные параметры заданы верно, при этом у каждого учащегося выставлены пропуски и поставлено не более одной оценки';
			$this->unit->run($test, $expected_result, $test_name);
			echo $this->unit->report();
		}

		function test3() {
			$this->load->library('unit_test');
			$test = array(0 => array("pupil_id" => 26, "pupil_name" => "Бойцова Юлия"), 1 => array ("pupil_id" => 28, "pupil_name" => "Бусова Анна"),  2 => array("pupil_id" => 2, "pupil_name" => "Морозова Анастасия"), 3 => array("pupil_id" => 27, "pupil_name" => "Пимурзина Виктория"));
			$expected_result = $this->_getJournal(3, array());
			$test_name = 'Задан правильный идентификатор класса, но список учебных занятий пуст';
			$this->unit->run($test, $expected_result, $test_name);
			echo $this->unit->report();
		}

		function test4() {
			$this->load->library('unit_test');
			$test = array();
			$expected_result = $this->_getJournal(200, $this->teacher->getLessons(10, 0, 26, ""));
			$test_name = 'Неправильный идентификатор класса, при этом задан список учебных занятий';
			$this->unit->run($test, $expected_result, $test_name);
			echo $this->unit->report();
		}

		function test5() {
			$this->load->library('unit_test');
			$test =  array(0 => array("pupil_id" => 26, "pupil_name" => "Бойцова Юлия", "lessons" => array (0 => array ("marks" => null, "pass" => null))), 1 => array ("pupil_id" => 28, "pupil_name" => "Бусова Анна", "lessons" => array(0 => array("marks" => null, "pass" => null))),  2 => array("pupil_id" => 2, "pupil_name" => "Морозова Анастасия", "lessons" => array(0 => array("marks" => null, "pass" => null))), 3 => array("pupil_id" => 27, "pupil_name" => "Пимурзина Виктория", "lessons" => array(0 => array("marks" => null, "pass" => null))));
			$expected_result = $this->_getJournal(3, $this->teacher->getLessons(10, 0, 27, ""));
			$test_name = 'Входные параметры заданы верно, но у учащихся отсутствуют оценки и пропуски';
			$this->unit->run($test, $expected_result, $test_name);
			echo $this->unit->report();
		}


		function test6() {
			$this->load->library('unit_test');
			$test =  array(0 => array("pupil_id" => 26, "pupil_name" => "Бойцова Юлия", "lessons" => array (0 => array ("marks" => array (0 => array ("mark" => 5,  "type" => "Изложение"), 1 => array ("mark" => 4, "type" => "Тест")), "pass" => null ) )), 1 => array ("pupil_id" => 28, "pupil_name" => "Бусова Анна", "lessons" => array (0 => array ("marks" => array (0 => array ("mark" => 5, "type" => "Ответ на уроке" )), "pass" => null))),  2 => array("pupil_id" => 2, "pupil_name" => "Морозова Анастасия", "lessons" => array (0 => array ("marks" => null, "pass" => "б" ))), 3 => array("pupil_id" => 27, "pupil_name" => "Пимурзина Виктория", "lessons" => array(0 => array("marks" => null, "pass" => null))));
			$expected_result = $this->_getJournal(3, $this->teacher->getLessons(1, 0, 26, ""));
			$test_name = 'Входные параметры заданы верно, при этом у учащихся может быть несколько оценок за один урок';
			$this->unit->run($test, $expected_result, $test_name);
			echo $this->unit->report();
		}
	}
?>