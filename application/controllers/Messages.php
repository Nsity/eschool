<?php

	class Messages extends CI_Controller {

		public function __construct() {
            parent::__construct();
            $this->load->model('messagemodel', 'message');
        }

        var $from = null;
        var $to = null;

		function _remap($method, $params = array())
		{
			$login = $this->session->userdata('login');
			$role = $this->session->userdata('role');

			if(isset($login)) {

				switch($method) {
					/*case 'inbox': {
						$data['title'] = "Входящие";
						break;
					}
					case 'sent': {
						$data['title'] = "Исходящие";
						break;
					}*/
					case 'conversations': {
						$data['title'] = "Переписки";
						break;
					}
					case 'conversation': {
						$data['title'] = "Общение";
						break;
					}
					case 'message': {
						$data['title'] = "Сообщение";
						break;
					}
				}

				switch($role) {
					case 4: {
						$this->from = "PUPIL";
						$this->to = "TEACHER";
						break;
					}
					case 1: case 3: {
						$this->to = "PUPIL";
						$this->from = "TEACHER";
						break;
					}
				}

				$data['role'] = $role;
				$data['mainlogin'] = $login;
				$this->load->view('header', $data);
				//$this->load->view('message/messagemenuview');

				if (method_exists($this, $method))
				{
					call_user_func_array(array($this, $method), $params);
				}
				else {
					redirect(base_url()."messages/conversations");
				}
				$this->load->view('footer');
			}
			else {
				redirect('auth/logout');
			}
		}


		/*private function _getMessages($type, $offset) {
			if($type == "1") {
				$folder = "inbox";
			} else $folder = "sent";

			$search = "";
			$id = $this->session->userdata('id');
			$num = 10;
			$config['total_rows'] = $this->message->totalFolderMessages($id, $type, $search, $this->from, $this->to);
			$config['base_url'] = base_url()."message/".$folder;
			$config['per_page'] = $num;

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}
			$query = $this->message->getFolderMessages($num, $offset * $num - $num, $id, $type, $search, $this->from, $this->to);
			$this->pagination->initialize($config);
			$data['messages'] = null;
			if($query) {
				$data['messages'] =  $query;
			}
			$data['active'] = $folder;
			//$data['badge'] = $this->message->totalUnreadPupilMessages($id, 1);
 			$this->load->view('message/messageview', $data);
		}


		function inbox($offset = 1) {
			$role = $this->session->userdata('role');
			switch($role) {
				case 4: {
					$this->_getMessages(1, $offset);
					break;
				}
				case 1: case 3: {
					$this->_getMessages(1, $offset);
					break;
				}
			}
		}

		function sent($offset = 1) {
			$role = $this->session->userdata('role');
			switch($role) {
				case 4: {
					$this->_getMessages(2, $offset);
					break;
				}
				case 1: case 3: {
					$this->_getMessages(2, $offset);
					break;
				}
			}
		}*/

		function message() {
			if(isset($_POST['send'])) {
				$id = $this->session->userdata('id');
				$user = $_POST['contact'];
				$text = $_POST['inputText'];
				date_default_timezone_set('Europe/Moscow');
				$date = date('Y-m-d H:i:s');
				$this->load->model('tablemodel', 'table');
				//добавдение сообщения
				$this->table->addMessage($id, $user, $text, $date, $this->from, $this->to);
				redirect(base_url()."messages/conversations");
			} else {
				$data['title'] = 'Новое сообщение';
				$this->load->view('blankview/blankmessageview', $data);
			}
		}

		function conversations($offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."messages/conversations");
					} else redirect(base_url()."messages/conversations?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}
			$id = $this->session->userdata('id');
			$num = 15;
			$config['total_rows'] = $this->message->totalMessages($id, $this->from, $this->to, $search);
			$config['base_url'] = base_url()."messages/conversations";
			$config['per_page'] = $num;

			$this->pagination->initialize($config);
			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}

			$query = $this->message->getMessages($num, $offset * $num - $num, $id, $this->from, $this->to, $search);
			$data['result'] = null;
			$data['messages'] = array();
			if($query) {
				$result = array();
				$i = 0;
				foreach($query as $row) {
					$user_id = $row['USER_ID'];
					$newmessages = $this->message->getNewMessages($user_id, $id, $this->from, $this->to);
					if(count($newmessages) > 0) {
						$result[$i]["new"] = count($newmessages);
					} else {
						$result[$i]["new"] = null;
					}
					$i++;
				}
				$data['result'] = $result;
				$data['messages'] =  $query;
			}
			$this->load->view('message/conversationsview', $data);
		}


		function conversation($user, $offset = 1) {
			$search = "";
			if(isset($_GET['submit'])) {
				if(isset($_GET['search'])) {
					$search = urldecode($_GET['search']);
					$data['search'] = $search;
					if ($search == "") {
						redirect(base_url()."messages/conversation/".$user);
					} else redirect(base_url()."messages/conversation/".$user."?search=".$search);
				}
			}
			if(isset($_GET['search'])) {
				$search = $_GET['search'];
				$data['search'] = $search;
			}
			$id = $this->session->userdata('id');
			$num = 15;
			$config['total_rows'] = $this->message->totalConversationMessages($id, $user, $search, $this->from, $this->to);
			$config['base_url'] = base_url()."messages/conversation/".$user;
			$config['per_page'] = $num;
			$config['uri_segment'] = 2;

			$data['user'] = $this->message->getUserById($user, $this->from, $this->to)['USER_NAME'];

			if (count($_GET) > 0)  { $config['suffix'] = '?' . http_build_query($_GET, '', "&");
				$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
			}
			$this->pagination->initialize($config);
			$query = $this->message->getConversationMessages($num, $offset * $num - $num, $id, $user, $search, $this->from, $this->to);
			$data['messages'] = null;
			if($query) {
				$data['messages'] =  $query;
			}
			$this->load->view('message/conversationview', $data);
		}
	}


?>