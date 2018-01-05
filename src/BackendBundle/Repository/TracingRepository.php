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
 * src/BackendBundle/Resources/config/doctrine/Tracing.orm.yml con la siguiente línea:
 * BackendBundle\Entity\Tracing:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\TracingRepository
 */
class TracingRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE EL ESTUDIO ORTOPODOLÓGICO ASOCIADO A UN ID HISTORIA MÉDICA ****************************/
	public function getTracing ( $medicalHistoryId ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('t')
      		->where('t.idMedicalHistory =:medicalHistoryId')
      		->setParameter('medicalHistoryId', $medicalHistoryId)
      		->getQuery();
		$tracing = $query->getResult();
		return $tracing;
	}
/*************************************************************************************************/
/* OBTIENE TRACING ASOCIADO A HISTORIA MÉDICA (SIN ESTUDIO) **************************************/
	public function getTracingMedicalHistoryQuery( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('t')
			->select('t.date, t.tracing, u.name, u.surnames, u.image, tr.typeTracing')
			->innerJoin('t.idMedicalHistory', 'mh', 'mh.id = t.idMedicalHistory')
			->innerJoin('mh.idClinic', 'cl', 'cl.id = mh.idClinic')
			->innerJoin('t.idUser', 'u', 'u.id = t.idUser')
			->innerJoin('t.idTypeTracing', 'tr', 'tr.id = t.idTypeTracing')
      		->where('mh.numberMedicalHistory =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl AND t.idTypeTracing =:idTypeTracing ')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
      		->setParameter('idTypeTracing', 1)
      		->getQuery();
		$tracing = $query->getResult();
		return $tracing;
	}
/*************************************************************************************************/
/* OBTIENE TRACING ASOCIADO A HISTORIA MÉDICA (SIN ESTUDIO) **************************************/
	public function getTracingMedicalHistoryObject( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('t')
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->innerJoin('t.user', 'u', 'u.id = t.user')
			->innerJoin('t.typeTracing', 'tr', 'tr.id = t.typeTracing')
      		->where('mh.numberMedicalHistory =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
      		->orderBy('t.date','ASC')
      		->getQuery();
		$tracing = $query->getResult();
		return $tracing;
	}
/*************************************************************************************************/
/* OBTIENE TRACING ASOCIADO A HISTORIA MÉDICA (CON ESTUDIO) **************************************/
	public function getTracingMedicalHistory_Orthopodology($clinicNameUrl, $medicalHistoryNumber){
		$em = $this->getEntityManager();
		$tracing = $this->createQueryBuilder('t')
			->select('t.id, t.date, t.tracing, u.name, u.surnames, u.image, tr.typeTracing')
			->innerJoin('t.idMedicalHistory', 'mh', 'mh.id = t.idMedicalHistory')
			->innerJoin('mh.idClinic', 'cl', 'cl.id = mh.idClinic')
			->innerJoin('t.idUser', 'u', 'u.id = t.idUser')
			->innerJoin('t.idTypeTracing', 'tr', 'tr.id = t.idTypeTracing')
      		->where('mh.numberMedicalHistory =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
			->orderBy('t.date','ASC')
      		->getQuery()
      		->getResult();
		foreach($tracing as $date=>$data){
			$tracingService = $em->getRepository('BackendBundle:TracingService')->findByIdTracing($data['id']);
			if(!empty($tracingService)){
				$tracing[$date]['services'] = $tracingService;
      		}else{
      			$tracing[$date]['services'] = array();
      		}
      	}
		return $tracing;
	}
/*************************************************************************************************/
}
