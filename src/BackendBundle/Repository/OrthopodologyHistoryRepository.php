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
 * src/BackendBundle/Resources/config/doctrine/OrthopodologyHistory.orm.yml con la siguiente línea:
 * BackendBundle\Entity\OrthopodologyHistory:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\OrthopodologyHistoryRepository
 */
class OrthopodologyHistoryRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE EL LISTADO COMPLETO DE ESTUDIOS ORTOPODOLÓGICOS ASOCIADOS A UNA CLÍNICA ***************/
	public function getOrthopodologyHistoryListOfClinic($clinicNameUrl){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('oh')
      		->innerJoin('oh.medicalHistory', 'mh', 'mh.id = oh.medicalHistory')
      		->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
      		->innerJoin('mh.gender', 'tg', 'tg.id = mh.gender')      		
      		->where('cl.nameUrl =:nameUrl ')
      		->setParameter('nameUrl', $clinicNameUrl)
      		->getQuery();
		$orthopodologyHistoriesListOfClinic = $query->getResult();
		return $orthopodologyHistoriesListOfClinic;
	}
/*************************************************************************************************/
/* OBTIENE LOS ESTUDIOS ORTOPODOLÓGICOS ASOCIADOS A UNA ID HISTORIA MÉDICA ***********************/
	public function getOrthopodologyHistoryListOfMedicalHistory ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('oh')
			->innerJoin('oh.medicalHistory', 'mh', 'mh.id = oh.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')			
			->where('mh.numberMedicalHistory =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
      		->getQuery();
		$orthopodologyHistory = $query->getResult();
		return $orthopodologyHistory;
	}
/*************************************************************************************************/
/* OBTIENE EL ESTUDIO ORTOPODOLÓGICO ASOCIADO ****************************************************/
	public function getOrthopodologyHistoryQuery($clinicNameUrl, $medicalHistoryNumber, $registrationDate){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('oh')
			->select ('oh','mh')
      		->innerJoin('oh.medicalHistory', 'mh', 'mh.id = oh.medicalHistory')
      		->innerJoin('mh.clinic', 'c', 'c.id = mh.clinic')
      		->where('c.nameUrl =:nameUrl AND mh.numberMedicalHistory =:medicalHistoryNumber')
      		->setParameter('nameUrl', $clinicNameUrl)
      		->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
      		->getQuery();
		$orthopodologyHistories = $query->getResult();
		foreach ($orthopodologyHistories as $orthopodologyHistory){
			$orthopodologyHistory_RegistrationDate = $orthopodologyHistory->getRegistrationDate()->format('Y_m_d');
			if ($orthopodologyHistory_RegistrationDate == $registrationDate){return $orthopodologyHistory;}
		}
	}
/*************************************************************************************************/
/* OBTIENE EL ESTUDIO ORTOPODOLÓGICO ASOCIADO A UN ID HISTORIA MÉDICA + FECHA DE REGISTRO ********/
/*	public function getOrthopodologyHistory ($medicalHistoryId, $registrationDate){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('oh')
      		->where('oh.idMedicalHistory =:medicalHistoryId')
      		->setParameter('medicalHistoryId', $medicalHistoryId)
      		->getQuery();
		$orthopodologyHistories = $query->getResult();
		foreach ($orthopodologyHistories as $orthopodologyHistory){
			$orthopodologyHistory_RegistrationDate = $orthopodologyHistory->getRegistrationDate()->format('Y_m_d');
			if ($orthopodologyHistory_RegistrationDate == $registrationDate){return $orthopodologyHistory;}
		}
	}*/
/*************************************************************************************************/
}