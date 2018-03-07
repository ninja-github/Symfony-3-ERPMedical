<?php
namespace BackendBundle\Repository;
/* Un EntityRepository sirve como un repositorio para entidades con métodos genéricos y específicos del negocio para recuperar entidades. Esta clase está diseñada para herencia y los usuarios pueden clasificar esta clase para escribir sus propios repositorios con métodos específicos de negocios para ubicar entidades. */
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;
/* REPOSITORY- Es necesario definir el repositorio dentro del ORM, en este caso en src/BackendBundle/Resources/config/doctrine/InvoiceService.orm.yml con la siguiente línea:
BackendBundle\Entity\Service:
    type: entity
    repositoryClass: BackendBundle\Repository\InvoiceServiceRepository
*/
class InvoiceServiceRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LA DATOS CONTABLES TOTALES POR MESES **************************************************/
	// array por meses con total contable y no contable
	// no incluye facturas en contable
	public function getAccountingTotal ( $clinicNameUrl, $year ){
		$from = $year.'-01-01';
		$from = new \DateTime($from);
		$to   = $year.'-12-31';
		$to   = new \DateTime($to); 
		$em=$this->getEntityManager();
		$invoiceService = $this->createQueryBuilder('is_')
			->innerJoin('is_.invoiceIssued', 'ii', 'ii.id = is_.invoiceIssued')			
			->innerJoin('ii.clinic', 'cl', 'cl.id = ii.clinic')
			->where('cl.nameUrl=:clinicNameUrl')
			->andWhere('ii.registrationDate BETWEEN :from AND :to' )
			->orderBy('ii.registrationDate', 'DESC')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		$forMonths = array();
		foreach($invoiceService as $date=>$value){
			$month = $value->getInvoiceIssued()->getRegistrationDate()->format('m');
			$tracingService = $value->getTracingService();
			if($tracingService == null){
				if( !isset($forMonths[$month]['countable']) ){
					$forMonths[$month]['countable'] = 0;
				}
				$forMonths[$month]['countable'] = $forMonths[$month]['countable'] + $value->getPrice(); 
			}
		}
		return $forMonths;
	}
/*************************************************************************************************/
}