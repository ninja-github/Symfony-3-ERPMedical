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
 * src/BackendBundle/Resources/config/doctrine/MedicalHistory.orm.yml con la siguiente línea:
 * BackendBundle\Entity\MedicalHistory:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\MedicalHistoryRepository
 */
class MedicalHistoryRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE EL LISTADO DE PACIENTES ***************************************************************/
	public function getMedicalHistoryListQuery( $clinicNameUrl ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('mh')
			->select( 'mh.medicalHistoryNumber', 'mh.name', 'mh.surname', 'mh.phoneHome', 'mh.phoneMobile', 'mh.dni', 'mh.patientRisk', 'tg.gender', 'cl.nameUrl')
			->innerJoin('mh.idGender', 'tg', 'tg.id = mh.idGender')
			->innerJoin('mh.idClinic', 'cl', 'cl.id = mh.idClinic')
			->where('cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->orderBy('mh.medicalHistoryNumber','ASC')
			->getQuery();
		$medicalHistories = $query->getResult();
		return $medicalHistories;
	}
/*************************************************************************************************/
/* OBTIENE LA INFORMACIÓN DEL PACIENTE ***********************************************************/
	public function getMedicalHistoryQuery ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$medicalHistory = $this->createQueryBuilder('mh')
			->select('mh.id', 'mh.medicalHistoryNumber', 'mh.name', 'mh.surname', 'mh.birthday', 'mh.address', 'mh.phoneHome', 'mh.email', 'mh.phoneMobile', 'mh.dni', 'mh.patientRisk', 'mh.reasonConsultation', 'mh.background', 'mh.allergicDiseases', 'mh.treatmentDiseases', 'mh.patologies', 'mh.supplementaryTest', 'mh.diagnostic',	 'mh.treatment', 'IDENTITY(mh.city) AS city', 'tg.type', 'cl.nameUrl'
			)
			->innerJoin('mh.gender', 'tg', 'tg.id = mh.gender')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
			->setMaxResults(1)
			->getQuery()
			->getSingleResult();
		if($medicalHistory['city'] == NULL){
			$medicalHistory['cp'] = NULL;$medicalHistory['city'] = NULL;$medicalHistory['province'] = NULL;
		}else{
			$Addresscity = $em->getRepository("BackendBundle:AddressCity")->findOneById($medicalHistory['city']);
			$medicalHistory['cp'] =$Addresscity->getCp();
			$medicalHistory['city'] =$Addresscity->getCity();
			$medicalHistory['province'] =$Addresscity->getProvince()->getProvince();
		}
		return $medicalHistory;
	}
/*************************************************************************************************/
/* OBTIENE LA ID DEL PACIENTE ********************************************************************/
	public function getMedicalHistoryIdQuery ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$medicalHistoryId = $this->createQueryBuilder('mh')
			->select('mh.id')
			->innerJoin('mh.idClinic', 'cl', 'cl.id = mh.idClinic')
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
			->getQuery()
			->getSingleResult();
		return $medicalHistoryId;
	}
/*************************************************************************************************/
/* OBTIENE LA ID DEL PACIENTE ********************************************************************/
	public function getMedicalHistoryObject ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$medicalHistory = $this->createQueryBuilder('mh')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
			->getQuery()
			->getSingleResult();
		return $medicalHistory;
	}
/*************************************************************************************************/
/* OBTIENE NÚMERO TOTAL DE PACIENTES DE LA CLÍNICA ***********************************************/
	public function getTotalNumberMedicalHistoriesQuery ( $clinicNameUrl ){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('mh')
	//		->select('mh')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->where('cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->getQuery();
		$numberHistories = count($query->getResult());
		return $numberHistories;
	}
