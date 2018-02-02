<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\JsonResponse;		// Permite usar Json Response
	use Symfony\Component\HttpFoundation\Response;  		// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session; 	// Permite usar sesiones, usado en FLASHBAG
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\AddressCity;        	// Da acceso a la Entidad AddressCity
/* Incluimos la clase del Controlador *************************************************************************/
class AddressCityController extends Controller {
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO AJAX BUSCAR CIUDAD **********************************************************************************/
	public function searchCityAction(Request $request) {
		// Guardamos dentro de la variable $cityInformation el dato que nos llega por POST
		$cityInformation = $request->get('cityInformation');
		// Busco dentro de la BD el dato
		$em = $this->getDoctrine()->getManager();
		$addressCity_repo = $em->getRepository('BackendBundle:AddressCity');
		$result = $addressCity_repo->searchCity($cityInformation);
		return new Response(json_encode($result)); // codificamos la respuesta en JSON
	}
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR CIUDADES ********************************************************************************/
	public function addressCityListAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
		$user = $this->getUser();	// extraemos el usuario de la sessión
		$userSession_repo = $em->getRepository("BackendBundle:UserSession");
		$setUserInformation = $userSession_repo->setUserInformation($user, $request);
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
		$userName = $user->getUserName();
		$userPermission_repo = $em->getRepository("BackendBundle:UserPermission");
		$userPermission = $userPermission_repo->getUserPermission($userName);
		/******************************************************************************************************/
		$addressCity_repo = $em->getRepository("BackendBundle:AddressCity");
		$addressCity = $addressCity_repo->findBy( array(), array('cp' => 'ASC'));
		$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
      									$addressCity,
      									$request->query->getInt('page',1),
      									10);
		return $this->render('AppBundle:Admin:addressCity_List.html.twig',
			array(
				'userPermission'=>$userPermission,
				'addressCityPagination'=>$pagination,
			)
		);
	}
/**************************************************************************************************************/
}
