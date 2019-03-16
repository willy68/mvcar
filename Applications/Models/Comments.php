<?php
//namespace Library\Models;
class Comments extends ActiveRecord\Model 
{

	static $table_name = 'comments';
	static $validates_presence_of = array(
	array('news', 'message' => 'Ne peut-être vide'),
	array('auteur', 'message' => 'L\'auteur du commentaire doit être spécifié'),
	array('contenu', 'message' => 'Ne peut-être vide!')
	);

	// static $before_save = array('make_date');

	// public function make_date() {
	//	$this->date = date("Y-m-d H:i:s");
	// }

}
