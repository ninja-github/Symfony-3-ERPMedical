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
 * src/BackendBundle/Resources/config/doctrine/Payment.orm.yml con la siguiente línea:
 * BackendBundle\Entity\Payment:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\PaymentRepository
 */
class PaymentRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LA DATOS CONTABLES (Sólo ingresos) DIARIOS POR MESES **********************************/
	// array por meses con total contable y no contable
	// no incluye facturas en contable
	public function getAccountingTotalForDay ( $clinicNameUrl, $year ){
		$from = $year.'-01-01';
		$from = new \DateTime($from);
		$to   = $year.'-12-31';
		$to   = new \DateTime($to); 
		$em = $this->getEntityManager();
		$paymentList = $this->createQueryBuilder('p')
			->where('p.date BETWEEN :from AND :to' )
			->orderBy('p.date', 'ASC')
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		//var_dump(count($fromTracing));var_dump(count($fromInvoiceIssued));var_dump(count($paymentList));die();
		$forMonths = array();
		foreach($paymentList as $date=>$value){
			$tracing = $value->getTracing();
			$invoiceIssued = $value->getInvoiceIssued();
			if( ($tracing != null and $tracing->getMedicalHistory()->getClinic()->getNameUrl() == $clinicNameUrl) or ($invoiceIssued != null and $invoiceIssued->getClinic()->getNameUrl() == $clinicNameUrl ) ){
				$month = $value->getDate()->format('m');
				$day = $value->getDate()->format('d/m/Y');
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
/* OBTIENE LA DATOS CONTABLES (Sólo ingresos) DIARIOS POR MESES **********************************/
	// array por meses con total contable y no contable
	// no incluye facturas en contable
	public function getAccountingTotal ( $clinicNameUrl, $date ){
		//FECHA INGLESA
		$date = new \DateTime($date);
		$from = $date->modify('first day of this year')->format('Y-m-d');
		$to   = $date->modify('last day of this year')->format('Y-m-d');
		$em = $this->getEntityManager();
		$paymentList = $this->createQueryBuilder('p')
			->where('p.date BETWEEN :from AND :to' )
			->orderBy('p.date', 'ASC')
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		$accountingTotal = array();
		foreach($paymentList as $date=>$value){
			$tracing = $value->getTracing();
			$invoiceIssued = $value->getInvoiceIssued();
			if( ($tracing != null and $tracing->getMedicalHistory()->getClinic()->getNameUrl() == $clinicNameUrl) or ($invoiceIssued != null and $invoiceIssued->getClinic()->getNameUrl() == $clinicNameUrl ) ){
				$stateCountable = $value->getCountable();
				$payment = $value->getPayment();
				$datePayment = $value->getDate();
				$month = $datePayment->format('m');
				if(!isset($accountingTotal[$month])){
					$accountingTotal[$month]['countable'] = 0;
					$accountingTotal[$month]['noCountable'] = 0;
				}
				if($stateCountable){
					$accountingTotal[$month]['countable'] = $accountingTotal[$month]['countable'] + $payment;
				}else{
					$accountingTotal[$month]['noCountable'] = $accountingTotal[$month]['noCountable'] + $payment;
				}
			}
		}
		return $accountingTotal;
	}
/*************************************************************************************************/
/* OBTIENE LA DATOS CONTABLES (Sólo ingresos) DIARIOS POR MESES **********************************/
	// array por meses con total contable y no contable
	// no incluye facturas en contable
	public function getAccountingTotalYear ( $clinicNameUrl, $year ){
		//FECHA INGLESA
		$date = new \DateTime($date);
		$from = $date->modify('first day of this year')->format('Y-m-d');
		$to   = $date->modify('last day of this year')->format('Y-m-d');
		$em = $this->getEntityManager();
		$paymentList = $this->createQueryBuilder('p')
			->where('p.date BETWEEN :from AND :to' )
			->orderBy('p.date', 'ASC')
			->setParameter('from', $from)
			->setParameter('to', $to)
			->getQuery()
			->getResult();
		//var_dump(count($fromTracing));var_dump(count($fromInvoiceIssued));var_dump(count($paymentList));die();
		$accountingTotal = array();
		foreach($paymentList as $date=>$value){
			$tracing = $value->getTracing();
			$invoiceIssued = $value->getInvoiceIssued();
			if( ($tracing != null and $tracing->getMedicalHistory()->getClinic()->getNameUrl() == $clinicNameUrl) or ($invoiceIssued != null and $invoiceIssued->getClinic()->getNameUrl() == $clinicNameUrl ) ){
				$stateCountable = $value->getCountable();
				$payment = $value->getPayment();
				$datePayment = $value->getDate();
				$month = $datePayment->format('m');
				if(!isset($accountingTotal[$month])){
					$accountingTotal[$month]['countable'] = 0;
					$accountingTotal[$month]['noCountable'] = 0;
				}else{
					if($stateCountable){
						$accountingTotal[$month]['countable'] = $accountingTotal[$month]['countable'] + $payment;
					}else{
						$accountingTotal[$month]['noCountable'] = $accountingTotal[$month]['noCountable'] + $payment;
					}
				}
			}
		}
		return $accountingTotal;
	}
/*************************************************************************************************/
}