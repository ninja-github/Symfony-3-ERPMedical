<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Component\HttpFoundation\Response;			// Permite usar el método Response, usado en AJAX	
	use Symfony\Component\Validator\Constraints\DateTime; 	// necesitamos esta librería para trabajar con fechas
	use Symfony\Component\HttpFoundation\ParameterBag;
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\UserSession;       			// Da acceso a la Entidad UserSession
	use BackendBundle\Entity\ScheduleGoogleCalendar;        // Da acceso a la Entidad ScheduleGoogleCalendar
	use BackendBundle\Entity\Tracing;       				// Da acceso a la Entidad Tracing
	use BackendBundle\Entity\TypeTracing;       				// Da acceso a la Entidad Tracing
/**************************************************************************************************************/
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\TracingType;							// Da acceso al Formulario TracingType
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
/* MÉTODO PARA VER EL CALENDARIO DE GOOGLE CON LOS EVENTOS ****************************************************/
	public function homeAction(Request $request, $clinicNameUrl = null, $userName = null) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
			$user_repo = $em->getRepository("BackendBundle:User");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$clinicUser_repo = $em->getRepository("BackendBundle:ClinicUser");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
			$typeTracing_repo = $em->getRepository("BackendBundle:TypeTracing"); 
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$userCalendar = $user_repo->findOneBy(array('userName'=>$userName));
			$clinicCalendar = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrl));
			if($clinicUser_repo->findOneBy(array('user'=>$userCalendar,'clinic'=>$clinicCalendar)) == NULL){
				$status = ['type'=>'danger','description'=>'No existe dicho usuario en esa clínica'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('homepage');
			}
			if($scheduleGoogleCalendar_repo->findOneBy(array('user'=>$userCalendar)) == NULL){
				$status = ['type'=>'danger','description'=>'No tiene cuenta de Google Calendar asociada'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('homepage');
			}
			$scheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array('user'=>$userCalendar));
			// Obtengo mi identificador como usuario en la API de Google Calendar	
			$refreshToken = $scheduleGoogleCalendar->getRefreshToken();
			$calendarId = $scheduleGoogleCalendar->getGoogleCalendarId();
			/* Cargamos la cuenta de Google Calendar *********************************************************/
				$request = $this->get('request_stack')->getMasterRequest();
				$googleCalendar = $this->get('fungio.google_calendar');
				$googleCalendar->clearTokens();
				//$googleCalendar->setRefreshToken(NULL);
				$googleCalendar->setRefreshToken($refreshToken);
			/*************************************************************************************************/
			// $date = new \DateTime('today');
			$start = new \DateTime('2018-02-01');
			$end = new \DateTime('2020-01-31');
			// $client = $googleCalendar->getClient();
			// $listCalendars = $googleCalendar->listCalendars();
			// $events = $googleCalendar->getEventsForDate($calendarId, $date);
			$eventsGoogleCalendar = $googleCalendar->getEventsOnRange($calendarId, $start, $end);
			$eventsDataBase = [];
			foreach ($eventsGoogleCalendar as $key => $value) {
				$idEventGoogleCalendar = $value->getId();
				$tracing = $tracing_repo->findOneBy(array('googleCalendarEvent'=>$idEventGoogleCalendar));
				if($tracing != NULL){
					$eventsDataBase[$idEventGoogleCalendar] = $tracing;
				}
			}
		/* CARGAMOS EL FORMULARIO tracingGoogleCalendar *******************************************************/
			$tracingGoogleCalendar = new Tracing();	
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>NULL, 'idTracing'=>NULL, 'userName'=>$userName);
			$form_tracingGoogleCalendar = $this->createForm(TracingType::class, $tracingGoogleCalendar,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			//var_dump($form_tracingGoogleCalendar->isSubmitted());var_dump($form_tracingGoogleCalendar->isValid());die();
			$form_tracingGoogleCalendar->handleRequest($request);
			if($form_tracingGoogleCalendar->isSubmitted()){
				if($form_tracingGoogleCalendar->isValid()){
					/* Recuperamos los datos del formualrio **************************************************/
						// Elementos del formulario enviados mediante REQUEST
						$googleCalendarEventId = $request->request->get('tracing')['googleCalendarEvent'];
						// Elementos del formulario enviados mediante POST
						$eventDescription = $request->get('description');
						$eventSummary = $request->get('title');
						$googleCalendarDateEventStart = $request->get('dateStartEvent');
						$googleCalendarTimeEventStart = $request->get('timeStartEvent');
						$googleCalendarTimeEventEnd = $request->get('timeEndEvent');
						$medicalHistoryDataComplete = $request->get('medicalHistoryDataComplete');
						$clinicNameUrlEvent = $request->get('clinicaNameUrl');
						$medicalHistoryNumberEvent = $request->get('medicalHistoryNumber');
						$idTracing = $request->get('idTracing');
					/*****************************************************************************************/
					/* Adaptamos fechas **********************************************************************/
						$eventStart = 
							date_create_from_format(
								'd/m/Y H:i P', 
								$googleCalendarDateEventStart.' '.$googleCalendarTimeEventStart.' +01:00'
							);
						//$eventEndDate = date_format( $eventStart, 'd/m/Y');
						//$googleCalendarEventEnd = $eventEndDate.' '.$googleCalendarEventEnd;
						$eventEnd = 
							date_create_from_format(
								'd/m/Y H:i P', 
								$googleCalendarDateEventStart.' '.$googleCalendarTimeEventEnd.' +01:00'
							);
						//$dateEvent = date_format($eventStart, 'Y-m-d H:i:s');var_dump($dateEvent);die();
					/*****************************************************************************************/	
					/* Existen dos casos: nuevo evento y editar evento ***************************************/
						/* Actuamos sobre Google Calendar ****************************************************/
							if( $request->request->get('tracing')['googleCalendarEvent'] == "" ){
								// nuevo evento
								$newEventGoogleCalendar = $googleCalendar->addEvent($calendarId, $eventStart, $eventEnd, $eventSummary, $eventDescription, $eventAttendee = "", $location = "", $optionalParams = [], $allDay = false);
								$googleCalendarEventId = $newEventGoogleCalendar->getId();
								$status = ['type'=>'success','description'=>'Nuevo evento creado correctamente en Google Calendar'];
							}elseif( $request->request->get('tracing')['googleCalendarEvent'] != "" ){
								// editamos evento
	        					$eventId = $request->request->get('tracing')['googleCalendarEvent'];
								$newEventGoogleCalendar = $googleCalendar->updateEvent($calendarId, $eventId, $eventStart, $eventEnd, $eventSummary, $eventDescription, $eventAttendee = "", $location = "", $optionalParams = [], $allDay = false);
								$status = ['type'=>'success','description'=>'Evento editado correctamente en Google Calendar'];
							}
						/*************************************************************************************/
						/* Actuamos sobre la BD **************************************************************/
							if( $idTracing != "" ){
								$tracing = $tracing_repo->findOneById($idTracing);
								$em->remove($tracing);	// persistimos los datos dentro de Doctirne
								$flush = $em->flush();
								$status = ['type'=>'danger','description'=>'El evento modificado ha eliminado la referencia de seguimiento anterior de la Base de Datos'];
							}
							if($medicalHistoryDataComplete != ""){
								// Paciente asociado
								// obtenemos los datos de la historia
								$strLenghtMedicalHistoryNumber = stripos($medicalHistoryDataComplete,' - ');
								$medicalHistoryNumberEvent = substr($medicalHistoryDataComplete,0,$strLenghtMedicalHistoryNumber);
								if($clinicNameUrlEvent == ""){ $clinicNameUrlEvent = $clinicNameUrl; }
								$clinicEvent = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrlEvent));
								$medicalHistoryEvent = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumberEvent,'clinic'=>$clinicEvent));
								$TypeTracing = $typeTracing_repo->findOneByType('medical_history');
								// Cargo los datos en la entidad
								$tracingNew = new Tracing();
								$tracingNew->setTypeTracing($TypeTracing);
								$tracingNew->setGoogleCalendarEvent($googleCalendarEventId);
								$tracingNew->setMedicalHistory($medicalHistoryEvent);
								$tracingNew->setUser($userCalendar);
								$tracingNew->setDate($eventStart);
								$tracingNew->setTracing($eventSummary.' - '.$eventDescription);
								$em->persist($tracingNew);
								// guardamos los datos persistidos dentro de la BD
								$flush = $em->flush();
								$status = ['type'=>'success','description'=>'Evento editado correctamente en la Base de datos'];
							}
						/*************************************************************************************/						
					/*****************************************************************************************/	
					$status = ['type'=>'success','description'=>'Evento creado/modificado correctamente'];
				}else{
					$status = ['type'=>'danger','description'=>'Error al crear/modificar el evento'];
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('schedule_home',
					array('clinicNameUrl'=>$clinicNameUrl, 'userName'=>$userName ));
			}
		/******************************************************************************************************/
		return $this->render('AppBundle:Schedule:schedule_Home.html.twig', 
			array (
				'permissionLoggedUser'=>$permissionLoggedUser,
				'eventsGoogleCalendar'=>$eventsGoogleCalendar,
				//'client'=>$client,
				//'APIKEY'=>$client->getAccessToken()['access_token'],
				//'googleCalendarId'=>'podologiapriego@gmail.com',
				'eventsDataBase'=>$eventsDataBase,
				// Formularios
				'form_tracingGoogleCalendar'=>$form_tracingGoogleCalendar->createView(),
			)
		);			
	}
