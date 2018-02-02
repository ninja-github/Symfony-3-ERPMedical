<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Response;			// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session;	// Permite usar sesiones, usado en FLASHBAG
	use Symfony\Component\Validator\Constraints\DateTime;
/* Añadimos la LIBRERIA Html2Pdf ******************************************************************************/
	use Spipu\Html2Pdf\Html2Pdf;    // Objeto Base de Html2Pdf
/* Añadimos las ENTIDADES que usaremos ************************************************************************/	
	use BackendBundle\Entity\MedicalHistory;		// Da acceso a la Entidad Historia Médica
	use BackendBundle\Entity\MedicalHistoryDoc;		// Da acceso a la Entidad Historia Médica Doc
	use BackendBundle\Entity\Tracing;				// Da acceso a la Entidad Tracing
	use BackendBundle\Entity\Clinic;				// Da acceso a la Entidad Clinica
	use BackendBundle\Entity\ClinicUser;			// Da acceso a la Entidad ClinicaUser
	use BackendBundle\Entity\AddressCity;			// Da acceso a la Entidad AddressCity
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\MedicalHistoryType;			// Da acceso al Formulario MedicalHistoryType
	use AppBundle\Form\MedicalHistoryDocType;		// Da acceso al Formulario MedicalHistoryDocType
	use AppBundle\Form\TracingType;					// Da acceso al Formulario TracingType
/**************************************************************************************************************/
class MedicalHistoryController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR USUARIOS ********************************************************************************/
	public function medicalHistoryListAction(Request $request, $clinicNameUrl = null, $searchMedicalHistory = null){
		/* si existe el objeto User nos rediriges a home            */
		if( !is_object($this->getUser()) ){ return $this->redirect('home'); }
		/******************************************************************************************************/
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
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
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para visualizar un listado de Historias Médicas ajenas a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if( $permissionLoggedUser->getMedicalHistoryList() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para visualizar un listado de Historias Médicas.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:MedicalHistory:medicalHistory_List.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'clinicView'=>$clinicView
				)
			);
		/******************************************************************************************************/ 		
	}
