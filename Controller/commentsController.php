<?php

class commentsController {
	
	private $_Comments;

	public function __construct() {
		$this->_Comments = new Comments();
	}

//PAGES

	//COMMENTAIRE SPECIFIQUE
	public function commentInfo($id) {
		if ($this->_Comments->checkComment($id)) {
			$view = new View('Flagged', 'Frontend');
			$view->generate(array('comment' => $this->_Comments->getComment($id)));
		} else {
			$view = new View('Error', 'Frontend');
			$view->generate(array('msg' => "Le commentaire demandé n'existe pas."));
		}		
	}

//FONCTIONNALITES

	public function commentCheck($id) {
		return $this->_Comments->checkComment($id);
	}

	//AJOUTE UN COMMENTAIRE
	public function commentAdd($id, $content, $pseudo) {
		$params = array(
			"id" => htmlspecialchars($id),
			"pseudo" => htmlspecialchars($pseudo),
			"contenu" => htmlspecialchars($content)		
		);

		$this->_Comments->addComment($params);
	}

	//AJOUTE UN FLAG
	public function commentFlag($id) {
		$result = $this->_Comments->getFlags($id);
		while ($data = $result->fetch()) {
			$flag = $data['flagged'];
			$flag++;
		}

		$this->_Comments->addFlag($id, $flag);
	}

	//SUPPRIME UN COMMENTAIRE
	public function commentDelete($id) {
		$this->_Comments->deleteComment($id);
	}

	//SUPPRIME UNE LISTE DE COMMENTAIRES
	public function commentListDelete($id) {
		$this->_Comments->deleteCommentList($id);
	}

	//REINITIALISE LE COMPTEUR DE FLAG
	public function commentFlagReset($id) {
		$this->_Comments->resetFlagComment($id);
	}

}