/**************************************************************************************************************/	
/* MÉTODO AJAX MODIFICAR FECHAS EVENTOS ***********************************************************************/
	public function editTimeEventAjaxAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
			$event = $request->get('Event');
			$clinicNameUrl = $event[4];
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$permissionDenied = false;			
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userLogged));
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para visualizar una agenda ajena a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if( $permissionLoggedUser->getScheduleEdit() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para EDITAR una agenda.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/		
			// Busco dentro de la BD el dato
			$user = $userLogged;
			$scheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array('user'=>$user));
			$calendarId = $scheduleGoogleCalendar->getGoogleCalendarId();

		/* CARGO EL BUNDLE DE GOOGLE CALENDAR *****************************************************************/
			$this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
		/******************************************************************************************************/
		// Extraigo del request el eventId
			$event = $request->get('Event');
			$eventId = $event[0];
			$eventDate = $event[1];
			$eventTimeStart = $event[2];
			$eventTimeEnd = $event[3];
			$clinicNameUrl = $event[4];
		/* Busco el evento y extraigo Start, End y TimeZone ***************************************************/
			$eventGoogleCalendar = $googleCalendar->getEvent($calendarId, $eventId);
			$eventStartOriginal = $eventGoogleCalendar->getStart();
			$eventStartOriginalString = $eventStartOriginal->getDateTime();
			$eventStartOriginalDate =  date_create_from_format('Y-m-d\TH:i:sP', $eventStartOriginalString);
			$timeZone = date_format($eventStartOriginalDate , 'P');
			$eventEndOriginal = $eventGoogleCalendar->getEnd();
			$eventSummary = $eventGoogleCalendar->getSummary();
			$eventAttendee = "";
			$location = $eventGoogleCalendar->getLocation();
			$eventDescription = $eventGoogleCalendar->getDescription();
			$optionalParams = [];
			$allDay = false;
		// Extraemos y convertimos las nuevas fechas y horas a formato Google Calendar (incluido TimeZone)
			$eventStart= date_create_from_format('d-m-Y H:i:sP', $event[1].' '.$eventTimeStart.$timeZone);
			$eventEnd = date_create_from_format('d-m-Y H:i:sP', $event[1].' '.$eventTimeEnd.$timeZone);
			$googleCalendar->updateEvent($calendarId, $eventId, $eventStart, $eventEnd, $eventSummary, $eventDescription, $eventAttendee, $location, $optionalParams, $allDay);
		// Si existe el evento en la base de datos lo modifico
			$tracing = $tracing_repo->findOneBy(array('googleCalendarEvent'=>$eventId));
			if( $tracing != NULL ){
				$tracing->setDate($eventStart);
				$em->persist($tracing);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();
			}
		return new Response(
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					Evento modificado correctamente&nbsp;&nbsp;&nbsp;
				</div>');
	}