/**************************************************************************************************************/
/* MÉTODO PARA VER HISTORIA CLINICA ***************************************************************************/
	public function medicalHistoryViewAction(Request $request, $clinicNameUrl = null, $medicalHistoryNumber = null){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
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
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para VISUALIZAR una Historia Médica ajena a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if( $permissionLoggedUser->getMedicalHistoryView() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para VISUALIZAR una Historia Médica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }			
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$orthopodologyHistories_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
			$typeTracing_repo = $em->getRepository("BackendBundle:TypeTracing");
			$medicalHistoryDoc_repo = $em->getRepository("BackendBundle:MedicalHistoryDoc");
			$typeDoc_repo = $em->getRepository("BackendBundle:TypeDoc");
			$service_repo = $em->getRepository("BackendBundle:Service");
			$tracingService_repo = $em->getRepository("BackendBundle:TracingService");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");		
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			// Realizamos las consultas // funciones Repositorio usadas, ver 'src\BackendBundle\Repository'
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(
				array(
					'clinic'=>$clinic,
					'medicalHistoryNumber'=>$medicalHistoryNumber));
			$medicalHistoryDocList = $medicalHistoryDoc_repo->findByMedicalHistory($medicalHistory);
			/* $medicalHistoryData -> Devuelve el número mínimo, máximo y número total */
			$medicalHistoryData = array(
				'min'=>$medicalHistory_repo->findOneBy(['clinic'=>$clinic],['medicalHistoryNumber'=>'ASC'])->getMedicalHistoryNumber(),
				'max'=>$medicalHistory_repo->findOneBy(['clinic'=>$clinic],['medicalHistoryNumber'=>'DESC'])->getMedicalHistoryNumber()
			);
			// Extraemos $tracingMedicalHistoryList para ordenarlos por Fecha
			$tracingMedicalHistoryList = $tracing_repo->findBy(['medicalHistory'=>$medicalHistory],['date'=>'DESC']);
		/******************************************************************************************************/		
		/* FORMULARO NUEVO SEGUIMIENTO ************************************************************************/
			$tracingNew = new Tracing();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'idTracing'=>NULL, 'userName'=> NULL);
			$form_medicalHistoryTracing = $this->createForm(TracingType::class, $tracingNew,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form_medicalHistoryTracing->handleRequest($request);
			if($form_medicalHistoryTracing->isSubmitted()){
				if(!array_key_exists('id', $request->request->get('tracing'))) {
					/* Nuevo  seguimiento **********************************************************************/
						if($form_medicalHistoryTracing->isValid()){
							$em = $this->getDoctrine()->getManager();
							if($form_medicalHistoryTracing->get("date")->getData() == null){
								$tracingNew->setDate(new \DateTime("now"));
							}else{
								$tracingNew->setDate($form_medicalHistoryTracing->get("date")->getData());
							}
							$tracingNew->setTracing($form_medicalHistoryTracing->get("tracing")->getData());
							$tracingNew->setUser($userLogged);
							if(!isset($registrationDate) or $registrationDate==null){
								$TypeTracing = $typeTracing_repo->findOneByType('medical_history');
							}else{
								$TypeTracing = $typeTracing_repo->findOneByType('orthopodology_history');
							}
							$tracingNew->setTypeTracing($TypeTracing);
							$tracingNew->setOrthopodologyHistory( NULL );
							$tracingNew->setMedicalHistory($medicalHistory);
							// persistimos los datos dentro de Doctirne
							$em->persist($tracingNew);
							// guardamos los datos persistidos dentro de la BD
							$flush = $em->flush();
							// Si se guardan correctamente los datos en la BD
							$status = ['type'=>'success','description'=>'Se ha creado un nuevo seguimiento para la Historia Clínica número '.$medicalHistoryNumber];		
						}else{
							$status = [	'type'=>'danger','description'=>'No se ha creado un nuevo seguimiento correctamente'];							
						}
					/*******************************************************************************************/
				}elseif(array_key_exists('id', $request->request->get('tracing'))) {
					/* Editamos el seguimiento *****************************************************************/
						if($form_medicalHistoryTracing->isValid()){
							$em = $this->getDoctrine()->getManager();
							$idTracing = $request->request->get('tracing')['id'];
							$tracingEdit = $tracing_repo->findOneById($idTracing);
							$tracingEdit->setDate($form_medicalHistoryTracing->get("date")->getData());
							$tracingEdit->setTracing($form_medicalHistoryTracing->get("tracing")->getData());
							$tracingEdit->setUser($userLogged);
							$tracingEdit->setTypeTracing( $tracingEdit->getTypeTracing() );
							$tracingEdit->setOrthopodologyHistory( NULL );
							$tracingEdit->setMedicalHistory($medicalHistory);
							// persistimos los datos dentro de Doctirne
							$em->persist($tracingEdit);
							// guardamos los datos persistidos dentro de la BD
							$flush = $em->flush();
							// Si se guardan correctamente los datos en la BD
							$status = ['type'=>'success','description'=>'Se ha editado el seguimiento para la Historia Clínica número '.$medicalHistoryNumber];			
						}else{
							$status = [	'type'=>'danger','description'=>'No se ha editado el seguimiento correctamente'];				
						}
					/*******************************************************************************************/
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('medical_history_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber));
			}
		/******************************************************************************************************/
		/* FORMULARO EDITAR SEGUIMIENTOS **********************************************************************/
			/* Generamos la Vista, el formulario se gestiona en Nuevo con el condicional de si lleva id o no el formulario */
			$tracingMedicalHistoryListForm = array();
			if( !empty($tracingMedicalHistoryList) ){
				foreach($tracingMedicalHistoryList as $tracingMedicalHistoryDate => $tracingEdit){
					$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'idTracing'=>"NO NULL", 'userName'=> NULL);
					$form_medicalHistoryTracingEdit = $this->createForm(TracingType::class,
						$tracingEdit,
						array(
							'allow_extra_fields'=> $permissionLoggedUser,
							'attr'=> $attr
						)
					);
					$tracingMedicalHistoryListForm[$tracingEdit->getId()] = $form_medicalHistoryTracingEdit->createView();
				}
			}
		/******************************************************************************************************/
		/* FORMULARO SUBIR NUEVO DOCUMENTO ********************************************************************/
			$medicalHistoryDoc = new MedicalHistoryDoc();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber);
			$form_medicalHistoryDoc = $this->createForm(MedicalHistoryDocType::class, $medicalHistoryDoc,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form_medicalHistoryDoc->handleRequest($request);
			if($form_medicalHistoryDoc->isSubmitted()){
				if($form_medicalHistoryDoc->isValid()){
					$em = $this->getDoctrine()->getManager();
					// Upload file
					$file = $form_medicalHistoryDoc["doc"]->getData();
					$title = str_replace( " ", "_", strtolower( $form_medicalHistoryDoc["title"]->getData() ) );
					// extraemos la extensión del fichero
					$ext = $file->guessExtension();
					if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif' || $ext=='pdf'){
						if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){
							$typeDoc = $typeDoc_repo->findOneByType("image");
						}else{
							$typeDoc = $typeDoc_repo->findOneByType("pdf");
						}
						// renombramos el archivo con el idUser+fecha+extensión
						$file_name = $title.'.'.$ext;
						// movemos el fichero
						$file->move('uploads/clinics/'.$clinicNameUrl.'/medicalHistory/'.$medicalHistoryNumber.'/',$file_name);
						$medicalHistoryDoc->setDoc($file_name);
						$medicalHistoryDoc->setTitle($form_medicalHistoryDoc["title"]->getData());
						$medicalHistoryDoc->setDescription($form_medicalHistoryDoc["description"]->getData());
						$medicalHistoryDoc->setTypeDoc($typeDoc);
						$medicalHistoryDoc->setModificationDate(new \DateTime("now"));
						$medicalHistoryDoc->setRegistrationDate(new \DateTime("now"));
						$medicalHistoryDoc->setUserModifier($this->getUser());
						$medicalHistoryDoc->setUserRegisterer($this->getUser());
						$medicalHistoryDoc->setMedicalHistory($medicalHistory);
						// persistimos los datos dentro de Doctirne
						$em->persist($medicalHistoryDoc);
						// guardamos los datos persistidos dentro de la BD
						$flush = $em->flush();
						// Si se guardan correctamente los datos en la BD
						$status = ['type'=>'success','description'=>'Se ha subido el documento correctamente'];
					}else{
						$status = [	'type'=>'danger','description'=>'No se ha subido el documento correctamente. Por favor, revisa la extensión del documento'];
					}
				}else{
					$status = [	'type'=>'danger','description'=>'No se ha subido el documento correctamente'];
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('medical_history_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber ));
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/ 
			return $this->render('AppBundle:MedicalHistory:medicalHistory_View.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'medicalHistory' => $medicalHistory,
					'medicalHistoryData' => $medicalHistoryData,
					'tracingMedicalHistoryList'=>$tracingMedicalHistoryList,
					'form_medicalHistoryTracing'=>$form_medicalHistoryTracing->createView(),
					'form_medicalHistoryDoc'=>$form_medicalHistoryDoc->createView(),
					'form_tracingMedicalHistoryList'=>$tracingMedicalHistoryListForm
				)
			);
		/******************************************************************************************************/ 		
	}
/**************************************************************************************************************/
/* MÉTODO PARA CREAR HISTORIA CLINICA *************************************************************************/
	public function medicalHistoryCreateAction(Request $request, $clinicNameUrl = null){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$permissionDenied = false;			
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userLogged));
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para CREAR Historias Médicas ajenas a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if( $permissionLoggedUser->getMedicalHistoryCreate() == false ){
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para CREAR Historias Médicas.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}			
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");			
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$MedicalHistoryClinicalData = $medicalHistory_repo->getMedicalHistoryClinicalDataQuery($clinicNameUrl);
			if($MedicalHistoryClinicalData['max']==0){
				$medicalHistoryNumber = 101;
			}else{
				$medicalHistoryNumber = $MedicalHistoryClinicalData['max']+1;
			}
		/******************************************************************************************************/
		/* FORMULARO NUEVA HISTORIA ***************************************************************************/
			// Creamos el Objeto MedicalHistory con la información
			$medicalHistory = new MedicalHistory();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'userLoggedId'=>$userLogged->getId());
			// Creamos el formulario, junto a sus atributos necesarios
			$form = $this->createForm(MedicalHistoryType::class,
				$medicalHistory,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			// Pasamos los datos de la petición del formulario y los pase a la entidad
			if ($request->request->all() != null){
				$requestOld = $request->request->all();
				/* Convertimos los datos de la ciudad a objeto*/
				$addressCityRequest = $requestOld['medical_history']['city'];
				$birthday = $requestOld['medical_history']['birthday'];
				$registrationDate = $requestOld['medical_history']['registrationDate'];
				$modificationDate = $requestOld['medical_history']['modificationDate'];
				if($addressCityRequest === "" ){
					$requestOld['medical_history']['city'] = NULL;
				}else{
					$addresCity_repo = $em->getRepository('BackendBundle:AddressCity');
					$addressCity = $addresCity_repo->findOneById( $addresCity_repo->idCityExtractAllInformation($addressCityRequest) );
					if($addressCity == NULL){
						$status = ['type'=>'danger','description'=>'No se ha encontrado la ciudad'];
						// generamos los mensajes FLASH (necesario activar las sesiones)
						$this->session->getFlashBag()->add("status", $status);
					}
					$requestOld = $request->request->all();
					$requestOld['medical_history']['city'] = $addressCity;
				}
				if(strpos($birthday, '-') == 4){
					$date = new \DateTime($birthday);
					$birthday = $date->format('d/m/Y');
					$requestOld['medical_history']['birthday'] = $birthday;
				}elseif($birthday==''){$requestOld['medical_history']['birthday'] = NULL;}
				if(strpos($registrationDate, '-') == 4){
					$date = new \DateTime($registrationDate);
					$registrationDate = $date->format('d/m/Y');
					$requestOld['medical_history']['registrationDate'] = $registrationDate;
				}elseif($registrationDate==''){$requestOld['medical_history']['registrationDate'] = NULL;}
				if(strpos($modificationDate, '-') == 4){
					$date = new \DateTime($modificationDate);
					$modificationDate = $date->format('d/m/Y');
					$requestOld['medical_history']['modificationDate'] = $modificationDate;
				}elseif($modificationDate==''){$requestOld['medical_history']['modificationDate'] = NULL;}
				$request->request->replace($requestOld);
			}
			$form->handleRequest($request);
			if($form->isSubmitted()){
				if($form->isValid()){			
					$em = $this->getDoctrine()->getManager();
					// Hacemos la consulta
					$medicalHistory->setMedicalHistoryNumber($medicalHistoryNumber);
					$medicalHistory->setName($form->get("name")->getData());
					$medicalHistory->setSurname($form->get("surname")->getData());
					$medicalHistory->setNickName($form->get("nickname")->getData());
					$medicalHistory->setDni($form->get("dni")->getData());
					$medicalHistory->setPhoneHome($form->get("phoneHome")->getData());
					$medicalHistory->setPhoneMobile($form->get("phoneMobile")->getData());
					$medicalHistory->setEmail($form->get("email")->getData());
					$medicalHistory->setAddress($form->get("address")->getData());
					$medicalHistory->setBirthday($form->get("birthday")->getData());
					$medicalHistory->setGender($form->get("gender")->getData());
					$medicalHistory->setNote($form->get("note")->getData());
					$medicalHistory->setReasonConsultation($form->get("reasonConsultation")->getData());
					$medicalHistory->setBackground($form->get("background")->getData());
					$medicalHistory->setAllergicDiseases($form->get("allergicDiseases")->getData());
					$medicalHistory->setTreatmentDiseases($form->get("treatmentDiseases")->getData());
					$medicalHistory->setPatologies($form->get("patologies")->getData());
					$medicalHistory->setSupplementaryTest($form->get("supplementaryTest")->getData());
					$medicalHistory->setDiagnostic($form->get("diagnostic")->getData());
					/* Introducimos el Objeto Clinic a partir de la Url */
					$medicalHistory->setClinic($clinicView);
					$medicalHistory->setCity($form->get("city")->getData());
					/* **********************************************************************************************/
					if( $form->has('registrationDate') && $form->get("registrationDate")->getData() != NULL ){
						$registrationDate = $form->get("registrationDate")->getData();
					}else{
						$medicalHistory->setRegistrationDate(new \DateTime("now"));
					}
					/**********************************************************************************************/
					if( $form->has('userRegisterer') && $form->get("userRegisterer")->getData() != NULL ){
						$medicalHistory->setUserRegisterer( $form->get("userRegisterer")->getData() );
					}else{
						$medicalHistory->setUserRegisterer( $userLogged );
					}
					/**********************************************************************************************/
					if( $form->has('modificationDate') && $form->get("modificationDate")->getData() != NULL ){
						$registrationDate = $form->get("modificationDate")->getData();
					}else{
						$medicalHistory->setModificationDate(new \DateTime("now"));
					}
					/**********************************************************************************************/
					if( $form->has('userModifier') && $form->get("userModifier")->getData() != NULL){
						$medicalHistory->setUserModifier( $form->get("userModifier")->getData() );
					}else{
						$medicalHistory->setUserModifier( $userLogged );
					}
					/**********************************************************************************************/
					// persistimos los datos dentro de Doctirne
					$em->persist($medicalHistory);
					// guardamos los datos persistidos dentro de la BD
					$flush = $em->flush();
					// Si se guardan correctamente los datos en la BD
					$status = ['type'=>'success','description'=>'Se ha creado una nueva Historia Clínica'];
					// generamos los mensajes FLASH (necesario activar las sesiones)
					$this->session->getFlashBag()->add("status", $status);
				}else{
					$status = ['type'=>'danger','description'=>'No se ha creado la nueva Historia Clínica correctamente'];
					// generamos los mensajes FLASH (necesario activar las sesiones)
					$this->session->getFlashBag()->add("status", $status);
				}
				
				return $this->redirectToRoute('medical_history_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber ));
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			return $this->render('AppBundle:MedicalHistory:medicalHistory_Create.html.twig', array(
				'permissionLoggedUser'=>$permissionLoggedUser,
				'clinicNameUrl'=>$clinicNameUrl,
				'form' => $form->createView() 	// Pasamos el formulario a la vista
			));
		/******************************************************************************************************/			
	}
/**************************************************************************************************************/
/* MÉTODO PARA EDITAR HISTORIA CLINICA ************************************************************************/
	public function medicalHistoryEditAction(Request $request, $clinicNameUrl = null, $medicalHistoryNumber = null){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userLogged));
			if( ( $clinicUserCorrect ==NULL && $permissionLoggedUser->getClinicViewOther() == false )
				or  $permissionLoggedUser->getMedicalHistoryEdit() == false){return $this->redirectToRoute('homepage');}
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$medicalHistory = $medicalHistory_repo->findOneBy(
				array(
					'clinic'=> $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl),
					'medicalHistoryNumber'=>$medicalHistoryNumber
				)
			);
			$medicalHistoryData = $medicalHistory_repo->getMedicalHistoryClinicalDataQuery( $clinicNameUrl );
		/******************************************************************************************************/
		/* FORMULARO EDITAR HISTORIA **************************************************************************/
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'userLoggedId'=>$userLogged->getId());
			// Creamos el formulario
			$form = $this->createForm(MedicalHistoryType::class,
				$medicalHistory,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			// Pasamos los datos de la petición del formulario y los pase a la entidad
			if ($request->request->all() != null){
				$requestOld = $request->request->all();
				/* Convertimos los datos de la ciudad a objeto*/
				$addressCityRequest = $requestOld['medical_history']['city'];
				$birthday = $requestOld['medical_history']['birthday'];
				$registrationDate = $requestOld['medical_history']['registrationDate'];
				$modificationDate = $requestOld['medical_history']['modificationDate'];
				if($addressCityRequest === "" ){
					$requestOld['medical_history']['city'] = NULL;
				}else{
					$addresCity_repo = $em->getRepository('BackendBundle:AddressCity');
					$addressCity = $addresCity_repo->findOneById( $addresCity_repo->idCityExtractAllInformation($addressCityRequest) );
					$requestOld = $request->request->all();
					$requestOld['medical_history']['city'] = $addressCity;
				}
				if(strpos($birthday, '-') == 4){
					$date = new \DateTime($birthday);
					$birthday = $date->format('d/m/Y');
					$requestOld['medical_history']['birthday'] = $birthday;
				}elseif($birthday==''){$requestOld['medical_history']['birthday'] = NULL;}
				if(strpos($registrationDate, '-') == 4){
					$date = new \DateTime($registrationDate);
					$registrationDate = $date->format('d/m/Y');
					$requestOld['medical_history']['registrationDate'] = $registrationDate;
				}elseif($registrationDate==''){$requestOld['medical_history']['registrationDate'] = NULL;}
				if(strpos($modificationDate, '-') == 4){
					$date = new \DateTime($modificationDate);
					$modificationDate = $date->format('d/m/Y');
					$requestOld['medical_history']['modificationDate'] = $modificationDate;
				}elseif($modificationDate==''){$requestOld['medical_history']['modificationDate'] = NULL;}
				$request->request->replace($requestOld);
			}		
			$form->handleRequest($request);
			if($form->isSubmitted()){
				if($form->isValid()){
					$em = $this->getDoctrine()->getManager();
					// Hacemos la consulta
					$medicalHistory->setName($form->get("name")->getData());
					$medicalHistory->setSurname($form->get("surname")->getData());
					$medicalHistory->setNickName($form->get("nickname")->getData());
					$medicalHistory->setDni($form->get("dni")->getData());
					$medicalHistory->setPhoneHome($form->get("phoneHome")->getData());
					$medicalHistory->setPhoneMobile($form->get("phoneMobile")->getData());
					$medicalHistory->setEmail($form->get("email")->getData());
					$medicalHistory->setAddress($form->get("address")->getData());
					$medicalHistory->setBirthday($form->get("birthday")->getData());
					$medicalHistory->setGender($form->get("gender")->getData());
					$medicalHistory->setNote($form->get("note")->getData());
					$medicalHistory->setReasonConsultation($form->get("reasonConsultation")->getData());
					$medicalHistory->setBackground($form->get("background")->getData());
					$medicalHistory->setAllergicDiseases($form->get("allergicDiseases")->getData());
					$medicalHistory->setTreatmentDiseases($form->get("treatmentDiseases")->getData());
					$medicalHistory->setPatologies($form->get("patologies")->getData());
					$medicalHistory->setSupplementaryTest($form->get("supplementaryTest")->getData());
					$medicalHistory->setDiagnostic($form->get("diagnostic")->getData());
					$medicalHistory->setCity($form->get("city")->getData());
					/* **********************************************************************************************/
					if( $form->has('registrationDate') && $form->get("registrationDate")->getData() != NULL ){
						$medicalHistory->setRegistrationDate( $form->get("registrationDate")->getData() );
					}else{
						$medicalHistory->setRegistrationDate(new \DateTime("now"));
					}
					/**********************************************************************************************/
					if( $form->has('userRegisterer') && $form->get("userRegisterer")->getData() != NULL ){
						$medicalHistory->setUserRegisterer( $form->get("userRegisterer")->getData() );
					}else{
						$medicalHistory->setUserRegisterer( $user );
					}
					/**********************************************************************************************/
					if( $form->has('modificationDate') && $form->get("modificationDate")->getData() != NULL ){
						$medicalHistory->setModificationDate( $form->get("modificationDate")->getData() );
					}elseif($form->has('modificationDate')){
						$medicalHistory->setModificationDate(new \DateTime("now"));
					}
					/**********************************************************************************************/
					if( $form->has('userModifier') && $form->get("userModifier")->getData() != NULL){
						$medicalHistory->setUserModifier( $form->get("userModifier")->getData() );
					}else{
						$medicalHistory->setUserModifier( $user );
					}
					/**********************************************************************************************/
					$em->persist($medicalHistory);	// persistimos los datos dentro de Doctirne
					$flush = $em->flush();	// guardamos los datos persistidos dentro de la BD
					// Si se guardan correctamente los datos en la BD
					$status = ['type'=>'success','description'=>'Se ha actualizado la Historia Clínica'];
				}else{
					$status = ['type'=>'danger','description'=>'No se han actualizado los datos correctamente'];
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('medical_history_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber ));
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			// Enviamos el formulario y su vista a la plantilla TWIG
			return $this->render('AppBundle:MedicalHistory:medicalHistory_Edit.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'form'=>$form->createView(),
					'medicalHistoryNumber'=>$medicalHistoryNumber,
					'clinicNameUrl'=>$clinicNameUrl,
					'medicalHistoryData' => $medicalHistoryData
				)
			);
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
/* MÉTODO PARA LANZAR PDF *************************************************************************************/
	public function medicalHistoryPdfAction(Request $request, $clinicNameUrl = null, $medicalHistoryNumber = null){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userLogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userLogged, $request);
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userLogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userLogged));
			if( ( $clinicUserCorrect ==NULL && $permissionLoggedUser->getClinicViewOther() == false )
				or  $permissionLoggedUser->getMedicalHistoryEdit() == false){return $this->redirectToRoute('homepage');}
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$medicalHistory = $medicalHistory_repo->findOneBy(
				array(
					'clinic'=> $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl),
					'medicalHistoryNumber'=>$medicalHistoryNumber
				)
			);
			$tracingMedicalHistoryList = $tracing_repo->findBy(['medicalHistory'=>$medicalHistory],['date'=>'DESC']);
		/* GENERAMOS PDF Y LO GUARDAMOS ***************************************************************/
			// capturamos el dominio para incluirlo en las imágenes de la plantilla 
	/*		$baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
			$baseurl = $request->getHttpHost() . $request->getBasePath();
			$snappy = $this->get('knp_snappy.pdf');
			$snappy->setOption('encoding','UTF-8');
			$html = $this->renderView(
				// src/AppBundle/Resources/views/Pruebas/pruebas_View_pdf.html.twig
				'AppBundle:MedicalHistory:medicalHistory_Pdf.html.twig',
				// indicamos las variables de entrada a la plantilla
				array(
					'baseurl'=>$baseurl,
					'medicalHistory'=>$medicalHistory,
					'tracingMedicalHistoryList'=>$tracingMedicalHistoryList
				)
			);
			// nombre del archivo pdf que se mostrará
			$filename = $medicalHistoryNumber.'-MedicalHistory.pdf';
			return new Response(
				$snappy->getOutPutFromHtml($html),
				// Stado code OK
				200,
				array(
					'Content-Type'=> 'application/pdf',
					'Content-Disposition'=>'inline; filename="'.$filename.'.pdf"'
				)
			);
			*/
		$img_clinic = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath().'/uploads/clinics/'.$medicalHistory->getClinic()->getNameUrl().'/'.$medicalHistory->getClinic()->getImage();
		$html = $this->renderView(
			// src/AppBundle/Resources/views/Pruebas/pruebas_View_pdf.html.twig			
			'AppBundle:MedicalHistory:medicalHistory_View_pdf.html.twig',
			// indicamos las variables de entrada a la plantilla
			array('medicalHistory'=>$medicalHistory,
				'img_clinic'=>$img_clinic)
		);
		$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
		$html2pdf->writeHTML($html);
	//	$pdf->writeHTML("<h1>HolaMundo</h1>");
		$html2pdf->Output('PdfGeneradoPHP.pdf');
		return new Response(
				$html2pdf->getOutPutFromHtml($html),
				// Stado code OK
				200,
				array(
					'Content-Type'=> 'application/pdf',
					'Content-Disposition'=>'inline; filename="'.$filename.'.pdf"'
				)
			);
		/**********************************************************************************************/				
 	}
