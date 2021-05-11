<?php

	class Api extends CI_Controller {

		public function __construct() {
            parent::__construct();
            $this->load->model('apimodel', 'api');
        }


		private function _getMarks($day, $date) {
			$id = $this->session->userdata('id');

			$class_id = $this->session->userdata('class_id');

			$arr = array();

			$subjects = $this->api->getTimetable($class_id, $day);

			for ($i=5; $i>=2; $i--) {
				$arr[$i] = 0;
			}

			if (count($subjects) > 0) {
				foreach($subjects as $subject) {
					$subjects_class_id = $subject['SUBJECTS_CLASS_ID'];
					$time_id = $subject['TIME_ID'];
					$current = $date;
					$marks = $this->api->getMarks($subjects_class_id, $current, $id, $time_id);
					if (count($marks) > 0) {
						foreach($marks as $mark) {
							$arr[$mark['ACHIEVEMENT_MARK']]++;
						}
					}
				}
				$s = 0;
				for ($i=5; $i>=2; $i--) {
					if ($arr[$i] != 0) {
						$s++;
					}
				}
				if ($s == 0) {
					return null;
				} else return $arr;
			} else {
				return null;
			}

		}



		function todayMarks($date = null) {
			if ($date == null) {
				$date = date("Y-m-d");
			}

			$day = date("w", strtotime($date));

			$login = $this->session->userdata('login');

			if(isset($login)) {
				$id = $this->session->userdata('id');
				//$arr = $this->getMarks(1, '2015-04-27');
				$arr = $this->_getMarks($day, $date);
				echo json_encode($arr, JSON_UNESCAPED_UNICODE);
			}
			else {
				echo 'error';
			}
		}




		private function getAverageMarks($day, $date) {
			$id = $this->session->userdata('id');
			$class_id = $this->session->userdata('class_id');
			$arr = array();
			$i = 1;
			$borders = $this->api->getBorders($class_id, $date);
			if (isset($borders)) {
				$subjects = $this->api->getTimetable($class_id, $day);
				if (count($subjects) > 0) {
					foreach($subjects as $subject) {
						$current = $date.' '.$subject['TIME_START'];
						$arr[$i]["subject"] = $subject['SUBJECT_NAME'];
						$mark = $this->api->getAverageMark($borders['PERIOD_START'], $date, $class_id, $id, $subject['SUBJECTS_CLASS_ID'])['MARK'];
						if(isset($mark)) {
							$arr[$i]["mark"] = number_format($mark,1);
						} else {
							$arr[$i]["mark"] = 0;
						}
						$i++;
					}
					return $arr;
				} else {
					return null;
				}
			} else {
				return null;
			}
		}

		function todayAverages($date = null) {
			if ($date == null) {
				$date = date("Y-m-d");
			}
			$login = $this->session->userdata('login');
			$day = date("w", strtotime($date));
			if(isset($login)) {
				$id = $this->session->userdata('id');
				//$arr = $this->getAverageMarks(1, '2015-04-27');
				$arr = $this->getAverageMarks($day, $date);
				echo json_encode( $arr, JSON_UNESCAPED_UNICODE);
			}
			else {
				echo 'error';
			}

		}


		function getPasses($period, $subject, $class_id) {
			$pupils = $this->api->getPupils($class_id);
			$result = array();
			$i = 0;
			foreach($pupils as $pupil) {
				$pupil_id = $pupil['PUPIL_ID'];
				$pass[1] = $this->api->getPasses($pupil_id, $subject, $period, "н")['COUNT'];
				$pass[2] = $this->api->getPasses($pupil_id, $subject, $period, "у")['COUNT'];
				$pass[3] = $this->api->getPasses($pupil_id, $subject, $period, "б")['COUNT'];
				$result[$i]["name"] = $pupil["PUPIL_NAME"];
				$result[$i]["pass"] = array(1 => $pass[1], 2 => $pass[2], 3=> $pass[3]);
				$i++;
			}
			//$result = array("pupils"=>$result);
/*
			$arrayRes = array();
			while ($row = mysql_fetch_assoc($result_op) ){
				$arrayRes [] = $row;
			}*/
			echo  json_encode($result, JSON_UNESCAPED_UNICODE);

		}


		function getAllPasses($period) {
			$class_id = $this->session->userdata('class_id');
			$pupils = $this->api->getPupils($class_id);
			$result = array();
			$i = 0;
			foreach($pupils as $pupil) {
				$pupil_id = $pupil['PUPIL_ID'];
				$pass[1] = $this->api->getAllPasses($pupil_id, $period, "н")['COUNT'];
				$pass[2] = $this->api->getAllPasses($pupil_id, $period, "у")['COUNT'];
				$pass[3] = $this->api->getAllPasses($pupil_id, $period, "б")['COUNT'];
				$result[$i]["name"] = $pupil["PUPIL_NAME"];
				$result[$i]["pass"] = array(1 => $pass[1], 2 => $pass[2], 3=> $pass[3]);
				$i++;
			}
			echo  json_encode($result, JSON_UNESCAPED_UNICODE);
			//echo $period;

		}
	}

	?>