/**************************************************************************************************************/
/* MÉTODO AJAX MODIFICAR DATOS DEL EVENTO *********************************************************************/
	public function editEventAjaxAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		// Busco dentro de la BD el dato
		$user = $userlogged;
		$em = $this->getDoctrine()->getManager();
		$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
		$scheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array('user'=>$user));
		$calendarId = $scheduleGoogleCalendar->getGoogleCalendarId();
		/* CARGO EL BUNDLE DE GOOGLE CALENDAR *****************************************************************/
			$this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
		/******************************************************************************************************/
		// Extraigo del request el eventId
			$event = $request->get('Event');
			$eventId = $event[0];

		/* Busco el evento y extraigo Start, End y TimeZone ***************************************************/
			$eventGoogleCalendar = $googleCalendar->getEvent($calendarId, $eventId);
			$eventStartOriginal = $eventGoogleCalendar->getStart();
			$eventStartOriginalString = $eventStartOriginal->getDateTime();
			$eventStartOriginalDate =  date_create_from_format('Y-m-d\TH:i:sP', $eventStartOriginalString);
			$timeZone = date_format($eventStartOriginalDate , 'P');
			$eventEndOriginal = $eventGoogleCalendar->getEnd();
			$eventSummary = $eventGoogleCalendar->getSummary();
			$eventAttendee = "";
			$location = $eventGoogleCalendar->getLocation();
			$eventDescription = $eventGoogleCalendar->getDescription();
			$optionalParams = [];
			$allDay = false;
		// Extraemos y convertimos las nuevas fechas y horas a formato Google Calendar (incluido TimeZone)
			$eventStart= date_create_from_format('d-m-Y H:i:sP', $event[1].$timeZone);
			$eventEnd = date_create_from_format('d-m-Y H:i:sP', $event[2].$timeZone);
			$googleCalendar->updateEvent($calendarId, $eventId, $eventStart, $eventEnd, $eventSummary, $eventDescription, $eventAttendee, $location, $optionalParams, $allDay);
		return new Response(
				'<div class="alert alert-success fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					Evento modificado correctamente&nbsp;&nbsp;&nbsp;
				</div>');
	}
