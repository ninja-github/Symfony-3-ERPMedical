<?php
namespace BackendBundle\Repository;
/*
 * Un EntityRepository sirve como un repositorio para entidades con métodos genéricos y
 * específicos del negocio para recuperar entidades.
 * Esta clase está diseñada para herencia y los usuarios pueden clasificar esta clase para
 * escribir sus propios repositorios con métodos específicos de negocios para ubicar entidades.
 */
use Doctrine\ORM\EntityRepository;
/*
 * REPOSITORY
 * Es necesario definir el repositorio dentro del ORM, en este caso en
 * src/BackendBundle/Resources/config/doctrine/InvoiceIssued.orm.yml con la siguiente línea:
 * BackendBundle\Entity\InvoiceIssued:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\InvoiceIssuedRepository
 */
class InvoiceIssuedRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LAS FACTURAS ASOCIADAS A UNA CLÍNICA **************************************************/
	public function getInvoiceListOfClinic($clinicNameUrl){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('i')
      		->leftJoin('i.medicalHistory', 'mh', 'mh.id = i.medicalHistory')
      		->leftJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
      		->orWhere('cl.nameUrl =:nameUrl ')
      		->leftJoin('i.business', 'b', 'b.id = i.business')
      		/* Uso cl_ como alternativa a cl para evitar redeclarar una entidad ******************/
      		->leftJoin('b.clinic', 'cl_', 'cl_.id = b.clinic')
      		->orWhere('cl_.nameUrl =:nameUrl ')
      		->setParameter('nameUrl', $clinicNameUrl)
      		->orderBy('i.registrationDate', 'ASC')
      		->getQuery();
		$invoiceListOfClinic = $query->getResult();
		return $invoiceListOfClinic;
	}
/*************************************************************************************************/
/* OBTIENE LAS FACTURAS ASOCIADAS A UNA HISTORIA MÉDICA ******************************************/
	public function getInvoiceListOfMedicalHistory ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('i')
			->innerJoin('i.medicalHistory', 'mh', 'mh.id = i.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
      		->getQuery();
		$invoiceListOfMedicalHistory = $query->getResult();
		return $invoiceListOfMedicalHistory;
	}
/*************************************************************************************************/
/* OBTIENE LAS FACTURAS EMITIDAS SEGÚN AÑO *******************************************************/
public function getInvoiceIssuedListForYear ( $clinicNameUrl, $year ){
	$from = $year.'-01-01';
	$from = new \DateTime($from);
	$to   = $year.'-12-31';
	$to   = new \DateTime($to); 
	$em = $this->getEntityManager();
	$query = $this->createQueryBuilder('ii')
		->innerJoin('ii.clinic', 'cl', 'cl.id = ii.clinic')
		->where('cl.nameUrl=:clinicNameUrl')
		->andWhere('ii.registrationDate BETWEEN :from AND :to' )
		->orderBy('ii.registrationDate', 'ASC')
		->setParameter('clinicNameUrl', $clinicNameUrl)
		->setParameter('from', $from)
		->setParameter('to', $to)
		->getQuery()
		->getResult();
	return $query;
}
/*************************************************************************************************/
}