/*************************************************************************************************/
/* OBTIENE RATIO SEXOS PACIENTES DE LA CÍNICA ****************************************************/
	public function getRatioGenderQuery ( $clinicNameUrl ){
		$genderStadisticsMedicalHistories = array();
		$em=$this->getEntityManager();
		//$typeGender_repo = $em->getRepository("BackendBundle:TypeGender");
		//$countTypeGender = count($typeGender_repo->findAll());
		$medicalHistoryList = $this->createQueryBuilder('mh')
					->select('mh')
					->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
					->where('cl.nameUrl=:clinicNameUrl')
					->setParameter('clinicNameUrl', $clinicNameUrl)
					->getQuery()
					->getResult();
		//$countMedicalHistory = count($medicalHistoryList);
		$typeGender_repo = $em->getRepository("BackendBundle:TypeGender");
		$TypeGenderList = $typeGender_repo->findAll();
		$genderStadisticsMedicalHistories = array();
		foreach($TypeGenderList as $key=>$value){
			$i = $key + 1 ;
			$genderStadisticsMedicalHistories[$i]['number'] = 0 ;
			$genderStadisticsMedicalHistories[$i]['gender'] = $value->getType();
			$genderStadisticsMedicalHistories[$i]['percent'] = 0 ;
		}
		$genderStadisticsMedicalHistories[0]['number'] = 0 ;
		$genderStadisticsMedicalHistories[0]['gender'] = null ;
		$genderStadisticsMedicalHistories[0]['percent'] = 0 ;
		foreach($medicalHistoryList as $key=>$value){
			$isGender = $value->getGender();
			if ($isGender != null){
				$i = $value->getGender()->getId();
				$genderStadisticsMedicalHistories[$i]['number']++;
				$genderStadisticsMedicalHistories[$i]['percent'] = ( $genderStadisticsMedicalHistories[$i]['number'] / ($key+1) ) * 100 ;
			}else{
				$genderStadisticsMedicalHistories[0]['number']++;
				$genderStadisticsMedicalHistories[0]['percent'] = ( $genderStadisticsMedicalHistories[0]['number'] / ($key+1) ) * 100;
			}
		}
		/*
		for( $i=1 ; $i < $countTypeGender+1; $i++ ){
			$gender = $typeGender_repo->findOneById($i)->getType();
			$userTypeGender = $this->createQueryBuilder('mh')
					->select('mh.medicalHistoryNumber','tg.type')
					->innerJoin('mh.gender','tg', 'tg.id = mh.gender')
					->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
					->where('cl.nameUrl=:clinicNameUrl AND tg.id =:gender')
					->setParameter('clinicNameUrl', $clinicNameUrl)
					->setParameter('gender', $i)
					->getQuery()
					->getResult();
			$genderStadisticsMedicalHistories[$i]['number'] = count($userTypeGender);
			$genderStadisticsMedicalHistories[$i]['gender'] = $gender;
			if( $countMedicalHistory != 0 ){
				$genderStadisticsMedicalHistories[$i]['percent'] = round ((count($userTypeGender) / $countMedicalHistory)*100);
			}else{
				$genderStadisticsMedicalHistories[$i]['percent'] = 0;
			}
		}
		*/
		return $genderStadisticsMedicalHistories;
	}
/*************************************************************************************************/
/* OBTIENE DATOS DE LA CLÍNICA HISTORIA MÍNIMA Y MÁXIMA ******************************************/
	public function getMedicalHistoryClinicalDataQuery( $clinicNameUrl ){
		$max_min = ['min'=>'ASC', 'max'=>'DESC'];
		foreach ($max_min as $type => $value){
			$query = $this->createQueryBuilder('mh')
						->select('mh.medicalHistoryNumber')
						->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
						->where('cl.nameUrl=:clinicNameUrl')
						->orderBy('mh.medicalHistoryNumber', $value)
						->setParameter('clinicNameUrl', $clinicNameUrl)
						->setMaxResults(1)
						->getQuery()
						->getResult();
			if(!empty($query)){
				$max_min[$type] = $query[0]['medicalHistoryNumber'];
			}else{
				$max_min[$type] = 0;
			}
		}
		return $max_min;
	}
/*************************************************************************************************/
/* OBTIENE DATOS DE LA CLÍNICA HISTORIA MÍNIMA Y MÁXIMA ******************************************/
	public function getMedicalHistoryPerMonthQuery( $clinicNameUrl ){
		$todayMonth = date("m");
		$medicalHistoryList = $this->createQueryBuilder('mh')
					->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
					->where('cl.nameUrl=:clinicNameUrl')
					->orderBy('mh.registrationDate', 'ASC')
					->setParameter('clinicNameUrl', $clinicNameUrl)
					->getQuery()
					->getResult();
		$newMedicalHistoryPerMonth = array();
		foreach($medicalHistoryList as $key=>$value){
			$registrationDate = $value->getRegistrationDate();
			if($registrationDate != null){
				$year = $registrationDate->format('Y');
				$month = $registrationDate->format('n');
				if(!isset ($newMedicalHistoryPerMonth[$year][$month])){
					$newMedicalHistoryPerMonth[$year][$month] = 0;
				}
				$newMedicalHistoryPerMonth[$year][$month] ++ ;
			}

		}
		return $newMedicalHistoryPerMonth;
	}
/*************************************************************************************************/
/* OBTIENE DATOS DE LA CLÍNICA HISTORIA MÍNIMA Y MÁXIMA ******************************************/
	public function getAllUserOfClinicObject ($clinicNameUrl) {
		$em = $this->getEntityManager();
		$clinicUser_repo = $em->getRepository("BackendBundle:ClinicUser") ;
		$allUserOfClinic = $clinicUser_repo->createQueryBuilder('cu')
			->select('cu')
			->innerJoin('mh.idClinic', 'cl', 'cl.id = mh.idClinic')
			->where('cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->getQuery()
			->getResult();
		return $allUserOfClinic;
	}
/*************************************************************************************************/
/* OBTIENE PACIENTES CLÍNICA SEGÚN BÚSQUEDA ******************************************************/
	public function searchMedicalHistory ($clinicNameUrl, $searchData) {
		$searchMedicalHistory = $this->createQueryBuilder('mh')
			->select('mh')
			->innerJoin('mh.idClinic', 'cl', 'cl.id = mh.idClinic')
			->where('cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('search', $searchData)
			->getQuery()
			->getResult();
		return $allUserOfClinic;
	}
/*************************************************************************************************/
}