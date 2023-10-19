<?php

	class Pupil extends CI_Controller {

		private $pupil_role = null;
		var $pupil_id = null;
		var $pupil_login = null;
		var $pupil_class = null;

		public function __construct() {
			parent::__construct();
			$this->load->model('pupilmodel', 'pupil');
			$this->load->library("roleenum");
			$this->load->library('javascript');

			$this->pupil_role = $this->session->userdata('role');
			$this->pupil_login = $this->session->userdata('login');
			$this->pupil_id = $this->session->userdata('id');
			$this->pupil_class = $this->session->userdata('class_id');
		}

		function _remap($method, $params = array()) {
			$login = $this->pupil_login;
			$role = $this->pupil_role;
			$roleEnum = $this->roleenum;

			if(isset($login) && isset($role) && $role == Roleenum::Pupil) {
				$data['role'] = $role;
				$data['mainlogin'] = $login;

				$pageTitles = array(
					'news' => "Новости",
					'timetable' => "Расписание",
					'diary' => "Дневник",
					'progress' => "Итоговые оценки",
					'message' => "Общение", 
					'statistics' => "Статистика",
					'marks' => "Оценки",
				);

				if(array_key_exists($method, $pageTitles)) {
					$data['title'] = $pageTitles[$method];
				}

				$this->load->view('header', $data);
				
				if (method_exists($this, $method)) {
					call_user_func_array(array($this, $method), $params);
				} else {
					redirect("pupil/news");
				}

				$this->load->view('footer');
			} else {
				redirect('auth/logout');
			}

		}

		private function _dayOfWeek() {
			$day = date("w");
			if ($day == 0) $day = 7;
			return $day;
		}


		private function _getTimetableForDay($class_id, $day) {

			$result = $this->pupil->getTimetable($class_id, $day);

			$arrResult = array();

			foreach ($result as $row) {
				$arrResult[] = array("start"=> $row['TIME_START'],"finish"=>$row['TIME_FINISH'],
				"name"=>$row['SUBJECT_NAME'], "room" => $row['ROOM_NAME']);
			}
			return $arrResult;
		}


		function timetable() {
			$login = $this->pupil_login; //$this->session->userdata('login');
			$role = $this->pupil_role; //$this->session->userdata('role');
			$class_id = $this->pupil_class; //$this->session->userdata('class_id');
				$data['role'] = $role;

				$days = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');

				$data = array();
				$data['days'] = $days;
				$arr = array();
				for ($i = 0; $i < 6; $i++) {
					$arr[$i] =  $this->_getTimetableForDay($class_id, $i+1);
				}
				$data['timetable'] = $arr;
				$this->load->view('pupil/timetableview', $data);
		}

		function news($offset = 1) {
			//Новости

			// Переменная хранит число сообщений выводимых на станице
			$num = 4;

			$config['total_rows'] = $this->pupil->totalNews();
			$config['base_url'] = base_url()."pupil/news";
			$config['per_page'] = $num;


			$this->pagination->initialize($config);

			$query = $this->pupil->getNews($num, $offset * $num - $num);
			$data['news'] = null;
			if($query) {
				$data['news'] =  $query;
			}


			//Расписание
			$class_id = $this->pupil_class; // $this->session->userdata('class_id');
			$data['timetable'] = $this->_getTimetableForDay($class_id, $this->_dayOfWeek());

			$this->load->view('pupil/sidebarview', $data);
			$this->load->view('pupil/newsview', $data);
		}


		function post($id = null) {
			if(isset($id)) {
				$post = $this->pupil->getNewsbyId($id);
				$data['theme'] = $post['NEWS_THEME'];
				$data['time'] = $post['NEWS_TIME'];
				$data['text'] = $post['NEWS_TEXT'];
				$data['teacher'] = $post['TEACHER_NAME'];

				//Расписание
				$class_id = $this->pupil_class; //$this->session->userdata('class_id');
				$data['timetable'] = $this->_getTimetableForDay($class_id, $this->_dayOfWeek());

				$this->load->view('pupil/sidebarview', $data);
				$this->load->view('pupil/postview', $data);

			} else {
				//ошибка
				$data['error'] = "Ошибка";
				$this->load->view("errorview", $data);
			}
		}

		private function _getDiary($monday, $class_id) {

			$pupil_id = $this->pupil_id; // $this->session->userdata('id');

			$day = date("Y-m-d", strtotime($monday));
			$diary = array();
			for ($i = 1; $i <= 6; $i++) {
				$result = $this->pupil->getTimetable($class_id, $i);
				$diary[$i] = array();
				$y = 1;
				if (count($result) == 0) {
					$diary[$i] = array();
				} else {
					foreach ($result as $row) {
						$diary[$i][$y] = array();
						$diary[$i][$y]["subject"] = $row['SUBJECT_NAME'];
						$diary[$i][$y]["subject_id"] = $row['SUBJECTS_CLASS_ID'];
						$currentday = $day;
						$time_id = $row['TIME_ID'];

						$lesson = $this->pupil->getLessonByDate($row['SUBJECTS_CLASS_ID'], $currentday, $time_id);
						if (!isset($lesson)) {
							$diary[$i][$y]["lesson_id"] = 0;
							$diary[$i][$y]["lesson_status"] = 0;
							$diary[$i][$y]["homework"] = "";
							$diary[$i][$y]["files"] = array();
							$diary[$i][$y]["marks"] = array();
							$diary[$i][$y]["pass"] = "";
							$diary[$i][$y]["note"] = "";
						} else {
							$diary[$i][$y]["lesson_id"] = $lesson['LESSON_ID'];
							$diary[$i][$y]["lesson_status"] = $lesson['LESSON_STATUS'];
							if (isset($lesson['LESSON_HOMEWORK'])) {
								$diary[$i][$y]["homework"] = $lesson['LESSON_HOMEWORK'];
							} else $diary[$i][$y]["homework"] = null;
							/*$files = $this->pupil->getFilesForHomework($lesson['LESSON_ID']);
							$diary[$i][$y]["file"] = count($files);
							if (count($files) > 0) {
								$diary[$i][$y]["files"] = array();
								$f = 1;
								foreach($files as $file) {
									$diary[$i][$y]["files"][$f]["name"] = $file['FILE_NAME'].".".$file['FILE_EXTENSION'];
									$diary[$i][$y]["files"][$f]["path"] = base_url()."files/".$file['FILE_ID'].".".$file['FILE_EXTENSION'];
									$f++;
								}
							} else $diary[$i][$y]["files"] = null;*/

							//получаем пропуск
							$pass = $this->pupil->getPass($lesson['LESSON_ID'], $pupil_id);
							$diary[$i][$y]["pass"] =isset($pass) ? $pass['ATTENDANCE_PASS'] : "";

							//получаем замечание
							$diary[$i][$y]["note"] = isset($note) ? $note['NOTE_TEXT'] : "";

							//получаем оценки
							$marks = $this->pupil->getMarks($lesson['LESSON_ID'], $pupil_id);
							$diary[$i][$y]["marks"] = array();
							$z = 1;
							foreach ($marks as $mark) {
								$diary[$i][$y]["marks"][$z]["mark"] = $mark['ACHIEVEMENT_MARK'];
								$diary[$i][$y]["marks"][$z]["type"] = $mark['TYPE_NAME'];
								$z++;
							}
						}
						$y++;
					}
				}
				$day = date('Y-m-d', strtotime($monday. ' + '.$i.' days'));
			}

			return $diary;
		}

		function diary($monday = null) {
			$pupil_id =  $this->pupil_id; //$this->session->userdata('id');
			if(!isset($monday)) {
				$string_date = date('Y-m-d');
				$day_of_week = date('N', strtotime($string_date));
				$week_first_day = date('Y-m-d', strtotime($string_date . " - " . ($day_of_week - 1) . " days"));
				redirect(base_url()."pupil/diary/".$week_first_day);
			} else {
				$week_first_day = date('Y-m-d', strtotime($monday . " - " . (date('N', strtotime($monday)) - 1) . " days"));
				//является ли дата понедельником
				if ($monday == $week_first_day) {
					$data['days'] = array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
					$arr = $this->pupil->getClassByDate($pupil_id, $monday);
					if (isset($arr)) {
						$class_id = $arr['CLASS_ID'];
						$diary = $this->_getDiary($monday, $class_id);

						if (!$diary) {
							$data['error'] = "Учебных занятий нет";
							$data['diary'] = array();
						}
						else {
							$data['error'] = null;
							$data['diary'] = $diary;
						}
					} else {
						$data['error'] = "Каникулы";
						$data['diary'] = null;
					}

					//print_r($data['diary']);

					$data['monday'] = $monday;
					$this->load->view('pupil/diaryview', $data);
				}
				else {
					$string_date = date('Y-m-d');
					$day_of_week = date('N', strtotime($string_date));
					$week_first_day = date('Y-m-d', strtotime($string_date . " - " . ($day_of_week - 1) . " days"));
					redirect(base_url()."pupil/diary/".$week_first_day);
				}
			}
		}



		private function _getYears() {
			$years = $this->pupil->getYears();
			$arr = array();
			foreach ($years as $row) {
				$arr[$row['YEAR_ID']] = date("Y", strtotime($row['YEAR_START'])).' - '.date("Y", strtotime($row['YEAR_FINISH']));
			}
			return $arr;
		}


		private function _getTotalMarks($year) {
			$pupil_id =  $this->pupil_id; //$this->session->userdata('id');

			//Получаем класс
			$result = $this->pupil->getClassInYear($pupil_id, $year);
			foreach ($result as $row) {
				$class_id = $row['CLASS_ID'];
			}
			if (isset($class_id)) {
				//Получаем предметы в классе
				$result = $this->pupil->getSubjectsClass($class_id);
				$arr = array();
				foreach ($result as $row) {
					$arr[$row['SUBJECTS_CLASS_ID']]["subject"] = $row['SUBJECT_NAME'];
				}
				while ($subject = current($arr)) {
					$result = $this->pupil->getProgressMarks(key($arr), $pupil_id);
					foreach ($result as $row) {
						$arr[key($arr)][$row['PERIOD_NAME']] = $row['PROGRESS_MARK'];
					}
					next($arr);
				}
				foreach ($arr as $key => $value) {
					for ($i = 1; $i <= 5; $i++) {
						if (!isset($arr[$key][$i])) {
							$arr[$key][$i]="н/д";
						}
					}
				}
			}
			else $arr = null;

			return $arr;
		}


		function progress($year = null) {
			$years = $this->_getYears();
			if (isset($year)) {
				if(isset($_POST['year'])) {
					$year = $_POST['year'];
					redirect(base_url().'pupil/progress/'.$year);
				}
				if(in_array($year, array_keys($years))) {
					$result = $this->_getTotalMarks($year);
					$data['years'] = $years;
					$data['result'] = $result;
					$this->load->view('pupil/progressview', $data);
				} else {
					//ошибка
					$data['error'] = "Выбранного периода не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			}
			else {
				if(isset(array_keys($years)[0])) {
					$year = array_keys($years)[0];
					$url = base_url();
					$url = $url.'pupil/progress/'.$year;
					redirect($url);
				} else {
					//ошибка
					$data['error'] = "В системе отсутствуют учебные года";
					$this->load->view("errorview", $data);
				}
			}
		}

		private function _getStatistics($year, $period) {
			$pupil_id = $this->pupil_id; //$this->session->userdata('id');
			//начало и конец периода
			$period = $this->pupil->getPeriodById($period);
			$start = $period['PERIOD_START'];
			$finish = $period['PERIOD_FINISH'];
			//Получаем класс
			$result = $this->pupil->getClassInYear($pupil_id, $year);
			foreach ($result as $row) {
				$class_id = $row['CLASS_ID'];
			}
			if (isset($class_id)) {
				$arr = array();
				$subjects = $this->pupil->getSubjectsClass($class_id);
				foreach($subjects as $subject) {
					$arr[$subject['SUBJECTS_CLASS_ID']]["subject"] = $subject['SUBJECT_NAME'];
					$marks =  $this->pupil->getAverageMarkForPupil($pupil_id, $subject['SUBJECTS_CLASS_ID'], $start, $finish);
					if (count($marks) == 0) {
						$arr[$subject['SUBJECTS_CLASS_ID']]["average"] = null;
					}
					else {
						foreach($marks as $mark) {
							$arr[$subject['SUBJECTS_CLASS_ID']]["average"] = number_format($mark['MARK'],1);
						}
					}
					$marks = $this->pupil->getAverageMarkForClass($class_id, $subject['SUBJECTS_CLASS_ID'], $start, $finish);
					if (count($marks) == 0) {
						$arr[$subject['SUBJECTS_CLASS_ID']]["min"] = null;
						$arr[$subject['SUBJECTS_CLASS_ID']]["max"] = null;
					}
					else {
						foreach($marks as $mark) {
							$arr[$subject['SUBJECTS_CLASS_ID']]["min"] = number_format($mark['MIN'],1);
							$arr[$subject['SUBJECTS_CLASS_ID']]["max"] = number_format($mark['MAX'],1);
						}
					}
					//всего пропусков
					/*$passes = $this->pupil->getAllPasses($pupil_id, $subject['SUBJECTS_CLASS_ID'], $start, $finish);
					if (count($passes) == 0) {
						$arr[$subject['SUBJECTS_CLASS_ID']]["pass"] = null;
					}
					else {
						foreach($passes as $pass) {
							$arr[$subject['SUBJECTS_CLASS_ID']]["pass"] = $pass['PASS'];
						}
					}
					//по болезни
					$passes = $this->pupil->getIllPasses($pupil_id, $subject['SUBJECTS_CLASS_ID'], $start, $finish);
					if (count($passes) == 0) {
						$arr[$subject['SUBJECTS_CLASS_ID']]["ill"] = null;
					}
					else {
						foreach($passes as $pass) {
							$arr[$subject['SUBJECTS_CLASS_ID']]["ill"] = $pass['PASS'];
						}
					}*/

					$counts = $this->pupil->getCountPupilInClassByMark($arr[$subject['SUBJECTS_CLASS_ID']]["average"], $pupil_id, $class_id,
					$subject['SUBJECTS_CLASS_ID'], $start, $finish);
					$arr[$subject['SUBJECTS_CLASS_ID']]["min_count"] = $counts["min"];
					$arr[$subject['SUBJECTS_CLASS_ID']]["same_count"] = $counts["same"];
					$arr[$subject['SUBJECTS_CLASS_ID']]["max_count"] = $counts["max"];

				}
			} else $arr = null;
			return $arr;
		}


		private function _getPeriodsForYear($year) {
			$periods = $this->pupil->getPeriods($year);
			$arr = array();
			foreach ($periods as $row) {
				$arr[$row['PERIOD_ID']]["start"] = $row['PERIOD_START'];
				$arr[$row['PERIOD_ID']]["finish"] = $row['PERIOD_FINISH'];
				$arr[$row['PERIOD_ID']]["name"] = $row['PERIOD_NAME'];
			}
			return $arr;
		}

		function statistics($year = null, $period = null) {
			$years = $this->_getYears();
			if (!isset($year) || !isset($period)) {
				$year = array_keys($years)[0];
				$period = array_keys($this->_getPeriodsForYear($year))[0];
				$url = base_url().'pupil/statistics/'.$year."/".$period;
				redirect($url);
			}
			else {
				if (isset($_POST['year'])) {
					$year = $_POST['year'];
					$periods = array_keys($this->_getPeriodsForYear($year));
					redirect(base_url().'pupil/statistics/'.$year."/".$periods[0]);
				}
				if(isset($_POST['period'])) {
					$period = $_POST['period'];
					redirect(base_url().'pupil/statistics/'.$year."/".$period);
				}
				$periods = array_keys($this->_getPeriodsForYear($year));
				if (in_array($period, $periods)) {
					$data['years'] = $years;
					$data['periods'] = $this->_getPeriodsForYear($year);
						$data['stat'] = $this->_getStatistics($year, $period);
						$this->load->view("pupil/statisticsview", $data);
				} else {
					//ошибка
					$data['error'] = "Выбранного периода не существует";
					$this->load->view("errorview", $data);
				}
			}

		}

		private function _getPupilMarks($id, $start, $finish, $class_id) {
			$result = array();
			$subjects = $this->pupil->getSubjectsClass($class_id);
			$i = 0;
			foreach($subjects as $subject) {
				$result[$i]["subject"] = $subject["SUBJECT_NAME"];
				$subject_id = $subject["SUBJECTS_CLASS_ID"];
				$marks =  $this->pupil->getMarksForSubject($id, $subject_id, $start, $finish);
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
				$passes = $this->pupil->getPassForSubject($id, $subject_id, $start, $finish);
				if(count($passes) > 0) {
					foreach($passes as $pass) {
						if($pass['ATTENDANCE_PASS'] == 'н') {
							$result[$i]["pass"]['н'] = $pass['COUNT'];
						} else {
							if($pass['ATTENDANCE_PASS'] == 'б') {
								$result[$i]["pass"]['б'] = $pass['COUNT'];
							} else {
								if($pass['ATTENDANCE_PASS'] == 'у') {
									$result[$i]["pass"]['у'] = $pass['COUNT'];
								}
							}
						}
					}
				} else {
					$result[$i]["pass"] = null;
				}
				$i++;
			}
			return $result;
		}

		function marks($class_id = null, $period = null) {
			$pupil_id = $this->pupil_id; //$this->session->userdata('id');
			$classes = $this->pupil->getClasses($pupil_id);
			if(isset($class_id) && isset($period)) {
				if(isset($_POST['class'])) {
					$class_id = $_POST['class'];
					$period = $this->pupil->getBorders($class_id)[0]['PERIOD_ID'];
					redirect(base_url()."pupil/marks/".$class_id."/".$period);
				}
				if(isset($_POST['period'])) {
					$period = $_POST['period'];
					redirect(base_url()."pupil/marks/".$class_id."/".$period);
				}
				$row = $this->pupil->getPeriodById($period);
				$start = $row['PERIOD_START'];
				$finish = $row['PERIOD_FINISH'];
				$data['periods'] = $this->pupil->getBorders($class_id);
				$data['progress'] = $this->_getPupilMarks($pupil_id, $start, $finish, $class_id);
				$data['classes'] = $classes;
				$this->load->view("pupil/marksview", $data);
			} else {
				$class_id = $this->pupil_class; // $this->session->userdata('class_id');
				$period = $this->pupil->getBorders($class_id)[0]['PERIOD_ID'];
				redirect(base_url()."pupil/marks/".$class_id."/".$period);
			}
		}
	}