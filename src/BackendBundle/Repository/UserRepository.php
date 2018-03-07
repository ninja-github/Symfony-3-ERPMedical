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
/* OBTIENE LOS DOCTORES DE UNA CLÍNICA ***********************************************************/
	public function getUserDoctorListOfClinic($clinicNameUrl, $userLoggedId){
		$em=$this->getEntityManager();
		$clinic_repo = $em->getRepository('BackendBundle:Clinic');
		$userDataDoctor_repo = $em->getRepository('BackendBundle:UserDataDoctor');
		$clinic = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrl));
		$clinicUser_repo = $em->getRepository('BackendBundle:ClinicUser');
		$userListOfClinic = $clinicUser_repo->findBy(array('clinic'=>$clinic));
		// genero un array con los id de los usuarios de la clínica
		$userIdList = array();
		foreach($userListOfClinic as $user){
			$isDoctor = $userDataDoctor_repo->findOneByUser($user);
			if($isDoctor){
				array_push($userIdList, $user->getUser()->getId());
			}
		}
		if (in_array($userLoggedId, $userIdList)){
			unset($userIdList[array_search($userLoggedId, $userIdList)]);
			array_unshift($userIdList, $userLoggedId);
		}
		// Genero listado
		$user_repo = $em->getRepository('BackendBundle:User');
		$userList = $user_repo->createQueryBuilder('u')
			->where("u.id IN (:userIdList)")
			->setParameter('userIdList', $userIdList);
		return $userList;	
	}
/*************************************************************************************************/
/* OBTIENE LOS USUARIOS DE UNA CLÍNICA ***********************************************************/
	public function getUserListOfClinic($clinicNameUrl, $userLoggedId){
		$em = $this->getEntityManager();
		$clinic_repo = $em->getRepository('BackendBundle:Clinic');
		$user_repo = $em->getRepository('BackendBundle:User');
		$clinic = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrl));
		$clinicUser_repo = $em->getRepository('BackendBundle:ClinicUser');
		$userListOfClinic = $clinicUser_repo->findBy(array('clinic'=>$clinic));
		// genero un array con los id de los usuarios de la clínica
		$userIdList = array();
		foreach($userListOfClinic as $user){
			array_push($userIdList, $user->getUser()->getId());
		}
		if (in_array($userLoggedId, $userIdList)){
			unset($userIdList[array_search($userLoggedId, $userIdList)]);
			array_unshift($userIdList, $userLoggedId);
		}
		// Genero listado
		$user_repo = $em->getRepository('BackendBundle:User');
		$userList = $user_repo->createQueryBuilder('u')
			->where("u.id IN (:userIdList)")
			->setParameter('userIdList', $userIdList);
		return $userList;	
	}
/*************************************************************************************************/
}