/**************************************************************************************************************/
/* MÉTODO CONFIGURAR GOOGLE CALENDAR **************************************************************************/
	public function configAction(Request $request, $userId) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
			$user = $em->getRepository("BackendBundle:User")->findOneById($userId);
			$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
			$scheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array('user'=>$user));
			if (!empty($scheduleGoogleCalendar) && $scheduleGoogleCalendar->getRefreshToken() != NULL){
				$userName = $user->getUserName();
				return $this->redirectToRoute('admin_user_view',array('userName'=>$userName));
			}
			if($user != NULL ){
				$newScheduleGoogleCalendar = new ScheduleGoogleCalendar();
				$newScheduleGoogleCalendar->setUser($user);
				$newScheduleGoogleCalendar->setgoogleCalendarId('primary');
				$em->persist($newScheduleGoogleCalendar);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();				
			}			
			$request = $this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
			$redirectUri = 'http://'.$request->server->get('HTTP_HOST').'/schedule_config';
			$googleCalendar->setRedirectUri($redirectUri);
			// Si no existe registro en la base de datos del usuario o el usuario no tiene RefreshToken almacenado 
			if( empty($scheduleGoogleCalendar) || $scheduleGoogleCalendar->getRefreshToken() == NULL ){
				if ($request->query->has('code') && $request->get('code')) {
					$client = $googleCalendar->getClient($request->get('code'), false);
				} else {
					$googleCalendar->setRefreshToken( NULL );
					$client = $googleCalendar->getClient( NULL, false );
				}
				/* ALMACENO NUEVO REFRESHTOKEN ****************************************************************/
					// Una vez que se genera el nuevo RefreshToken lo almaceno en la BD
					if( $googleCalendar->getRefreshToken() != NULL ){
						$refresh_token = $googleCalendar->getRefreshToken();
						$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
						$newScheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array(),array('id'=>'DESC'));
						$newScheduleGoogleCalendar->setRefreshToken($refresh_token);
						$em->persist($newScheduleGoogleCalendar);
						// guardamos los datos persistidos dentro de la BD
						$flush = $em->flush();	
					}
				/**********************************************************************************************/
				if (is_string($client)) {
				    return new RedirectResponse($client);
				}
			}
		$userName = $scheduleGoogleCalendar_repo->findOneBy(array(),array('id'=>'DESC'))->getUser()->getUserName();
		return $this->redirectToRoute('admin_user_view',array('userName'=>$userName));
	}
