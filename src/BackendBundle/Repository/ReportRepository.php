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
 * src/BackendBundle/Resources/config/doctrine/Report.orm.yml con la siguiente línea:
 * BackendBundle\Entity\Report:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\ReportRepository
 */
class ReportRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LOS INFORMES ASOCIADOS A UNA CLÍNICA **************************************************/
	public function getReportListOfClinic($clinicNameUrl){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('r')
      		->innerJoin('r.medicalHistory', 'mh', 'mh.id = r.medicalHistory')
      		->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
      		->where('cl.nameUrl =:nameUrl ')
      		->setParameter('nameUrl', $clinicNameUrl)
      		->getQuery();
		$reportListOfClinic = $query->getResult();
		return $reportListOfClinic;
	}
/*************************************************************************************************/
/* OBTIENE LOS INFORMES ASOCIADOS A UNA HISTORIA MÉDICA ******************************************/
	public function getReportListOfMedicalHistory ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('r')
			->innerJoin('r.medicalHistory', 'mh', 'mh.id = r.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')			
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
      		->getQuery();
		$reportListOfMedicalHistory = $query->getResult();
		return $reportListOfMedicalHistory;
	}
/*************************************************************************************************/
}