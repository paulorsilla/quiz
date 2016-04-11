<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Questao
 *
 * @category Application
 * @package Model
 *         
 * @ORM\Entity
 * @ORM\Table(name="questao")
 *         
 */
class Questao extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
    
    /**
	 * @ORM\Column(type="string")
     */
    protected $questao;
    
    /**
	 * @ORM\Column(type="integer")
     */
    protected $grupo;
    
    public function getId() {
    	return $this->id;
    }
    
    public function setId($id) {
    	$this->id = $id;
    }
    
    public function getQuestao() {
    	return $this->questao;
    }
    
    public function setQuestao($questao) {
    	$this->questao = $questao;
    }
    
    public function getGrupo() {
    	return $this->grupo;
    }
    
    public function setGrupo($grupo) {
    	return $this->grupo;
    }
    
    
    
    
    

}