/**************************************************************************************************************/ 	
/* MÉTODO PARA BUSCAR HISTORIAS MEDICAS ***********************************************************************/
  public function searchAction(Request $request){
    $em = $this->getDoctrine()->getManager();
    // usamos 'trim' para limpiar los espacios por delante ypor detrás
    $search = trim($request->query->get("search", null));
    if($search==null){
      return $this->redirect($this->generateURL('home_publications'));
    }
    $dql = "SELECT u FROM BackendBundle:MedicalHistory u
      WHERE u.name LIKE :search
      OR u.surname LIKE :search
      OR u.nick LIKE :search
      ORDER BY u.id ASC";
    // Buscamos una coincidencia dentro de la base de datos
    $query = $em->createQuery($dql)->setParameter('search', "%$search%");
    // Iniciamos el paginador
    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $query,
      $request->query->getInt('page',1),
      5 );
    // Devolvemos la vista con la información generado por el paginador
    return $this->render('AppBundle:User:users.html.twig', array('pagination'=>$pagination));
  }
/**************************************************************************************************************/
/* MÉTODO AJAX BUSCAR HISTORIA MÉDICA *************************************************************************/
	public function searchMedicalHistoryAction(Request $request) {
		$session = $request->getSession();
		$clinicNameUrl = "podologia_priego";
		//$clinicNameUrl = $session->get('clinicUserLogged')['nameUrl'];
		$em = $this->getDoctrine()->getManager();
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");		
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			// Realizamos las consultas // funciones Repositorio usadas, ver 'src\BackendBundle\Repository'
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistoryList = $medicalHistory_repo->findBy(['clinic'=>$clinic]);
		/******************************************************************************************************/
		$result = array();
		foreach ($medicalHistoryList as $key => $value) {
				$medicalHistory = $medicalHistoryList[$key];
				$result[$key] = $medicalHistory->getMedicalHistoryDataComplete().' - '.$medicalHistory->getPhoneMobile().' - '.$medicalHistory->getPhoneHome();
		}	
		return new Response(json_encode($result)); // codificamos la respuesta en JSON
	}
/**************************************************************************************************************/
}