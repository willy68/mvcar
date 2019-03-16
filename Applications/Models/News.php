<?php
class News extends ActiveRecord\Model 
{

static $table_name = 'news';

	// static $before_save = array('make_date');

	/* public function make_date() {
		if ($this->is_new_record()) {
			$this->assign_attribute('dateajout', date("Y-m-d H:i:s"));
		}
		$this->assign_attribute('datemodif', date("Y-m-d H:i:s"));
	}*/

}
