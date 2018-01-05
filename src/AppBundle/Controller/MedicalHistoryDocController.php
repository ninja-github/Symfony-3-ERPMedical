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
class MedicalHistoryDocController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO EJECUCIÓN AJAX PARA ELIMINAR DOCUMENTO **************************************************************/
	public function medicalHistoryDocRemoveAction( Request $request, $clinicNameUrl, $medicalHistoryNumber, $idDoc ) {
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
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false ){return $this->redirectToRoute('homepage');}
		/******************************************************************************************************/
		if ($permissionLoggedUser->getMedicalHistoryDocRemove()){
			$clinic = $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $em->getRepository("BackendBundle:MedicalHistory")->findOneBy(array('numberMedicalHistory'=>$medicalHistoryNumber,  'clinic'=> $clinic));
			$medicalHistoryDoc = $em->getRepository("BackendBundle:MedicalHistoryDoc")->findOneBy(array('id'=>$idDoc,  'medicalHistory'=> $medicalHistory));
			$em->remove($medicalHistoryDoc);
			// persistimos la eliminación dentro de la bD
			$flush = $em->flush();
			// preparamos los mensajes informativos según cada casuistica
			if($flush == null){
				$file_name = $medicalHistoryDoc->getDoc();
				unlink ( 'uploads/clinics/'.$clinicNameUrl.'/medicalHistory/'.$medicalHistoryNumber.'/'.$file_name );
				$status = [	'type'=>'success','description'=>'El documento se ha borrado'];
			}else{
				$status = [	'type'=>'danger','description'=>'El documento no se ha borrado'];
			}
		}else{
			$status = [	'type'=>'danger','description'=>'No dispones de permisos suficientes'];
		}
		// generamos los mensajes FLASH (necesario activar las sesiones)
		$this->session->getFlashBag()->add("status", $status);
		return $this->redirectToRoute('medical_history_view', array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber));
	}
/*********************************************************************/
}