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
 * src/BackendBundle/Resources/config/doctrine/Invoice.orm.yml con la siguiente línea:
 * BackendBundle\Entity\Invoice:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\InvoiceRepository
 */
class InvoiceRepository extends \Doctrine\ORM\EntityRepository {
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

}