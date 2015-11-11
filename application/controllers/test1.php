<?php

	class Test extends CI_Controller {

		function index() {
			echo "wefew";
		}

		function example() {
			$this->load->library('unit_test');
			$test = 1 + 1;
			$expected_result = 2;
			$test_name = 'Adds one plus one';
			echo $this->unit->run($test, $expected_result, $test_name);
		}
	}
?>