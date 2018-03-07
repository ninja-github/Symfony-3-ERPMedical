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
/* OBTIENE LA DATOS CONTABLES PACIENTE ***********************************************************/
	// gastado y pagado
	public function getCostEarnings ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$tracingList = $this->createQueryBuilder('t')
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
			->getQuery()
			->getResult();
			$earnings = 0;
			$cost = 0;
			foreach( $tracingList as $tracing => $value){
				$paymentList = $value->getPaymentList();
				$tracingServiceList = $value->getTracingServiceList();
				foreach($paymentList as $payment => $value){
					$paymentService = $value->getPayment();
					$earnings = $earnings + $paymentService;
				}
				foreach($tracingServiceList as $tracingService => $value){
					$tracingServiceCost = $value->getPrice() *  ((100 - $value->getDiscount())/100);
					$cost = $cost + $tracingServiceCost;
				}
			}
			$getCostEarnings = ['cost'=>$cost, 'earnings'=>$earnings];
		return $getCostEarnings;
	}
/*************************************************************************************************/
/* OBTIENE LA DATOS CONTABLES TOTALES POR MESES **************************************************/
	// array por meses con total contable y no contable
	// no incluye facturas en contable
	public function getAccountingTotal ( $clinicNameUrl, $year ){
		$from = $year.'-01-01';
		$from = new \DateTime($from);
		$to   = $year.'-12-31';
		$to   = new \DateTime($to); 
		$em=$this->getEntityManager();
		$tracing = $this->createQueryBuilder('t')		
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')		
			->where('cl.nameUrl=:clinicNameUrl')
			->andWhere('t.date BETWEEN :from AND :to' )
			->orderBy('t.date', 'DESC')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		foreach($tracing as $date=>$value){
			$month = $value->getDate()->format('m');
			$paymentList = $value->getPaymentList();
			foreach($paymentList as $payment=>$value){
				if($value->getCountable()==true){
					if( !isset($forMonths[$month]['countable']) ){
						$forMonths[$month]['countable'] = 0;
					}
					$forMonths[$month]['countable'] = $forMonths[$month]['countable'] + $value->getPayment(); 
				}elseif($value->getCountable()==false){
					if( !isset($forMonths[$month]['noCountable']) ){
						$forMonths[$month]['noCountable'] = 0;
					}
					$forMonths[$month]['noCountable'] = $forMonths[$month]['noCountable'] + $value->getPayment(); 
				}
			}
		}
		return $forMonths;
	}
/*************************************************************************************************/
/* OBTIENE LA DATOS POR CONTABLES POR MESES ******************************************************/
	// array con mes del año y dentro los datos de pagos
	// Aún no incluye las facturas
	public function getAccountingSummary ( $clinicNameUrl, $year ){
		$from = $year.'-01-01';
		$from = new \DateTime($from);
		$to   = $year.'-12-31';
		$to   = new \DateTime($to); 
		$em=$this->getEntityManager();
		$tracing = $this->createQueryBuilder('t')		
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')		
			->where('cl.nameUrl=:clinicNameUrl')
			->andWhere('t.date BETWEEN :from AND :to' )
			->orderBy('t.date', 'DESC')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		$forMonths = array();
		foreach($tracing as $date=>$value){
			$month = $value->getDate()->format('m');
			if( !isset($forMonths[$month]) ){
				$forMonths[$month] = array();
			}
			array_push ($forMonths[$month], $value);
		}
		return $forMonths;

	}
/*************************************************************************************************/
/* OBTIENE LA DATOS CONTABLES (Sólo ingresos) DIARIOS POR MESES **********************************/
	// array por meses con total contable y no contable
	// no incluye facturas en contable
	public function getAccountingTotalForDay ( $clinicNameUrl, $year ){
		$from = $year.'-01-01';
		$from = new \DateTime($from);
		$to   = $year.'-12-31';
		$to   = new \DateTime($to); 
		$em = $this->getEntityManager();
		$tracing = $this->createQueryBuilder('t')		
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')		
			->where('cl.nameUrl=:clinicNameUrl')
			->andWhere('t.date BETWEEN :from AND :to' )
			->orderBy('t.date', 'ASC')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		$forMonths = array();
		foreach($tracing as $date=>$value){
			$month = $value->getDate()->format('m');
			$paymentList = $value->getPaymentList();
			foreach ($paymentList as $payment => $value) {
				$date = $value->getTracing()->getDate();
				$day = $date->format('d/m/Y');
				if(isset($forMonths[$month][$day])){
					$forMonths[$month][$day] = $forMonths[$month][$day] + $value->getPayment();
				}else{
					$forMonths[$month][$day] = $value->getPayment();
				}
			}
		}
		return $forMonths;
	}
/*************************************************************************************************/
/* OBTIENE LA AÑOS CONTABLES *********************************************************************/
	// devuelve array con los años de los que hay datos contables
	public function getAccountingOnlyYears ( $clinicNameUrl ){
		$em=$this->getEntityManager();
		$accountingRegistrationDates = $this->createQueryBuilder('t')
			->select('t.date')		
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')		
			->where('cl.nameUrl=:clinicNameUrl')
			->orderBy('t.date', 'DESC')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->getQuery()
			->getResult();
		$dates = array();
		foreach ($accountingRegistrationDates as $key => $value) {
			array_push($dates, $value['date']->format('Y'));
		}
		$accountingOnlyYears = array_unique($dates);
		return $accountingOnlyYears;
	}
/*************************************************************************************************/
}
