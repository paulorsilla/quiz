<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade Alternativa
 *
 * @category Application
 * @package Model
 *         
 * @ORM\Entity
 * @ORM\Table(name="alternativa")
 *         
 */
class Alternativa extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
    
    /**
	 * @ORM\Column(type="string")
     */
    protected $alternativa;
    
    /**
	 * @ORM\Column(type="string")
     */
    protected $ordem;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $correta;
    
	/**
	 * @ORM\ManyToOne(targetEntity="\Application\Model\Questao")
	 * @ORM\JoinColumn(name="questao_id", referencedColumnName="id")
	 **/
    protected $questao;
    

    public function getId() {
    	return $this->id;
    }
    
    public function setId($id) {
    	$this->id = $id;
    }
    
    public function getAlternativa() {
    	return $this->alternativa;
    }
    
    public function setAlternativa($alternativa) {
    	$this->alternativa = $alternativa;
    }
    
    public function getOrdem() {
    	return $this->ordem;
    }
    
    public function setOrdem($ordem) {
    	$this->ordem = $ordem;
    }
    
    public function getCorreta() {
    	return $this->correta;
    }
    
    public function setCorreta($correta) {
    	$this->correta = $correta;
    }
    
    public function getQuestao() {
    	return $this->questao;
    }
    
    public function setQuestao($questao) {
    	$this->questao = $questao;
    }

}