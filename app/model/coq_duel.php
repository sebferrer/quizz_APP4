<?php 
include_once("pdo.php");
include_once("common.php");
class  coq_duel
{
	private $user1_id;
	private $user2_id;
	private $current_round_id;
	private $current_round_number;
	private $total_score1;
	private $total_score2;

	public function init($user1_id, $user2_id, $current_round_id, $current_round_number, $total_score1, $total_score2)
	{ 
		$this->user1_id = $user1_id;
		$this->user2_id = $user2_id;
		$this->current_round_id = $current_round_id;
		$this->current_round_number = $current_round_number;
		$this->total_score1 = $total_score1;
		$this->total_score2 = $total_score2;
	} 

	
	// Les accesseurs
	public function get_user1_id()
	{	
		return $this->user1_id; 
	}

	public function get_user2_id()
	{	
		return $this->user2_id; 
	}

	public function get_current_round_id()
	{	
		return $this->current_round_id; 
	}

	public function get_current_round_number()
	{	
		return $this->current_round_number; 
	}
	public function get_score1()
	{	
		return $this->total_score1; 
	}
	public function get_total_score2()
	{	
		return $this->total_score2; 
	}

	// Les mutateurs
	public function set_user1_id($value)
	{
		$this->user1_id = $value;
	}

	public function set_user2_id($value)
	{
		$this->user2_id = $value;
	}

	public function set_current_round_id($value)
	{
		$this->current_round_id = $value;
	}

	public function set_current_round_number($value)
	{
		$this->current_round_number = $value;
	}
	public function set_score1($value)
	{
		$this->total_score1 = $value;
	}
	public function set_total_score2($value)
	{
		$this->total_score2 = $value;
	}

	public function add()
	{
		$rqt = 
		'INSERT INTO coq_duel
		(
			user1_id,
			user2_id,
			current_round_id,
			current_round_number,
			total_score1, 
			total_score2
		)
		VALUES
		(
			"'.$this->user1_id.'",
			"'.$this->user2_id.'",
			"'.$this->current_round_id.'",
			"'.$this->current_round_number.'", 
			"'.$this->total_score1.'",
			"'.$this->total_score2.'"
		)';
		$this->pdo = initPDOObject();
		$this->pdo->request($rqt, $error);
	}

	public function update($id)
	{
		$rqt = 
		'UPDATE coq_duel SET
			user1_id = "'.$this->user1_id.'",
			user2_id = "'.$this->user2_id.'",
			current_round_id = "'.$this->current_round_id.'",
			current_round_number = "'.$this->current_round_number.'", 
			total_score1 = "'.$this->total_score1.'",
			total_score2 = "'.$this->total_score2.'"
		WHERE id ='.$id;
		echo("</br>". $rqt);
		$this->pdo = initPDOObject();
		$this->pdo->request($rqt, $error);
	}

	public function list_()
	{
		$rqt = "SELECT * FROM coq_duel";
		$this->pdo = initPDOObject();
		return $this->pdo->request($rqt, $error);
	}
	public function get_duels ($id_duel)
	{
		
		$rqt = "SELECT  cd.id, cu1.pseudo as pseudo1, cu2.pseudo as pseudo2, cd.current_round_number, ct.val as theme, cq.val as question, 
						cq.answer1, cq.answer2, cq.answer3, cq.answerOK, cr.round_score1, cr.round_score2
				FROM coq_duel cd, coq_user cu1, coq_user cu2, coq_round cr, coq_theme ct, coq_question cq
				WHERE cd.id = ".$id_duel."
				AND cd.user1_id = cu1.id
				AND cd.user2_id = cu2.id 
				AND cd.current_round_id = cr.id
				AND cr.selected_theme_id = ct.id
				AND cq.theme_id = ct.id";
		$this->pdo = initPDOObject();
		$data = $this->pdo->request($rqt, $error);
		if (count($data) > 0) return $data;
		else return 0;

	}
	public function get_score($id_duel)
	{
		$rqt = "SELECT cd.total_score1, cd.total_score2
				FROM coq_duel cd
				WHERE cd.id = ".$id_duel."";
		$this->pdo = initPDOObject();
		$data = $this->pdo->request($rqt, $error);
		if (count($data) > 0) return $data[0];
		else return 0;
	}
	public function submit_round ($id_duel)
	{
		$rqt = "SELECT * 
				FROM coq_duel as cd, coq_round as cr 
				WHERE cd.id = ".$id_duel." AND cd.current_round_id = cr.id";
	}
	public function duel_is_finished_or_not ($id_duel)
	{
		$rqt = "SELECT end1, end2 
				FROM coq_duel as cd, coq_round as cr 
				WHERE cd.id = ".$id_duel." AND cr.id = cd.current_round_id";
		$this->pdo = initPDOObject();
		$data = $this->pdo->request($rqt, $error);
		if (count($data) > 0) return $data[0];
		else return 0;
	}
	public function find($id)
	{
		$rqt = "SELECT * FROM coq_duel WHERE id = ".$id;
		$this->pdo = initPDOObject();
		$data = $this->pdo->request($rqt, $error);
		if (count($data) > 0) return $data[0];
		else return 0;
	}
	public function JSON ()
	{
		return json_encode(array("user1_id" => $this->user1_id, "user2_id" => $this->user2_id, 
								 "current_round_id" => $this->current_round_id, "current_round_number" => $this->current_round_number, 
								 "total_score1" => $this->total_score1, "total_score2" => $this->total_score2));
	}
}
?>
