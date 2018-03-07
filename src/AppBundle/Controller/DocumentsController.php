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
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
/**************************************************************************************************************/
class DocumentsController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO EJECUCIÓN AJAX PARA ELIMINAR DOCUMENTO **************************************************************/
	public function medicalHistoryDocRemoveAction( Request $request, $clinicNameUrl, $medicalHistoryNumber, $idDoc ) {
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
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para CREAR Historias Médicas ajenas a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionLoggedUser->getMedicalHistoryDocRemove()){
								}else{
				$status = [	'type'=>'danger','description'=>'No dispones de permisos suficientes para eliminar el documento.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$documents_repo = $em->getRepository("BackendBundle:Documents");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,  'clinic'=> $clinic));
			$medicalHistoryDoc = $documents_repo->findOneBy(array('id'=>$idDoc,  'medicalHistory'=> $medicalHistory));
		/******************************************************************************************************/
			// Localizado el documento, lo eliminamos			
			$em->remove($medicalHistoryDoc);
			// persistimos la eliminación dentro de la bD
			$flush = $em->flush();
			// preparamos los mensajes informativos según cada casuistica
			if($flush == null){
				$file_name = $medicalHistoryDoc->getDoc();
				unlink ( 'uploads/clinics/'.$clinicNameUrl.'/medicalHistory/'.$medicalHistoryNumber.'/'.$file_name );
				$status = [	'type'=>'success','description'=>'El documento se ha borrado correctamente.'];
			}else{
				$status = [	'type'=>'danger','description'=>'El documento no se ha borrado correctamente.'];
			}
			// generamos los mensajes FLASH (necesario activar las sesiones)
			$this->session->getFlashBag()->add("status", $status);
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/		
			return $this->redirectToRoute('medical_history_view', array(
				'clinicNameUrl'=>$clinicNameUrl, 
				'medicalHistoryNumber'=>$medicalHistoryNumber
			));
		/******************************************************************************************************/			
	}
/**************************************************************************************************************/
/* MÉTODO EJECUCIÓN AJAX PARA ELIMINAR DOCUMENTO **************************************************************/
	public function orthopodologyHistoryDocRemoveAction( Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate, $idDoc ) {
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
				$status = ['type'=>'danger','description'=>'No tiene permisos suficientes para CREAR Historias Médicas ajenas a su Clínica.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionLoggedUser->getOrthopodologyHistoryDocRemove()){
								}else{
				$status = [	'type'=>'danger','description'=>'No dispones de permisos suficientes para eliminar el documento.'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);				
				$permissionDenied = true;
			}
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
			$orhtopodologyHistory_repo = $em->getRepository("BackendBundle:OrthopodologyHistory");			
			$documents_repo = $em->getRepository("BackendBundle:Documents");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,  'clinic'=> $clinic));
			$orthopodologyHistoryDoc = $documents_repo->findOneBy(array('id'=>$idDoc));
		/******************************************************************************************************/
			// Localizado el documento, lo eliminamos			
			$em->remove($orthopodologyHistoryDoc);
			// persistimos la eliminación dentro de la bD
			$flush = $em->flush();
			// preparamos los mensajes informativos según cada casuistica
			if($flush == null){
				$file_name = $orthopodologyHistoryDoc->getDoc();
				unlink ( 'uploads/clinics/'.$clinicNameUrl.'/medicalHistory/'.$medicalHistoryNumber.'/orthopodologyHistory/'.$registrationDate.'/'.$file_name );
				$status = [	'type'=>'success','description'=>'El documento se ha borrado correctamente.'];
			}else{
				$status = [	'type'=>'danger','description'=>'El documento no se ha borrado correctamente.'];
			}
			// generamos los mensajes FLASH (necesario activar las sesiones)
			$this->session->getFlashBag()->add("status", $status);
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/		
			return $this->redirectToRoute('orthopodology_history_view', array(
				'clinicNameUrl'=>$clinicNameUrl, 
				'medicalHistoryNumber'=>$medicalHistoryNumber,
				'registrationDate'=>$registrationDate
			));
		/******************************************************************************************************/			
	}
/**************************************************************************************************************/
}