<?php
namespace Application\Controller;
 
use Zend\View\Model\ViewModel;
use Application\Form\Analise as AnaliseForm;
use Core\Controller\ActionController;
use Application\Model\Analise;
use Application\Model\Resultado;
 
use Doctrine\ORM\EntityManager;
 
/**
* Controlador que gerencia as questões
*
* @category Application
* @package Controller
* @author Paulo R. Silla <paulo.silla@embrapa.br>
*/
class QuestaoController extends ActionController
{
	/**
	* @var Doctrine\ORM\EntityManager
	*/
	protected $em;
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->em;
	}
	
	public function buscarAction() {
		$request = $this->getRequest();
		$response = $this->getResponse();
		$response->setContent(\Zend\Json\Json::encode(array('dataType' => 'json', 'response' => false)));
		if ($request->isPost()) {
			$grupo = $this->params()->fromPost('grupo');
			$qb = $this->getEntityManager()->createQueryBuilder();
			$qb->select('q')
		  	   ->from('Application\Model\Questao', 'q')
			   ->orderBy('q.id')
			   ->where('q.grupo = :grupo')
			   ->setParameter("grupo", $grupo);
			$resultados = $qb->getQuery()->getResult();
			$questoes = Array();
			$alternativas = Array();
			$gabarito = Array();
			foreach($resultados as $k => $q) {
				array_push($questoes, $q->getQuestao());
				
				$qb1 = $this->getEntityManager()->createQueryBuilder();
				$qb1->select('a')
				    ->from('Application\Model\Alternativa', 'a')
				    ->orderBy('a.ordem')
				    ->where('a.questao = :questao')
				    ->orderBy('a.ordem')
				    ->setParameter("questao", $q->id);
				$resAlternativas = $qb1->getQuery()->getResult();
				
				$resposta = "";
 				foreach($resAlternativas as $a) {
 					$resposta .= $a->getAlternativa()."&";
 					if ($a->correta == true) {
 						array_push($gabarito, $a->getOrdem());
 					}
 				}
 				array_push($alternativas, $resposta);
			}
			$response->setContent(\Zend\Json\Json::encode(array('dataType' 	=> 'json',
						'response' 	 	=> true,
						'questoes'   	=> $questoes,
 						'alternativas' 	=> $alternativas,
						'gabarito'     	=> $gabarito,
			)));
		}
		return $response;
	}
}