/**************************************************************************************************************/
/* MÉTODO LIMPIAR TOKENS GOOGLE CALENDAR **********************************************************************/
	public function cleanTokensAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
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
				$googleCalendar->setRefreshToken();
				$client = $googleCalendar->getClient(null, false);			    
			}
			if (is_string($client)) {
			    return new RedirectResponse($client);
			}
	}
/**************************************************************************************************************/
/* MÉTODO ELIMINAR EVENTOS GOOGLE CALENDAR ********************************************************************/
	public function removeEventAction(Request $request, $clinicNameUrl, $userName) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* Cargamos la cuenta de Google Calendar **************************************************************/
			$request = $this->get('request_stack')->getMasterRequest();
			$googleCalendar = $this->get('fungio.google_calendar');
		/******************************************************************************************************/					
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$scheduleGoogleCalendar_repo = $em->getRepository("BackendBundle:ScheduleGoogleCalendar");
			$user_repo = $em->getRepository("BackendBundle:User");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$clinicUser_repo = $em->getRepository("BackendBundle:ClinicUser");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$userCalendar = $user_repo->findOneBy(array('userName'=>$userName));
			$clinicCalendar = $clinic_repo->findOneBy(array('nameUrl'=>$clinicNameUrl));
			if($clinicUser_repo->findOneBy(array('user'=>$userCalendar,'clinic'=>$clinicCalendar)) == NULL){
				$status = ['type'=>'danger','description'=>'No existe dicho usuario en esa clínica'];
			}
			$scheduleGoogleCalendar = $scheduleGoogleCalendar_repo->findOneBy(array('user'=>$userCalendar));
			// Obtengo mi identificador como usuario en la API de Google Calendar	
			$refreshToken = $scheduleGoogleCalendar->getRefreshToken();
			$calendarId = $scheduleGoogleCalendar->getGoogleCalendarId();
			/* Cargamos la cuenta de Google Calendar *********************************************************/
				$request = $this->get('request_stack')->getMasterRequest();
				$googleCalendar = $this->get('fungio.google_calendar');
				$googleCalendar->setRefreshToken($refreshToken);
			/*************************************************************************************************/
			/* Obtengo id del Evento por el formulario *******************************************************/
				$eventId = $request->get('idEvent');
			/*************************************************************************************************/				
			$googleCalendar->deleteEvent($calendarId, $eventId);
			$status = ['type'=>'success','description'=>'Evento borrado de Google Calendar correctamente'];
			/* Modifico la Base de Datos *********************************************************************/
				$tracing = $tracing_repo->findOneBy(array('googleCalendarEvent'=>$eventId));
				if($tracing != NULL){
					$em->remove($tracing);
					$flush = $em->flush();
					$status = ['type'=>'success','description'=>'Evento borrado de la Base de Datos correctamente'];
				}
			/*************************************************************************************************/
		// generamos los mensajes FLASH (necesario activar las sesiones)
		$this->session->getFlashBag()->add("status", $status);
		return $this->redirectToRoute('schedule_home',
			array('clinicNameUrl'=>$clinicNameUrl, 'userName'=>$userName ));
	}
/**************************************************************************************************************/
}




/*	public function homeAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
/*			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
/*			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
/*			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
/*			$request = $this->get('request_stack')->getMasterRequest();
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
/*		return $this->render('AppBundle:Schedule:schedule_Home.html.twig', 
			array (
				'request'=>$request,
				'permissionLoggedUser'=>$permissionLoggedUser,
				'events'=>$events,
				'client'=>$client
			)
		);
	}
	*/
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