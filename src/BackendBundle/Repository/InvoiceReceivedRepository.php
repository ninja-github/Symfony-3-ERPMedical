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
 * src/BackendBundle/Resources/config/doctrine/InvoiceReceived.orm.yml con la siguiente línea:
 * BackendBundle\Entity\InvoiceReceived:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\InvoiceReceivedRepository
 */
class InvoiceReceivedRepository extends \Doctrine\ORM\EntityRepository {
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