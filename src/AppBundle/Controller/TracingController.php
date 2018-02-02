<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\HttpFoundation\Response;  		// Permite usar el método Response, usado en AJAX
	use Symfony\Component\HttpFoundation\Session\Session; 	// Permite usar sesiones, usado en FLASHBAG
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\Tracing;        // Da acceso a la Entidad Historia Médica
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\TracingType;          // Da acceso al Formulario MedicalHistoryPatientType
/**************************************************************************************************************/
class TracingController extends Controller{
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
/**************************************************************************************************************/
/* MÉTODO PARA CREAR NUEVO SEGUIMIENTO ************************************************************************/
	public function tracingCreateAction(Request $request, $clinicNameUrl = null, $medicalHistoryNumber = null, $registrationDate = null){
		// Cargo Entity Manager de Doctrine dentro de lavariable $em
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
		/* REPOSITORY- La función getTracingMedicalHistory_Orthopodology($clinicNameUrl, $medicalHistoryNumber) se encuentran dentro de src\AppBundle\Repository\tracingRepository.php definido dentro del ORM src\BackendBundle\Resources\config\tracing.orm.yml */
		// Cargamos los repositorios
		$tracing_repo = $em->getRepository("BackendBundle:Tracing");
		$typeTracing_repo = $em->getRepository("BackendBundle:TypeTracing");
		$orthopodologyHistory_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");
		$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		// Realizamos las consultas
		$tracingMedicalHistory = $tracing_repo->getTracingMedicalHistory_Orthopodology($clinicNameUrl, $medicalHistoryNumber);
		$tracingNew = new Tracing();
		$attr = array('clinicNameUrl'=>$clinicNameUrl);
		$form = $this->createForm(TracingType::class, $tracingNew,
			array(
				'allow_extra_fields'=> $userPermission,
				'attr'=> $attr
			)
		);
		$form->handleRequest($request);
		if($form->isSubmitted()){
			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();
				if($form->get("date")->getData() == null){
					$tracingNew->setDate(new \DateTime("now"));
				}else{
					$tracingNew->setDate($form->get("date")->getData());
				}
				$tracingNew->setTracing($form->get("tracing")->getData());
				$tracingNew->setUser($user);
				if($registrationDate==null){
					$TypeTracing = $typeTracing_repo->findOneByType('medical_history');
				}else{
					$TypeTracing = $typeTracing_repo->findOneByType('orthopodology_history');
				}
				$tracingNew->setType($TypeTracing);
				$orthopodologyHistory = $orthopodologyHistory_repo->getOrthopodologyHistory($clinicNameUrl, $medicalHistoryNumber, $registrationDate);
				$tracingNew->setOrthopodologyHistory($orthopodologyHistory);
				$medicalHistory = $medicalHistory_repo->getMedicalHistoryObject( $clinicNameUrl, $medicalHistoryNumber );
				$tracingNew->setMedicalHistory($medicalHistory);
				// persistimos los datos dentro de Doctirne
				$em->persist($tracingNew);
				// guardamos los datos persistidos dentro de la BD
				$flush = $em->flush();
				// Si se guardan correctamente los datos en la BD
				$status = ['type'=>'success','description'=>'Se ha creado una nueva Historia Clínica'];
			}else{
				$status = [	'type'=>'danger','description'=>'No se ha creado la nueva Historia Clínica correctamente'];
			}
			// generamos los mensajes FLASH (necesario activar las sesiones)
			$this->session->getFlashBag()->add("status", $status);
			return $this->redirectToRoute('tracing_create',
				array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber , 'registrationDate'=>$registrationDate));
		}
		// Enviamos el formulario y su vista a la plantilla TWIG
		return $this->render('AppBundle:Tracing:tracing_Create.html.twig',
			array(
				'userPermission'=>$userPermission,
				'medicalHistoryNumber'=>$medicalHistoryNumber,
				'clinicNameUrl'=>$clinicNameUrl,
				'tracingMedicalHistory'=>$tracingMedicalHistory,
				'form' => $form->createView()
			)
		);
	}

}
