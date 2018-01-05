<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* Componentes Básicos del Controlador ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Response;  		// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session; 	// Permite usar sesiones, usado en FLASHBAG
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\OrthopodologyHistory;			// Da acceso a la Entidad Usuario
	use BackendBundle\Entity\OrthopodologyHistoryDoc;		// Da acceso a la Entidad Usuario
	use BackendBundle\Entity\Tracing;										// Da acceso a la Entidad Usuario	
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\OrthopodologyHistoryType;			// Da acceso al Formulario OrthopodologyHistoryType
	use AppBundle\Form\OrthopodologyHistoryDocType;		// Da acceso al Formulario OrthopodologyHistoryDocType
	use AppBundle\Form\TracingType;										// Da acceso al Formulario TracingType	
/**************************************************************************************************************/
class OrthopodologyHistoryController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR ESTUDIOS ********************************************************************************/
	public function orthopodologyHistoriesListAction(Request $request, $clinicNameUrl = null){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);		
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			if( $clinicUserCorrect ==NULL && $permissionLoggedUser->getClinicViewOther() == false ){return $this->redirectToRoute('homepage');}
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$orthopodologyHistory_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LAS ENTIDADES Y LOS REPOSITORIOS *****************/
			/* REPOSITORY
			 * La función getListOrthopodologyHistory($idClinic) se encuentra dentro de
			 * src\AppBundle\Repository\OrthopodologyHistoryRepository.php definido dentro del ORM
			 * src\BackendBundle\Resources\config\OrthopodologyHistory.orm.yml
			 */
			$orthopodologyHistories = $orthopodologyHistory_repo->getListOrthopodologyHistory($clinicNameUrl);
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			// Enviamos el formulario y su vista a la plantilla TWIG
			return $this->render('AppBundle:OrthopodologyHistory:orthopodologyHistory_List.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'orthopodologyHistories'=>$orthopodologyHistories,
					'clinicNameUrl'=>$clinicNameUrl
				)
			);
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
/* MÉTODO PARA VER UN ESTUDIO ORTOPODOLÓGICO ******************************************************************/
	public function orthopodologyHistoryViewAction(Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);		
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			if( $clinicUserCorrect == NULL || $permissionLoggedUser->getOrthopodologyHistoryCreate() == false ){
				$status = [	'type'=>'danger', 'description'=>'No tienes permiso para eliminar el Estudio Ortopodológico'];
				$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
				return $this->redirectToRoute(
					'medical_history_view',
					array(
						'clinicNameUrl'=>$clinicNameUrl, 
						'medicalHistoryNumber'=>$medicalHistoryNumber));
			}
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			// Cargamos los repositorios
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$addressCity_repo = $em->getRepository("BackendBundle:AddressCity");
			$orthopodologyHistories_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");
			$tracing_repo = $em->getRepository("BackendBundle:Tracing");
			$typeTracing_repo = $em->getRepository("BackendBundle:TypeTracing");
			$typeDoc_repo = $em->getRepository("BackendBundle:TypeDoc");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			// Realizamos las consultas
			/* REPOSITORY - La función getMedicalHistory($clinicNameUrl, $medicalHistoryNumber) y getOrthopodologyHistory($clinicNameUrl, $medicalHistoryNumber, $registrationDate) se encuentran dentro de src\AppBundle\Repository\MedicalHistoryRepository.php y src\AppBundle\Repository\OrthopodologyHistoryRepository.php definido dentro del ORM src\BackendBundle\Resources\config\MedicalHistory.orm.yml y src\BackendBundle\Resources\config\OrthopodologyHistory.orm.yml */
			$typeTracing = $typeTracing_repo->findOneByType('orthopodology_history');
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('numberMedicalHistory'=>$medicalHistoryNumber, 'clinic'=>$clinic));
			$orthopodologyHistories = $orthopodologyHistories_repo->findBy(array('medicalHistory'=>$medicalHistory));
			foreach ($orthopodologyHistories as $key=>$clave){
				if ($clave->getRegistrationDate()->format('Y_m_d') == $registrationDate ){
					$orthopodologyHistory = $clave;
				}
			}
			// Extraemos $tracingOrthopodologyHistoryList para ordenarlos por Fecha
			$tracingOrthopodologyHistoryList = $tracing_repo->findBy(['orthopodologyHistory'=>$orthopodologyHistory],['date'=>'DESC']);
		/* FORMULARO NUEVO SEGUIMIENTO ************************************************************************/
			$tracingNew = new Tracing();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'idTracing'=>NULL);
			$form_orthopodologyHistoryTracing = $this->createForm(TracingType::class, $tracingNew,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form_orthopodologyHistoryTracing->handleRequest($request);
			if($form_orthopodologyHistoryTracing->isSubmitted()){
				if(!array_key_exists('id', $request->request->get('tracing'))) {
					/* Nuevo  seguimiento **********************************************************************/
						if($form_orthopodologyHistoryTracing->isValid()){
							$em = $this->getDoctrine()->getManager();
							if($form_orthopodologyHistoryTracing->get("date")->getData() == null){
								$tracingNew->setDate(new \DateTime("now"));
							}else{
								$tracingNew->setDate($form_orthopodologyHistoryTracing->get("date")->getData());
							}
							$tracingNew->setTracing($form_orthopodologyHistoryTracing->get("tracing")->getData());
							$tracingNew->setUser($userlogged);
							if(!isset($registrationDate) or $registrationDate==null){
								$TypeTracing = $typeTracing_repo->findOneByType('medical_history');
							}else{
								$TypeTracing = $typeTracing_repo->findOneByType('orthopodology_history');
							}
							$tracingNew->setTypeTracing($TypeTracing);
							$tracingNew->setOrthopodologyHistory( $orthopodologyHistory );
							$medicalHistory = $medicalHistory_repo->getMedicalHistoryObject( $clinicNameUrl, $medicalHistoryNumber );
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
						if($form_orthopodologyHistoryTracing->isValid()){
							$em = $this->getDoctrine()->getManager();
							$idTracing = $request->request->get('tracing')['id'];
							$tracingEdit = $tracing_repo->findOneById($idTracing);
							$tracingEdit->setDate($form_orthopodologyHistoryTracing->get("date")->getData());
							$tracingEdit->setTracing($form_orthopodologyHistoryTracing->get("tracing")->getData());
							$tracingEdit->setUser($userlogged);
							$tracingEdit->setTypeTracing( $tracingEdit->getTypeTracing() );
							$tracingEdit->setOrthopodologyHistory( $tracingEdit->getOrthopodologyHistory() );
							$medicalHistory = $medicalHistory_repo->getMedicalHistoryObject( $clinicNameUrl, $medicalHistoryNumber );
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
				return $this->redirectToRoute('orthopodology_history_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'registrationDate'=> $registrationDate ));
			}
		/******************************************************************************************************/
		/* FORMULARO EDITAR SEGUIMIENTOS **********************************************************************/
			/* Generamos la Vista, el formulario se gestiona en Nuevo con el condicional de si lleva id o no el formulario */
			$tracingOrthopodologyHistoryListForm = array();
			if( !empty($tracingOrthopodologyHistoryList) ){
				foreach($tracingOrthopodologyHistoryList as $tracingMedicalHistoryDate => $tracingEdit){
					$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'idTracing'=>"NO NULL");
					$form_orthopodologyHistoryTracingEdit = $this->createForm(TracingType::class,
						$tracingEdit,
						array(
							'allow_extra_fields'=> $permissionLoggedUser,
							'attr'=> $attr
						)
					);
					$tracingOrthopodologyHistoryListForm[$tracingEdit->getId()] = $form_orthopodologyHistoryTracingEdit->createView();
				}
			}
		/******************************************************************************************************/
		/* FORMULARO SUBIR NUEVO DOCUMENTO ********************************************************************/
			$orthopodologyHistoryDoc = new OrthopodologyHistoryDoc();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber);
			$form_orthopodologyHistoryDoc = $this->createForm(OrthopodologyHistoryDocType::class, $orthopodologyHistoryDoc,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form_orthopodologyHistoryDoc->handleRequest($request);
			if($form_orthopodologyHistoryDoc->isSubmitted()){
				if($form_orthopodologyHistoryDoc->isValid()){
					$em = $this->getDoctrine()->getManager();
					// Upload file
					$file = $form_orthopodologyHistoryDoc["doc"]->getData();
					$title = str_replace( " ", "_", strtolower( $form_orthopodologyHistoryDoc["title"]->getData() ) );
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
						$file->move('uploads/clinics/'.$clinicNameUrl.'/medicalHistory/'.$medicalHistoryNumber.'/orthopodologyhistory/'.$registrationDate, $file_name);
						$orthopodologyHistoryDoc->setDoc($file_name);
						$orthopodologyHistoryDoc->setTitle($form_orthopodologyHistoryDoc["title"]->getData());
						$orthopodologyHistoryDoc->setDescription($form_orthopodologyHistoryDoc["description"]->getData());
						$orthopodologyHistoryDoc->setTypeDoc($typeDoc);
						$orthopodologyHistoryDoc->setModificationDate(new \DateTime("now"));
						$orthopodologyHistoryDoc->setRegistrationDate(new \DateTime("now"));
						$orthopodologyHistoryDoc->setUserModifier($this->getUser());
						$orthopodologyHistoryDoc->setUserRegisterer($this->getUser());
						$orthopodologyHistoryDoc->setOrthopodologyHistory($orthopodologyHistory);
						// persistimos los datos dentro de Doctirne
						$em->persist($orthopodologyHistoryDoc);
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
				return $this->redirectToRoute('orthopodology_history_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'registrationDate'=>$registrationDate ));
			}
		/******************************************************************************************************/		
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			// Enviamos el formulario y su vista a la plantilla TWIG		
			return $this->render('AppBundle:OrthopodologyHistory:orthopodologyHistory_View.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'registrationDate' => str_replace("_", "-", $registrationDate),
					'orthopodologyHistory'=>$orthopodologyHistory,
					'tracingOrthopodologyHistoryList'=>$tracingOrthopodologyHistoryList,
					'form_orthopodologyHistoryTracing'=>$form_orthopodologyHistoryTracing->createView(),
					'form_orthopodologyHistoryDoc'=>$form_orthopodologyHistoryDoc->createView(),
					'form_tracingOrthopodologyHistoryList'=>$tracingOrthopodologyHistoryListForm
			));
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
/* MÉTODO PARA CREAR UN NUEVO ESTUDIO ORTOPODOLÓGICO **********************************************************/
	public function orthopodologyHistoryCreateAction(Request $request, $clinicNameUrl = NULL, $medicalHistoryNumber = NULL){
		/* si existe el objeto User nos rediriges a home            */
		if( !is_object($this->getUser()) ){ return $this->redirect('home'); }
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);		
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			if( $clinicUserCorrect == NULL || $permissionLoggedUser->getOrthopodologyHistoryCreate() == false ){
				$status = [	'type'=>'danger', 'description'=>'No tienes permiso para eliminar el Estudio Ortopodológico'];
				$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
				return $this->redirectToRoute(
					'medical_history_view',
					array(
						'clinicNameUrl'=>$clinicNameUrl, 
						'medicalHistoryNumber'=>$medicalHistoryNumber));
			}			
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
		$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl)->getId();
		$medicalHistory =  $medicalHistory_repo->findOneBy(
			array(
				'clinic'=>$clinic,
				'numberMedicalHistory'=>$medicalHistoryNumber
			)
		);
		/******************************************************************************************************/
		/* FORMULARO NUEVA HISTORIA ***************************************************************************/
			// Creamos el Objeto orthopodologyHistory con la información
			$orthopodologyHistory = new orthopodologyHistory();
			$attr = ['medicalHistoryNumber'=>$medicalHistoryNumber, 'clinicNameUrl'=>$clinicNameUrl];
			// Creamos el formulario
			$form = $this->createForm(OrthopodologyHistoryType::class, $orthopodologyHistory,
				array( 'allow_extra_fields'=> $permissionLoggedUser, 'attr'=>$attr
			));
			/* Enlazamos la información de la request cuando nosotros enviamos el formulario sobreescribiendo el objeto $user */
			if ($request->request->all() != null){
				$requestOld = $request->request->all();
				/* Convertimos los datos de la ciudad a objeto*/
				$registrationDate = $requestOld['backendbundle_orthopodologyhistory']['registrationDate'];
				$modificationDate = $requestOld['backendbundle_orthopodologyhistory']['modificationDate'];
				if(strpos($registrationDate, '-') == 4){
					$date = new \DateTime($registrationDate);
					$registrationDate = $date->format('d/m/Y');
					$requestOld['backendbundle_orthopodologyhistory']['registrationDate'] = $registrationDate;
				}elseif($registrationDate==''){$requestOld['medical_history']['registrationDate'] = NULL;}
				if(strpos($modificationDate, '-') == 4){
					$date = new \DateTime($modificationDate);
					$modificationDate = $date->format('d/m/Y');
					$requestOld['backendbundle_orthopodologyhistory']['modificationDate'] = $modificationDate;
				}elseif($modificationDate==''){$requestOld['medical_history']['modificationDate'] = NULL;}
				$request->request->replace($requestOld);
			}
			$form->handleRequest($request);
			if($form->isSubmitted()){
				if($form->isValid()){
					$em = $this->getDoctrine()->getManager();
					$orthopodologyHistory->setReasonConsultation($form->get("reasonConsultation")->getData());
					$orthopodologyHistory->setBackground($form->get("background")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationRotaryPatternExternalLeft(
							$form->get("articularExplorationRotaryPatternExternalLeft")->getData());
					$orthopodologyHistory->setArticularExplorationRotaryPatternInternalLeft(
							$form->get("articularExplorationRotaryPatternInternalLeft")->getData());
					$orthopodologyHistory->setArticularExplorationRotaryPatternExternalRight(
							$form->get("articularExplorationRotaryPatternExternalRight")->getData());
					$orthopodologyHistory->setArticularExplorationRotaryPatternInternalRight(
							$form->get("articularExplorationRotaryPatternInternalRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationHipLeft(
							$form->get("articularExplorationHipLeft")->getData());
					$orthopodologyHistory->setArticularExplorationHipRight(
							$form->get("articularExplorationHipRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationKneeLeft(
							$form->get("articularExplorationKneeLeft")->getData());
					$orthopodologyHistory->setArticularExplorationKneeRight(
							$form->get("articularExplorationKneeRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationAnkleLeft(
							$form->get("articularExplorationAnkleLeft")->getData());
					$orthopodologyHistory->setArticularExplorationAnkleRight(
							$form->get("articularExplorationAnkleRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationRetroPieLeft(
							$form->get("articularExplorationRetroPieLeft")->getData());
					$orthopodologyHistory->setArticularExplorationRetroPieRight(
							$form->get("articularExplorationRetroPieRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationBeforeFootLeft(
							$form->get("articularExplorationBeforeFootLeft")->getData());
					$orthopodologyHistory->setArticularExplorationBeforeFootRight(
							$form->get("articularExplorationBeforeFootRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationFirstRadioLeft(
							$form->get("articularExplorationFirstRadioLeft")->getData());
					$orthopodologyHistory->setArticularExplorationFirstRadioRight(
							$form->get("articularExplorationFirstRadioRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationFifthRadioLeft(
							$form->get("articularExplorationFifthRadioLeft")->getData());
					$orthopodologyHistory->setArticularExplorationFifthRadioRight(
							$form->get("articularExplorationFifthRadioRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationCentralRadiosLeft(
							$form->get("articularExplorationCentralRadiosLeft")->getData());
					$orthopodologyHistory->setArticularExplorationCentralRadiosRight(
							$form->get("articularExplorationCentralRadiosRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationFirstFingerLeft(
							$form->get("articularExplorationFirstFingerLeft")->getData());
					$orthopodologyHistory->setArticularExplorationFirstFingerRight(
							$form->get("articularExplorationFirstFingerRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationSmallerFingersLeft(
							$form->get("articularExplorationSmallerFingersLeft")->getData());
					$orthopodologyHistory->setArticularExplorationSmallerFingersRight(
							$form->get("articularExplorationSmallerFingersRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsFemoralLeft(
							$form->get("torsionsFemoralLeft")->getData());
					$orthopodologyHistory->setTorsionsFemoralRight(
							$form->get("torsionsFemoralRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsGenusLeft(
							$form->get("torsionsGenusLeft")->getData());
					$orthopodologyHistory->setTorsionsGenusRight(
							$form->get("torsionsGenusRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsAngleQLeft(
							$form->get("torsionsAngleQLeft")->getData());
					$orthopodologyHistory->setTorsionsAngleQRight(
							$form->get("torsionsAngleQRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsTibialLeft(
							$form->get("torsionsTibialLeft")->getData());
					$orthopodologyHistory->setTorsionsTibialRight(
							$form->get("torsionsTibialRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsHelbingLeft(
							$form->get("torsionsHelbingLeft")->getData());
					$orthopodologyHistory->setTorsionsHelbingRight(
							$form->get("torsionsHelbingRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setDissimmetry(
							$form->get("dissimmetry")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setBackground(
							$form->get("background")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationDorsalFlexionLeft(
							$form->get("muscularExplorationDorsalFlexionLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationDorsalFlexionRight(
							$form->get("muscularExplorationDorsalFlexionRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationPlantarFlexionLeft(
							$form->get("muscularExplorationPlantarFlexionLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationPlantarFlexionRight(
							$form->get("muscularExplorationPlantarFlexionRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationEversionLeft(
							$form->get("muscularExplorationEversionLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationEversionRight(
							$form->get("muscularExplorationEversionRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationReversalLeft(
							$form->get("muscularExplorationReversalLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationReversalRight(
							$form->get("muscularExplorationReversalRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setDinamicExploration(
							$form->get("dinamicExploration")->getData());
					$orthopodologyHistory->setSignsFootprint(
							$form->get("signsFootprint")->getData());
					$orthopodologyHistory->setSuplementaryTest(
							$form->get("suplementaryTest")->getData());
					$orthopodologyHistory->setDiagnostic(
							$form->get("diagnostic")->getData());
					$orthopodologyHistory->setTreatment(
							$form->get("treatment")->getData());
					/* **********************************************************************************************/
					if( $form->has('registrationDate' && $form->get("registrationDate")->getData() != null) ){
						$formData_registrationDate = $form->get("registrationDate")->getData();
						$orthopodologyHistory->setRegistrationDate( $formData_registrationDate );
						$registrationDate = date_format($formData_registrationDate,'Y_m_d');
					}else{
						$orthopodologyHistory->setRegistrationDate(new \DateTime("now"));
						$registrationDate=date_format(new \DateTime("now"),'Y_m_d');
					}
					/**********************************************************************************************/
					if( $form->has('userRegisterer') ){
						$formData_userRegisterer = $form->get("userRegisterer")->getData();
						$orthopodologyHistory->setUserRegisterer( $formData_userRegisterer );
					}else{
						$orthopodologyHistory->setUserRegisterer( $user );
					}
					/**********************************************************************************************/
					if( $form->has('modificationDate') && $form->get("modificationDate")->getData() != null){
						$formData_modificationDate = $form->get("modificationDate")->getData();
						$orthopodologyHistory->setModificationDate( $formData_modificationDate );
					}else{
						$orthopodologyHistory->setModificationDate(new \DateTime("now"));
					}
					/**********************************************************************************************/
					if( $form->has('userModifier') ){
						$formData_userModifier = $form->get("userModifier")->getData();
						$orthopodologyHistory->setUserModifier( $formData_userModifier );
					}else{
						$orthopodologyHistory->setUserModifier( $user );
					}
					/**********************************************************************************************/
					if( $medicalHistoryNumber == 'without_MedicalHistoryNumber' ){
						$orthopodologyHistory->setMedicalHistory( $form->get("medicalHistory")->getData() );
						// Como no tenemos $medicalHistoryNumber definido seleccionamos el del formulario
						$medicalHistoryNumber = $form->get("medicalHistory")->getData()->getNumberMedicalHistory();
					}else{
						$orthopodologyHistory->setMedicalHistory($medicalHistory);
					}
					$em->persist($orthopodologyHistory);	// persistimos los datos dentro de Doctirne
					$flush = $em->flush();	// guardamos los datos persistidos dentro de la BD
					// Si se guardan correctamente los datos en la BD
					$status = [ 'type'=>'success', 'description'=>'Se ha creado un nuevo Estudio Ortopodológico'];
				}else{
					$status = [	'type'=>'danger', 'description'=>'No se ha creado correctamente el nuevo "Estudio Ortopodológico"'];
				}

				$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
				// Si se guardan correctamente los datos en la BD
				return $this->redirectToRoute('orthopodology_history_view',
				array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'registrationDate'=> $registrationDate ));
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			return $this->render('AppBundle:OrthopodologyHistory:orthopodologyHistory_Create.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'clinicNameUrl'=>$clinicNameUrl,
					'medicalHistoryNumber'=>$medicalHistoryNumber,
					'form'=>$form->createView()
				)
			);
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
/* MÉTODO PARA EDITAR UN ESTUDIO ORTOPODOLOGICO ***************************************************************/
	public function orthopodologyHistoryEditAction(Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);		
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			if( $clinicUserCorrect == NULL || $permissionLoggedUser->getOrthopodologyHistoryEdit() == false ){
				$status = [	'type'=>'danger', 'description'=>'No tienes permiso para eliminar el Estudio Ortopodológico'];
				$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
				return $this->redirectToRoute(
					'orthopodology_history_view',
					array(
						'clinicNameUrl'=>$clinicNameUrl, 
						'medicalHistoryNumber'=>$medicalHistoryNumber, 
						'registrationDate'=> $registrationDate ));
			}
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			// Cargamos los repositorios
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$orthopodologyHistory_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			// Realizamos las consultas
			$idClinic = $clinic_repo->findOneByNameUrl($clinicNameUrl)->getId();
			/* REPOSITORY - La función getMedicalHistoryPatientId($medicalHistoryNumber, $idClinic) y getOrthopodologyHistory($medicalHistoryId, $registrationDate) se encuentran dentro de src\AppBundle\Repository\MedicalHistoryRepository.php y src\AppBundle\Repository\OrthopodologyHistoryRepository.php definido dentro del ORM src\BackendBundle\Resources\config\MedicalHistory.orm.yml y src\BackendBundle\Resources\config\OrthopodologyHistory.orm.yml */
			$medicalHistory = $medicalHistory_repo->findOneBy(
				array(
					'clinic'=>$clinic_repo->findOneByNameUrl($clinicNameUrl),
					'numberMedicalHistory'=>$medicalHistoryNumber
				)
			);
			$orthopodologyHistories = $orthopodologyHistory_repo->findBy(array('medicalHistory'=>$medicalHistory));
			foreach ($orthopodologyHistories as $key=>$clave){
				if ($clave->getRegistrationDate()->format('Y_m_d') == $registrationDate ){
					$orthopodologyHistory = $clave;
				}
			}
		/******************************************************************************************************/
		/* FORMULARO EDITAR HISTORIA **************************************************************************/
			$attr = ['medicalHistoryNumber'=>$medicalHistoryNumber, 'clinicNameUrl'=>$clinicNameUrl];
			// Creamos el formulario
			$form = $this->createForm(OrthopodologyHistoryType::class, $orthopodologyHistory,
				array( 'allow_extra_fields'=> $permissionLoggedUser, 'attr'=>$attr
			));
			/* Enlazamos la información de la request cuando nosotros enviamos el formulario sobreescribiendo el objeto $user*/
			$form->handleRequest($request);
			if($form->isSubmitted()){
				if($form->isValid()){
					$em = $this->getDoctrine()->getManager();
					$orthopodologyHistory->setReasonConsultation($form->get("reasonConsultation")->getData());
					$orthopodologyHistory->setBackground($form->get("background")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationRotaryPatternExternalLeft(
							$form->get("articularExplorationRotaryPatternExternalLeft")->getData());
					$orthopodologyHistory->setArticularExplorationRotaryPatternInternalLeft(
							$form->get("articularExplorationRotaryPatternInternalLeft")->getData());
					$orthopodologyHistory->setArticularExplorationRotaryPatternExternalRight(
							$form->get("articularExplorationRotaryPatternExternalRight")->getData());
					$orthopodologyHistory->setArticularExplorationRotaryPatternInternalRight(
							$form->get("articularExplorationRotaryPatternInternalRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationHipLeft(
							$form->get("articularExplorationHipLeft")->getData());
					$orthopodologyHistory->setArticularExplorationHipRight(
							$form->get("articularExplorationHipRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationKneeLeft(
							$form->get("articularExplorationKneeLeft")->getData());
					$orthopodologyHistory->setArticularExplorationKneeRight(
							$form->get("articularExplorationKneeRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationAnkleLeft(
							$form->get("articularExplorationAnkleLeft")->getData());
					$orthopodologyHistory->setArticularExplorationAnkleRight(
							$form->get("articularExplorationAnkleRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationRetroPieLeft(
							$form->get("articularExplorationRetroPieLeft")->getData());
					$orthopodologyHistory->setArticularExplorationRetroPieRight(
							$form->get("articularExplorationRetroPieRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationBeforeFootLeft(
							$form->get("articularExplorationBeforeFootLeft")->getData());
					$orthopodologyHistory->setArticularExplorationBeforeFootRight(
							$form->get("articularExplorationBeforeFootRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationFirstRadioLeft(
							$form->get("articularExplorationFirstRadioLeft")->getData());
					$orthopodologyHistory->setArticularExplorationFirstRadioRight(
							$form->get("articularExplorationFirstRadioRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationFifthRadioLeft(
							$form->get("articularExplorationFifthRadioLeft")->getData());
					$orthopodologyHistory->setArticularExplorationFifthRadioRight(
							$form->get("articularExplorationFifthRadioRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationCentralRadiosLeft(
							$form->get("articularExplorationCentralRadiosLeft")->getData());
					$orthopodologyHistory->setArticularExplorationCentralRadiosRight(
							$form->get("articularExplorationCentralRadiosRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationFirstFingerLeft(
							$form->get("articularExplorationFirstFingerLeft")->getData());
					$orthopodologyHistory->setArticularExplorationFirstFingerRight(
							$form->get("articularExplorationFirstFingerRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setArticularExplorationSmallerFingersLeft(
							$form->get("articularExplorationSmallerFingersLeft")->getData());
					$orthopodologyHistory->setArticularExplorationSmallerFingersRight(
							$form->get("articularExplorationSmallerFingersRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsFemoralLeft(
							$form->get("torsionsFemoralLeft")->getData());
					$orthopodologyHistory->setTorsionsFemoralRight(
							$form->get("torsionsFemoralRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsGenusLeft(
							$form->get("torsionsGenusLeft")->getData());
					$orthopodologyHistory->setTorsionsGenusRight(
							$form->get("torsionsGenusRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsAngleQLeft(
							$form->get("torsionsAngleQLeft")->getData());
					$orthopodologyHistory->setTorsionsAngleQRight(
							$form->get("torsionsAngleQRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsTibialLeft(
							$form->get("torsionsTibialLeft")->getData());
					$orthopodologyHistory->setTorsionsTibialRight(
							$form->get("torsionsTibialRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setTorsionsHelbingLeft(
							$form->get("torsionsHelbingLeft")->getData());
					$orthopodologyHistory->setTorsionsHelbingRight(
							$form->get("torsionsHelbingRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setDissimmetry(
							$form->get("dissimmetry")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setBackground(
							$form->get("background")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationDorsalFlexionLeft(
							$form->get("muscularExplorationDorsalFlexionLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationDorsalFlexionRight(
							$form->get("muscularExplorationDorsalFlexionRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationPlantarFlexionLeft(
							$form->get("muscularExplorationPlantarFlexionLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationPlantarFlexionRight(
							$form->get("muscularExplorationPlantarFlexionRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationEversionLeft(
							$form->get("muscularExplorationEversionLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationEversionRight(
							$form->get("muscularExplorationEversionRight")->getData());
					/***********************************************************************************************/
					$orthopodologyHistory->setMuscularExplorationReversalLeft(
							$form->get("muscularExplorationReversalLeft")->getData());
					$orthopodologyHistory->setMuscularExplorationReversalRight(
							$form->get("muscularExplorationReversalRight")->getData());
					/* **********************************************************************************************/
					if( $form->has('registrationDate') && $form->get("registrationDate")->getData() != NULL){
						$orthopodologyHistory->setRegistrationDate( $form->get("registrationDate")->getData() );
						$registrationDate=date_format( $form->get("registrationDate")->getData() ,'Y_m_d');
					}else{
						$orthopodologyHistory->setRegistrationDate(new \DateTime("now"));
						$registrationDate=date_format(new \DateTime("now"),'Y_m_d');
					}
					/**********************************************************************************************/
					if( $form->has('userRegisterer') && $form->get("userRegisterer")->getData() != NULL ){
						$orthopodologyHistory->setUserRegisterer( $form->get("userRegisterer")->getData() );
					}else{
						$orthopodologyHistory->setUserRegisterer( $user );
					}
					/**********************************************************************************************/
					if( $form->has('modificationDate') && $form->get("modificationDate")->getData() != NULL ){
						$orthopodologyHistory->setModificationDate( $form->get("modificationDate")->getData() );
					}else{
						$orthopodologyHistory->setModificationDate(new \DateTime("now"));
					}
					/**********************************************************************************************/
					if( $form->has('userModifier') && $form->get("userModifier")->getData() != NULL){
						$orthopodologyHistory->setUserModifier( $form->get("userModifier")->getData() );
					}else{
						$orthopodologyHistory->setUserModifier( $user );
					}
					/**********************************************************************************************/
					if( $medicalHistoryNumber == 'without_MedicalHistoryNumber' ){
						$orthopodologyHistory->setMedicalHistory( $form->get("medicalHistory")->getData() );
						// Como no tenemos $medicalHistoryNumber definido seleccionamos el del formulario
						$medicalHistoryNumber = $form->get("medicalHistory")->getData()->getNumberMedicalHistory();
					}else{
						$orthopodologyHistory->setMedicalHistory($medicalHistory);
					}
					$em->persist($orthopodologyHistory);	// persistimos los datos dentro de Doctirne
					$flush = $em->flush();	// guardamos los datos persistidos dentro de la BD
					// Si se guardan correctamente los datos en la BD
					$status = [ 'type'=>'success', 'description'=>'Se ha actualizado el Estudio Ortopodológico'];
				}else{
					$status = [	'type'=>'danger', 'description'=>'No se ha actualizado el Estudio Ortopodológico'];
				}

				$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
				// Si se guardan correctamente los datos en la BD
				return $this->redirectToRoute('orthopodology_history_view',
				array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'registrationDate'=> $registrationDate ));
			}
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			// Enviamos el formulario y su vista a la plantilla TWIG
			return $this->render('AppBundle:OrthopodologyHistory:orthopodologyHistory_Edit.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'form'=>$form->createView(),
					'medicalHistoryNumber'=>$medicalHistoryNumber,
					'clinicNameUrl'=>$clinicNameUrl,
					'orthopodologyHistories'=>$orthopodologyHistories,
					'registrationDate'=>$registrationDate
				)
			);
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
/* MÉTODO PARA ELIMINAR UN ESTUDIO QUIROPODOLÓGICO ************************************************************/
	public function orthopodologyHistoryRemoveAction(Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate){
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
		/******************************************************************************************************/
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* PERMISO ACCESO *************************************************************************************/
			$clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);		
			$clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));
			if( $clinicUserCorrect == NULL || $permissionLoggedUser->getOrthopodologyHistoryRemove() == false ){
				$status = [	'type'=>'danger', 'description'=>'No tienes permiso para eliminar el Estudio Ortopodológico'];
				$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
				return $this->redirectToRoute(
					'orthopodology_history_view',
					array(
						'clinicNameUrl'=>$clinicNameUrl, 
						'medicalHistoryNumber'=>$medicalHistoryNumber, 
						'registrationDate'=> $registrationDate ));
			}
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
		$clinic_repo = $em->getRepository("BackendBundle:Clinic");
		$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		$orthopodologyHistory_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$idClinic = $clinic_repo->findOneByNameUrl($clinicNameUrl)->getId();
			/* REPOSITORY - La función getMedicalHistoryPatientId($medicalHistoryNumber, $idClinic) y getOrthopodologyHistory($medicalHistoryId, $registrationDate) se encuentran dentro de src\AppBundle\Repository\MedicalHistoryRepository.php y src\AppBundle\Repository\OrthopodologyHistoryRepository.php definido dentro del ORM src\BackendBundle\Resources\config\MedicalHistory.orm.yml y src\BackendBundle\Resources\config\OrthopodologyHistory.orm.yml */
			$medicalHistory = $medicalHistory_repo->findOneBy(
				array(
					'clinic'=>$clinic_repo->findOneByNameUrl($clinicNameUrl),
					'numberMedicalHistory'=>$medicalHistoryNumber
				)
			);
			$orthopodologyHistories = $orthopodologyHistory_repo->findBy(array('medicalHistory'=>$medicalHistory));
			foreach ($orthopodologyHistories as $key=>$clave){
				if ($clave->getRegistrationDate()->format('Y_m_d') == $registrationDate ){
					$orthopodologyHistory = $clave;
				}
			}
		/******************************************************************************************************/
		/* ELIMINO EL ESTUDIO *********************************************************************************/
			$em->remove($orthopodologyHistory);	// persistimos los datos dentro de Doctirne
			$flush = $em->flush();	// guardamos los datos persistidos dentro de la BD
			// Si se guardan correctamente los datos en la BD
			$status = [ 'type'=>'success', 'description'=>'Se ha eliminado el Estudio Ortopodológico'];
			$this->session->getFlashBag()->add("status", $status);	// generamos los mensajes FLASH (necesario activar las sesiones)
		/******************************************************************************************************/
		/* REDIRECCIONO ***************************************************************************************/			
			// Si se eliminaron correctamente los datos en la BD
			return $this->redirectToRoute('medical_history_view',
			array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber));
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
}