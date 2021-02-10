<?php
class Auth extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('usermodel', 'user');
        $this->load->library("roleenum");
    }

	function index()
	{
		$roleEnum = $this->roleenum;
		$user = $this->session->userdata('login');
		//если пользователь уже есть
		if(isset($user)) {
			$role = $this->session->userdata('role');
			if($role == $roleEnum::Pupil) {
				redirect('pupil/news');
			}
			if($role == $roleEnum::Admin) {
				redirect('admin/teachers');
			}
			if ($role == $roleEnum::Teacher) {
				redirect('teacher/journal');
			}
			if ($role == $roleEnum::ClassTeacher) {
				redirect('classteacher/journal');
			}
		}
		else {
			if(isset($_POST['singin'])) {
				$user = $_POST['login'];
				$password = $_POST['password'];
				$row = $this->user->getTeacher($user, md5($password));
				if (isset($row)) {
					if ($row['TEACHER_STATUS'] == 1) {
						$class_id = $this->user->getTeacherClass($row['TEACHER_ID'])['CLASS_ID'];
						if (isset($class_id) && $row['ROLE_ID'] == $roleEnum::Teacher) {
							$role = $roleEnum::ClassTeacher;
					    } else {
						    $role = $row['ROLE_ID'];
					    }
					    $newdata = array(
					        'id' => $row['TEACHER_ID'],
						    'class_id' => $class_id,
						    'role' => $role,
					        'login' => $row['TEACHER_LOGIN'],
						);
						$this->session->set_userdata($newdata);
						if ($row['ROLE_ID'] == $roleEnum::Teacher || $row['ROLE_ID'] == $roleEnum::ClassTeacher) {
							redirect('teacher/journal');
						}
						if ($row['ROLE_ID'] == $roleEnum::Admin) {
							redirect('admin/teachers');
						}
					}
					else $data['error'] = "У Вас нет доступа к системе. Обратитесь к администратору";
					$this->load->view('authview', $data);
				}
				else {
					$row = $this->user->getPupil($user, md5($password));
					if (isset($row)) {
						if ($row['PUPIL_STATUS'] == $roleEnum::ClassTeacher) {
							$newdata = array(
							    'id' => $row['PUPIL_ID'],
							    'class_id' => $row['CLASS_ID'],
					            'role' => $row['ROLE_ID'],
						        'login' => $row['PUPIL_LOGIN'],
						    );
						    $this->session->set_userdata($newdata);
						    redirect('pupil/news');
						}
						else $data['error'] = "У Вас нет доступа к системе. Обратитесь к администратору";
						$this->load->view('authview', $data);
					}
					else {
						$data['error'] = "Вы ввели неправильный логин или пароль";
						$this->load->view('authview', $data);
					}
				}
			} else {
				$this->load->view('authview');
			}

		}
	}

	function logout() {
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('class_id');
		$this->session->unset_userdata('role');
		redirect('auth');
	}

}
?>