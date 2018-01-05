<?php
// src/BackendBundle/Utils/UserSession.php
namespace BackendBundle\Utils;

class UserSession {
	public function NewSession() {
		$userSession = new UserSession();
		$userSession->setIdUser($user);
		$userSession->setDatetime(new \DateTime("now"));
		 if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
				$ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else { 
				$ip = $_SERVER['REMOTE_ADDR'];
				}
		$userSession->setIp($ip);
		// persistimos los datos dentro de Doctrine
		$em->persist($userSession);
		// guardamos los datos persistidos dentro de la BD
		$flush = $em->flush();
	}
}