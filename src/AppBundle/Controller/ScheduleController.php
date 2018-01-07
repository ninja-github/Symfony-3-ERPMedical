<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* COMPONENTES SESSIÓN ****************************************************************************************/	
	use Symfony\Component\HttpFoundation\Session\Session;
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\UserSession;        // Da acceso a la Entidad Historia Médica
/**************************************************************************************************************/
	use Symfony\Component\HttpFoundation\RedirectResponse;
class ScheduleController extends Controller {
	/* OBJETO SESSIÓN
	 * Para activar las sesiones inicializamos la variable e incluimos
	 * en ella el objeto Session()
	 * No olvidar dar acceso al componenete de Symfony
	 * Session() permitirá usar los mensajes FLASHBAG
	 */
	private $session;
	public function __construct(){
		$this->session = new Session();

	}
/*********************************************************************/
	public function homeAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
			$request = $this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
			if(isset($redirectUri)){
				$googleCalendar->setRedirectUri($redirectUri);
			}
			if ($request->query->has('code') && $request->get('code')) {
			    $client = $googleCalendar->getClient($request->get('code'), false);
			} else {
			    $client = $googleCalendar->getClient();
			}
			if (is_string($client)) {
			    return new RedirectResponse($client);
			}
			$refresh_token= '1/DDmKgwCoe7hrx7Fw-TRV_pU6OZQk5RnJkNbCnlZl_2A';
			$calendarId = 'primary';
			$date = new \DateTime('today');
			$date = new \DateTime('2018-01-08');
			// $googleCalendar->clearTokens(); // vacía el perfil del cliente
			// var_dump();die();
			$events = $googleCalendar->getEventsForDate($calendarId, $date);

		/******************************************************************************************************/
		return $this->render('AppBundle:Schedule:schedule_Home.html.twig', 
			array (
				'request'=>$request,
				'permissionLoggedUser'=>$permissionLoggedUser,
				'events'=>$events,
				'client'=>$client
			)
		);
	}
	public function configAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
			$request = $this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
			if(isset($redirectUri)){
				$googleCalendar->setRedirectUri($redirectUri);
			}
			if ($request->query->has('code') && $request->get('code')) {
			    $client = $googleCalendar->getClient($request->get('code'), false);
			} else {
			    //$client = $googleCalendar->getClient();
			$googleCalendar->setRefreshToken(null);
			$client = $googleCalendar->getClient(null, false);			    
			}
			if (is_string($client)) {
			    return new RedirectResponse($client);
			}
			$refresh_token= '1/DDmKgwCoe7hrx7Fw-TRV_pU6OZQk5RnJkNbCnlZl_2A';
			$calendarId = 'primary';
			$date = new \DateTime('today');
			$date = new \DateTime('2018-01-08');
			// $googleCalendar->clearTokens(); // vacía el perfil del cliente
			// var_dump();die();
			$events = $googleCalendar->getEventsForDate($calendarId, $date);

		/******************************************************************************************************/
		return $this->render('AppBundle:Schedule:schedule_Config.html.twig', 
			array (
				'request'=>$request,
				'permissionLoggedUser'=>$permissionLoggedUser,
				'events'=>$events,
				'client'=>$client
			)
		);
	}
	public function cleanTokensAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/	
			$request = $this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
			if(isset($redirectUri)){
				$googleCalendar->setRedirectUri($redirectUri);
			}
			if ($request->query->has('code') && $request->get('code')) {
			    $client = $googleCalendar->getClient($request->get('code'), false);
			} else {
			    //$client = $googleCalendar->getClient();
				$googleCalendar->setRefreshToken(null);
				$client = $googleCalendar->getClient(null, false);			    
			}
			if (is_string($client)) {
			    return new RedirectResponse($client);
			}
	}
}
/*

$googleCalendar = $this->get('fungio.google_calendar');
$googleCalendar->setRedirectUri('http://website.com/blahblahlah');
if ($request->query->has('code') && $request->get('code')) {
	$client = $googleCalendar->getClient($request->get('code'), false);
} else {
	$googleCalendar->setRefreshToken($REFRESH_TOKEN);
	$client = $googleCalendar->getClient(null, false);
}
if (is_string($client)) {
	return new RedirectResponse($client);
}