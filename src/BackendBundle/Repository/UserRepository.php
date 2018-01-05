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
 * src\BackendBundle\Resources\config\doctrine\User.orm.yml con la siguiente línea:
 * BackendBundle\Entity\User:
 *  type: entity
 *  repositoryClass: BackendBundle\Repository\UserRepository
 */
class UserRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LAS ÚLTIMAS DIEZ CLÍNICAS *************************************************************/
	public function getListTenLastUsers(){
		$em=$this->getEntityManager();
		$query = $this->createQueryBuilder('u')
				->orderBy('u.modificationDate', 'DESC')
				->setMaxResults(10)
				->getQuery();
		$listTenLastUsers = $query->getResult();
		return $listTenLastUsers;
	}
/*************************************************************************************************/
/* OBTIENE LOS USUARIOS DE UNA CLÍNICA ***********************************************************/
	public function getUserListOfClinic($clinicNameUrl){
		$em=$this->getEntityManager();
		$clinic_repo = $em->getRepository('BackendBundle:Clinic');
		$idClinic = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrl));
		$clinicUser_repo = $em->getRepository('BackendBundle:ClinicUser');
		$userListOfClinic = $clinicUser_repo->findBy(array('clinic'=>$idClinic));
		$userList = array();
		foreach($userListOfClinic as $user){
			array_push($userList, $user->getUser()->getId());
		}
		$user_repo = $em->getRepository('BackendBundle:User');
		$user = $user_repo->createQueryBuilder('u')
			->where("u.id IN (:userList)")
			->setParameter('userList', $userList);
		return $user;
	}
/*************************************************************************************************/
}