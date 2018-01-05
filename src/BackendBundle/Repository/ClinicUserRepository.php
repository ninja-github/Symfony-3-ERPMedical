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
 * src\BackendBundle\Resources\config\doctrine\Clinic.orm.yml con la siguiente línea:
 * BackendBundle\Entity\Clinic:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\ClinicRepository
 */
class ClinicUserRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LAS ÚLTIMAS DIEZ CLÍNICAS *************************************************************/
	public function getDataClinicUserSession($idUser){
		$em=$this->getEntityManager();
		$dataClinicUserSession = $this->createQueryBuilder('cu')
			->select('u.userName,c.nameUrl,c.image,c.name')
			->innerJoin('cu.user', 'u', 'u.id = cu.user')
			->innerJoin('cu.clinic','c', 'c.id = cu.clinic')
			->where('cu.user =:user')
			->setParameter('user', $idUser)
			->setMaxResults(1)			
			->getQuery()
			->getSingleResult();
		return $dataClinicUserSession;
	}
/*************************************************************************************************/
/* OBTIENE LOS USUARIOS DE UNA CLÍNICA ***********************************************************/
/*	public function getUserListOfClinic($clinicNameUrl){
		$em=$this->getEntityManager();
		$userListOfClinic = $this->createQueryBuilder('cu')
			->select('u.id')
			->innerJoin('cu.idUser','u', 'u.id = cu.idUser')
			->innerJoin('cu.idClinic','c', 'c.id = cu.idClinic')
			->where('c.nameUrl =:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->orderBy('u.userName', 'ASC');
			->getQuery()
			->getSingleResult();
		return $userListOfClinic;
	}*/
/*************************************************************************************************/
}
			