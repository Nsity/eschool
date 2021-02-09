<?php
	class Admin extends CI_Controller {

		var $admin_role = null;
		var $admin_id = null;
		var $admin_login = null;

		public function __construct() {
            parent::__construct();
            $this->load->model('adminmodel', 'admin');
            $this->load->model('tablemodel', 'table');

            $this->admin_role = $this->session->userdata('role');
            $this->admin_login = $this->session->userdata('login');
            $this->admin_id = $this->session->userdata('id');
        }

		function _remap($method, $params = array()) {
			$login =  $this->admin_login; //$this->session->userdata('login');
			$role = $this->admin_role; //$this->session->userdata('role');

			if(isset($login) && isset($role) && $role == "2") {
				switch($method) {
					case 'teachers': {
						$data['title'] = "Список учителей";
						break;
					}
					case 'news': {
						$data['title'] = "Список новостей";
						break;
					}
					case 'types': {
						$data['title'] = "Список типов оценок";
						break;
					}
					case 'classes': {
						$data['title'] = "Список классов";
						break;
					}
					case 'rooms': {
						$data['title'] = "Список кабинетов";
						break;
					}
					case 'subjects': {
						$data['title'] = "Список общих предметов";
						break;
					}
					case 'years': {
						$data['title'] = "Список учебных годов";
						break;
					}
					case 'teacher': {
						$data['title'] = "Учитель";
						break;
					}
					case 'newsitem': {
						$data['title'] = "Новость";
						break;
					}
					case 'subject': {
						$data['title'] = "Общий предмет";
						break;
					}
					case 'room': {
						$data['title'] = "Кабинет";
						break;
					}
					case 'classitem': {
						$data['title'] = "Класс";
						break;
					}
					case 'type': {
						$data['title'] = "Тип оценки";
						break;
					}
					case 'year': {
						$data['title'] = "Учебный год";
						break;
					}
					case 'statistics': {
						$data['title'] = "Анализ";
						break;
					}
				}

				$data['role'] = $role;
				$data['mainlogin'] = $login;
				$this->load->view('header', $data);
				if (method_exists($this, $method))
				{
					call_user_func_array(array($this, $method), $params);
				}
				else {
					redirect(base_url()."admin/teachers");
				}
				$this->load->view('footer');
			}
			else {
				redirect('auth/logout');
			}
		}

		function teachers($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."admin/teachers");
					} else redirect(base_url()."admin/teachers?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}

			$num = 15;

			//$teachers = $this->admin->getTeachers($num, $offset * $num - $num, $search);

			$config['total_rows'] = $this->admin->totalTeachers($search);
			$config['base_url'] = base_url()."admin/teachers";
			$config['per_page'] = $num;


			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);

			$query = $this->admin->getTeachers($num, $offset * $num - $num, $search);
			$data['teachers'] = array();
			if($query) {
				$data['teachers'] =  $query;
			}

			$this->load->view("admin/teachersview", $data);
		}

		function classes($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."admin/classes");
					} else redirect(base_url()."admin/classes?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}
			$num = 15;

			//$classes = $this->admin->getClasses($num, $offset * $num - $num, $search);

			$config['total_rows'] = $this->admin->totalClasses($search);
			$config['base_url'] = base_url()."admin/classes";
			$config['per_page'] = $num;


			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);
			$query = $this->admin->getClasses($num, $offset * $num - $num, $search);
			$data['classes'] = array();
			if($query) {
				$data['classes'] =  $query;
			}
			$this->load->view("admin/classesview", $data);
		}


		function subjects($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."admin/subjects");
					} else redirect(base_url()."admin/subjects?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}

			$num = 15;

			//$subjects_array = $this->admin->getSubjects($num, $offset * $num - $num, $search);

			$config['total_rows'] = $this->admin->totalSubjects($search);
			$config['base_url'] = base_url()."admin/subjects";
			$config['per_page'] = $num;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}


			$this->pagination->initialize($config);
			$query = $this->admin->getSubjects($num, $offset * $num - $num, $search);
			$data['subjects'] = array();
			if($query) {
				$data['subjects'] =  $query;
			}
			$this->load->view("admin/subjectsview", $data);
		}


		function subject($id = null) {
			if(isset($_POST['save'])) {
				$name = $_POST['inputSubject'];
				if(isset($id)) {
					$this->table->updateSubject($name, $id);
				} else {
					$this->table->addSubject($name);
				}
				redirect(base_url()."admin/subjects");
			} else {
			if(isset($id)) {
				$subject = $this->admin->getSubjectById($id);
				if(isset($subject)) {
					$data['subject'] = $subject['SUBJECT_NAME'];
					$data['id'] = $subject['SUBJECT_ID'];
					$data['title'] = 'Редактирование общего предмета';
					$this->load->view("blankview/blanksubjectview", $data);

				} else {
					//ошибка
					$data['error'] = "Такого общего предмета не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				$data['title'] = 'Добавление нового общего предмета';
				$this->load->view("blankview/blanksubjectview", $data);

			}
			}
		}


		function type($id = null) {
			if(isset($_POST['save'])) {
				$name = $_POST['inputType'];
				if(isset($id)) {
					$this->table->updateType($name, $id);
				} else {
					$this->table->addType($name);
				}
				redirect(base_url()."admin/types");
			} else {
				if(isset($id)) {
					$type = $this->admin->getTypeById($id);
					if(isset($type)) {
						$data['type'] = $type['TYPE_NAME'];
						$data['id'] = $type['TYPE_ID'];
						$data['title'] = 'Редактирование типа оценки';
						$this->load->view("blankview/blanktypeview", $data);
					} else {
						//ошибка
						$data['error'] = "Такого типа оценки не существует. Вернитесь обратно";
						$this->load->view("errorview", $data);
					}
				} else {
					$data['title'] = 'Добавление нового типа оценки';
					$this->load->view("blankview/blanktypeview", $data);
				}
			}
		}

		function room($id = null) {
			if(isset($_POST['save'])) {
				$name = $_POST['inputRoom'];
				if(isset($id)) {
					$this->table->updateRoom($name, $id);
				} else {
					$this->table->addRoom($name);
				}
				redirect(base_url()."admin/rooms");
			} else {
			if(isset($id)) {
				$room = $this->admin->getRoomById($id);
				if(isset($room)) {
					$data['room'] = $room['ROOM_NAME'];
					$data['id'] = $room['ROOM_ID'];
					$data['title'] = 'Редактирование кабинета';
					$this->load->view("blankview/blankroomview", $data);
				} else {
					//ошибка
					$data['error'] = "Такого кабинета не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				$data['title'] = 'Добавление нового кабинета';
				$this->load->view("blankview/blankroomview", $data);
			}
			}
		}



		function rooms($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."admin/rooms");
					} else redirect(base_url()."admin/rooms?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}
			// Переменная хранит число сообщений выводимых на станице
			$num = 15;

			$config['total_rows'] = $this->admin->totalRooms($search);
			$config['base_url'] = base_url()."admin/rooms";
			$config['per_page'] = $num;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);

			$query = $this->admin->getRooms($num, $offset * $num - $num, $search);
			$data['rooms'] = array();
			if($query) {
				$data['rooms'] =  $query;
			}
			$this->load->view("admin/roomsview", $data);
		}



		function types($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."admin/types");
					} else redirect(base_url()."admin/types?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}

			// Переменная хранит число сообщений выводимых на станице
			$num = 15;

			$config['total_rows'] = $this->admin->totalTypes($search);
			$config['base_url'] = base_url()."admin/types";
			$config['per_page'] = $num;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);

			$query = $this->admin->getTypes($num, $offset * $num - $num, $search);
			$data['types'] = array();
			if($query) {
				$data['types'] =  $query;
			}
			$this->load->view("admin/typesview", $data);
		}


		function news($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."admin/news");
					} else redirect(base_url()."admin/news?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}

			// Переменная хранит число сообщений выводимых на станице
			$num = 15;

			$id = $this->admin_id; //$this->session->userdata('id');

			$config['total_rows'] = $this->admin->totalNews($id, $search);
			$config['base_url'] = base_url()."admin/news";
			$config['per_page'] = $num;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$this->pagination->initialize($config);

			$query = $this->admin->getNews($num, $offset * $num - $num, $id, $search);
			$data['news'] = array();
			if($query) {
				$data['news'] =  $query;
			}
			$this->load->view("admin/newsview", $data);
		}


		function newsitem($id = null) {
			if(isset($_POST['save'])) {
				$admin = $this->admin_id; //$this->session->userdata('id');
				$theme = $_POST['inputTheme'];
				$text = $_POST['inputText'];
				$date = $_POST['inputDate'];
				if(isset($id)) {
					$this->table->updateNews($id, $theme, $date, $text, $admin);
				} else {
					$this->table->addNews($theme, $date, $text, $admin);
				}
				redirect(base_url()."admin/news");
			} else {
				if(isset($id)) {
					$admin = $this->admin_id; //$this->session->userdata('id');
					$news = $this->admin->getNewsById($id, $admin);
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


		function classitem($id = null) {
			$data['years'] = $this->admin->getYears();
			$data['teachers'] = $this->admin->getAllTeachers();
			$data['classes'] = $this->admin->getAllClasses();
			if(isset($_POST['save'])) {
				$number = $_POST['inputNumber'];
				$letter = $_POST['inputLetter'];
				if(isset($_POST['inputYear'])) {
					$year = $_POST['inputYear'];
				} else {
					$year = "";
				}
				if(isset($_POST['inputStatus'])) {
					$status = $_POST['inputStatus'];
				} else {
					$status = "";
				}
				$teacher = $_POST['inputTeacher'];
				if(isset($_POST['inputPrevious'])) {
					$previous = $_POST['inputPrevious'];
				} else {
					$previous = "";
				}

				if(isset($id)) {
					$this->table->updateClass($id, $number, $letter, $year, $status, $teacher, $previous);
				} else {
					$this->table->addClass($number, $letter, $year, $status, $teacher, $previous);
				}
				redirect(base_url()."admin/classes");
			} else {
			if(isset($id)) {
				$classitem = $this->admin->getClassById($id);
				if(isset($classitem)) {
					$data['id'] = $classitem['CLASS_ID'];
					$data['number'] = $classitem['CLASS_NUMBER'];
					$data['letter'] = $classitem['CLASS_LETTER'];
					$data['status'] = $classitem['CLASS_STATUS'];
					//$data['previous'] = $classitem['CLASS_PREVIOUS'];
					$data['year_id'] = $classitem['YEAR_ID'];
					$data['teacher_id'] = $classitem['TEACHER_ID'];

					$data['status_allow'] = false;
					foreach( $this->admin->getAllClasses() as $class) {
						if($class['CLASS_PREVIOUS'] == $classitem['CLASS_ID']) {
							$data['status_allow'] = true;
						}
					}

					$data['title'] = 'Редактирование класса';
					$this->load->view("blankview/blankclassview", $data);
				} else {
					//ошибка
					$data['error'] = "Такого класса не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				$data['title'] = 'Добавление нового класса';
				$this->load->view("blankview/blankclassview", $data);
			}
			}

		}


		function teacher($id = null) {
			if(isset($_POST['save'])) {
				$name = $_POST['inputName'];
				$password = $_POST['inputPassword'];
				$login = $_POST['inputLogin'];
				$status = $_POST['inputStatus'];
				if(isset($id)) {
					$this->table->updateTeacher($id, $name, $password, $login, $status, md5($password));
				} else {
					$this->table->addTeacher($name, $password, $login, $status, md5($password));
				}
				redirect(base_url()."admin/teachers");
			} else {
			if(isset($id)) {
				$teacher = $this->admin->getTeacherById($id);
				if(isset($teacher)) {
					$data['id'] = $teacher['TEACHER_ID'];
					$data['name'] = $teacher['TEACHER_NAME'];
					$data['login'] = $teacher['TEACHER_LOGIN'];
					$data['password'] = $teacher['TEACHER_PASSWORD'];
					$data['status'] = $teacher['TEACHER_STATUS'];
					$data['title'] = 'Редактирование учителя';
					$this->load->view("blankview/blankteacherview", $data);
				} else {
					//ошибка
					$data['error'] = "Такого учителя не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				$data['title'] = 'Добавление нового учителя';
				$this->load->view("blankview/blankteacherview", $data);
			}
			}
		}



		function years($offset = 1) {
			// Переменная хранит число сообщений выводимых на станице
			$num = 15;

			$config['total_rows'] = $this->admin->totalYears();
			$config['base_url'] = base_url()."admin/periods";
			$config['per_page'] = $num;

			$this->pagination->initialize($config);

			$query = $this->admin->getYearsLimit($num, $offset * $num - $num);
			$data['periods'] = array();
			if($query) {
				$data['periods'] =  $query;
			}
			$this->load->view("admin/yearsview", $data);
		}


		function year($id = null) {
			if(isset($_POST['save'])) {
			    $year_start = $_POST['inputYearStart'];
			    $year_finish = $_POST['inputYearFinish'];

			    $first_start = $_POST['inputFirstStart'];
			    $first_finish = $_POST['inputFirstFinish'];

			    $second_start = $_POST['inputSecondStart'];
			    $second_finish = $_POST['inputSecondFinish'];

			    $third_start = $_POST['inputThirdStart'];
			    $third_finish = $_POST['inputThirdFinish'];

			    $forth_start = $_POST['inputForthStart'];
			    $forth_finish = $_POST['inputForthFinish'];
				if(isset($id)) {
					$this->table->updateYearAndPeriods($id, $year_start, $year_finish,
			$first_start, $first_finish, $second_start, $second_finish, $third_start,$third_finish, $forth_start, $forth_finish);
				} else {
					$this->table->addYearAndPeriods($year_start, $year_finish,
			$first_start, $first_finish, $second_start, $second_finish, $third_start,$third_finish, $forth_start, $forth_finish);
				}
				redirect(base_url()."admin/years");
			} else {
			if(isset($id)) {
				$year = $this->admin->getYearById($id);
				if(isset($year)) {
					$data['info'] = $year;
					$data['id'] = $year["id"];
					$data['title'] = 'Редактирование учебного года';
					$this->load->view("blankview/blankyearview", $data);
				} else {
					//ошибка
					$data['error'] = "Такого учебного года не существует. Вернитесь обратно";
					$this->load->view("errorview", $data);
				}
			} else {
				$data['title'] = 'Добавление нового учебного года';
				$this->load->view("blankview/blankyearview", $data);
			}
			}
		}

		function statistics($year = null, $period = null) {
			$years = $this->admin->getYears();
			if(count($years) == 0) {
				//ошибка
				$data['error'] = "Добавьте учебные года";
				$this->load->view("errorview", $data);
			} else {
				if(!isset($year) || !isset($period)) {
					$year = $years[0]['YEAR_ID'];
					$periods = $this->admin->getPeriodsInYear($year);
					$period =  $periods[0]['PERIOD_ID'];
					redirect(base_url()."admin/statistics/".$year."/".$period);
				} else {
					if(isset($_POST['year'])) {
						$year = $_POST['year'];
						$periods = $this->admin->getPeriodsInYear($year);
						$period =  $periods[0]['PERIOD_ID'];
						redirect(base_url()."admin/statistics/".$year."/".$period);
					}
					if(isset($_POST['period'])) {
						$period = $_POST['period'];
						redirect(base_url()."admin/statistics/".$year."/".$period);
					}
					$data['years'] = $years;
					$data['periods'] = $this->admin->getPeriodsInYear($year);
					$classes = $this->admin->getClassesInYear($year);
					$result = array();
					$i=0;
					foreach($classes as $class) {
						$class_id = $class['CLASS_ID'];
						$result[$i]["class_id"] = $class_id;
						$result[$i]["class_name"] = $class['CLASS_NUMBER']." ".$class['CLASS_LETTER'];

						$pupils = $this->admin->getPupilsInClass($class_id);
						$result[$i]["count"] = count($pupils);
						$result[$i][5]['mark'] = 0;
						$result[$i][4]['mark'] = 0;
						$result[$i][3]['mark'] = 0;
						$result[$i][2]['mark'] = 0;
						foreach($pupils as $pupil) {
							$pupil_id = $pupil['PUPIL_ID'];
							$marks =  $this->admin->getPupilProgress($pupil_id, $period);
							for($y = 2; $y <=5; $y++) {
								$count[$y] = 0;
								foreach ($marks as $key=>$value) {
									if ($value ['PROGRESS_MARK'] == $y) {
										$count[$y]++;
									}
								}
							}
							//print_r( $count[5]);
							//print_r( count($marks));
							if($count[5] == count($marks) && count($marks) !=0) {
								//print_r($pupil['PUPIL_NAME']);
								$result[$i][5]['mark']++;
							} else {
								if(($count[5] + $count[4]) == count($marks) && count($marks) !=0) {
									$result[$i][4]['mark']++;
								} else {
									if($count[2] > 0 && count($marks) !=0) {
										$result[$i][2]['mark']++;
									} else {
										if(count($marks) !=0) {
										//print_r($pupil['PUPIL_NAME']);
										$result[$i][3]['mark']++;
										}
									}
								}
							}

						}
						$i++;
					}
					/*$arr = $this->admin->getClassPass($year, $period, 'б');
					echo count($arr);
					if(count($arr) > 0) {
						$data['pass1'] = $arr[0]['CLASS_NUMBER']." ".$arr[0]['CLASS_LETTER'];
					}*/

						/*$data['pass2'] = $this->admin->getClassPass($year, $period, 'у');
						$data['pass3'] = $this->admin->getClassPass($year, $period, 'n');*/
					$data['result'] = $result;
					$this->load->view("admin/statisticsview", $data);
				}
			}
		}

		function progress($class_id = null, $period = null) {
			$this->load->model('teachermodel', 'teacher');
			$borders = $this->teacher->getBorders($class_id);
			$data['class_name'] = $this->admin->getClassById($class_id)['CLASS_NUMBER']." ".$this->admin->getClassById($class_id)['CLASS_LETTER'];
			if(!isset($period)) {
				redirect(base_url()."admin/progress/".$class_id."/".$borders[0]['PERIOD_ID']);
			} else {
				if(isset($_POST['period'])) {
					$period = $_POST['period'];
					redirect(base_url()."admin/progress/".$class_id."/".$period);
				}
				$data['periods'] = $borders;
				//успеваемость

				$pupils = $this->admin->getPupilsInClass($class_id);
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
					$data['progress'] = null;
				}
				$data['subjects'] = $subjects;
				$this->load->view("admin/classreportview", $data);
			}
		}


		function error () {
			$data['error'] = "Такой страницы не существует";
			$this->load->view("errorview", $data);
		}


	}

?>