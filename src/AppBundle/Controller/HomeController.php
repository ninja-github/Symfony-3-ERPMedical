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
	use BackendBundle\Entity\Payment;        	// Da acceso a la Entidad Historia Médica
/**************************************************************************************************************/
class HomeController extends Controller {
/* CONSTRUCTOR ************************************************************************************************/
	/* OBJETO SESSIÓN Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session().
	/* No olvidar dar acceso al componenete de Symfony Session(), que permitirá usar los mensajes FLASHBAG
	/* use Symfony\Component\HttpFoundation\Session\Session; */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* INDEX ******************************************************************************************************/
	public function indexAction(Request $request) {
		/* CARGA INICIAL **************************************************************************************/
			$em = $this->getDoctrine()->getManager();
			$userlogged = $this->getUser();	// extraemos el usuario de la sessión
        /******************************************************************************************************/		
		/* USUARIO ACTIVO? ************************************************************************************/
			if($userlogged->getIsActive() == false){
				$status = ['type'=>'danger','description'=>'Usuario Bloqueado'];
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirect('login');
			}
        /******************************************************************************************************/			
		/* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
			$setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
        /******************************************************************************************************/			
		/* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
			$permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/		
			$clinicUser_repo = $em->getRepository("BackendBundle:ClinicUser");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$service_repo = $em->getRepository("BackendBundle:Service");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			/* Correccion tablas ******************************************************************************/
			// limpia el contador de logueos erróneos.... IMPORTANTE!!!!!
			$idUserlogged = $userlogged->getId();
			$clinicUserlogged = $clinicUser_repo->getDataClinicUserSession($idUserlogged);
			$clinicNameUrl = $clinicUserlogged['nameUrl'];
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$clinicUser = $clinicUser_repo->findByClinic($clinic);
			$servicesList = $service_repo->findBy(array('clinic'=>$clinic),array('weight'=>'DESC',));
			// Realizamos las consultas // funciones Repositorio usadas, ver 'src\BackendBundle\Repository'			
			$medicalHistoryRatioSex = $medicalHistory_repo->getRatioGenderQuery($clinicNameUrl);
			// Por terminar... Estadísticas consulta
			$newUsersPerMonth = $medicalHistory_repo->getMedicalHistoryPerMonthQuery( $clinicNameUrl );
			$totalUser = $medicalHistory_repo->getTotalNumberMedicalHistoriesQuery( $clinicNameUrl );
			//extraemos el resultado de la $query //////////////////////////////////////////////////////////////
			$session = $request->getSession();
			$session->set('clinicUserlogged', $clinicUserlogged);
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:Clinic:clinic_View.html.twig',
			//return $this->render('AppBundle:Home:home.html.twig',
				array (
					'permissionLoggedUser'=>$permissionLoggedUser,
					'request'=>$request,
					'clinic'=>$clinic,
					'clinicUser' => $clinicUser,
					'medicalHistoryRatioSex'=>$medicalHistoryRatioSex,
					'servicesList'=>$servicesList,
					'newUsersPerMonth'=>$newUsersPerMonth
				)
			);
		/******************************************************************************************************/
	}
/**************************************************************************************************************/
}