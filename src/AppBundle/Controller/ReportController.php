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
	use BackendBundle\Entity\Report;			// Da acceso a la Entidad AddressCity
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\ReportType;					// Da acceso al Formulario TracingType
/**************************************************************************************************************/
class ReportController extends Controller{
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA LISTAR INFORMES ********************************************************************************/
	public function reportListAction(Request $request, $clinicNameUrl = null){
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
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede listar informes
			if( $permissionLoggedUser->getReportList() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede listar informes'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				$permissionDenied = true;
			};
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }			
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$report_repo = $em->getRepository("BackendBundle:Report");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$reportList = $report_repo->getReportListOfClinic($clinicNameUrl);
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:Report:report_List.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'reportList'=>$reportList
				)
			);
		/******************************************************************************************************/		
	}
/**************************************************************************************************************/
/* MÉTODO PARA VER INFORMES ***********************************************************************************/
	public function reportViewAction(Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate){
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
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede ver informes
			if( $permissionLoggedUser->getReportView() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede ver informes'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				$permissionDenied = true;
			};
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$report_repo = $em->getRepository("BackendBundle:Report");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,'clinic'=>$clinic));
			$reportList = $report_repo->findBy(array('medicalHistory'=>$medicalHistory),array('registrationDate'=>'DESC'));
			foreach ($reportList as $key=>$clave){
				if ( $clave->getRegistrationDate()->format('Y_m_d') == $registrationDate ){
					$report = $clave;
				}
			}
			$reportClinicList = $report_repo->getReportListOfClinic($clinicNameUrl);
			foreach ($reportClinicList as $key=>$clave){
				$reportBeforeNext['clinicNameUrl'] = $clinicNameUrl;
				$count = count($reportClinicList);
				$next = $key + 1;
				$before = $key - 1;
				if($report->getId() == $clave->getId() ){
					if( isset ($reportClinicList[$next])){
						$reportBeforeNext['next']['medicalHistory'] = $reportClinicList[$next]->getMedicalHistory()->getMedicalHistoryNumber();
						$reportBeforeNext['next']['registrationDate'] = $reportClinicList[$next]->getRegistrationDate()->format('Y_m_d');
					}
					if( isset($reportClinicList[$before]) ){
						$reportBeforeNext['before']['medicalHistory'] = $reportClinicList[$before]->getMedicalHistory()->getMedicalHistoryNumber();
						$reportBeforeNext['before']['registrationDate'] = $reportClinicList[$before]->getRegistrationDate()->format('Y_m_d');
					}
				}
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/  
			return $this->render('AppBundle:Report:report_View.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'report'=>$report,
					'reportBeforeNext'=>$reportBeforeNext,
					'reportClinicList'=>$reportClinicList
				)
			);
		/******************************************************************************************************/
	}		
/**************************************************************************************************************/
/* MÉTODO PARA EDITAR INFORMES ********************************************************************************/
	public function reportEditAction(Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate){
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
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede ver informes
			if( $permissionLoggedUser->getReportView() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede ver informes'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				$permissionDenied = true;
			};
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }			
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$report_repo = $em->getRepository("BackendBundle:Report");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,'clinic'=>$clinic));
			$reportList = $report_repo->findBy(array('medicalHistory'=>$medicalHistory));
			foreach ($reportList as $key=>$clave){
				if ($clave->getRegistrationDate()->format('Y_m_d') == $registrationDate ){
					$report = $clave;
				}
			}
		/******************************************************************************************************/
		/* FORMULARO EDITAR HISTORIA **************************************************************************/
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'userLoggedId'=>$userLogged->getId());
			// Creamos el formulario
			$form = $this->createForm(ReportType::class,
				$report,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form->handleRequest($request);
			if($form->isSubmitted()){
				if($form->isValid()){
					//$request->request->get('report')['medicalHistoryDataComplete'];
					$medicalHistory = null;
					if($request->request->get('medicalHistoryDataComplete')){
						$medicalHistoryDataComplete = $request->request->get('medicalHistoryDataComplete');
						$strLenghtMedicalHistoryNumber = stripos($medicalHistoryDataComplete,' - ');
						$medicalHistoryNumber = substr($medicalHistoryDataComplete,0,$strLenghtMedicalHistoryNumber);
						$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,'clinic'=>$clinic));
					}
					$report->setReasonConsultation($form->get("reasonConsultation")->getData());
					$report->setDiagnostic($form->get("diagnostic")->getData());
					$report->setTreatment($form->get("treatment")->getData());
					$report->setRegistrationDate($form->get("registrationDate")->getData());
					$report->setMedicalHistory($medicalHistory);
					$report->setUser($userLogged);																		
					/**********************************************************************************************/
					$em->persist($report);	// persistimos los datos dentro de Doctirne
					$flush = $em->flush();	// guardamos los datos persistidos dentro de la BD
					// Si se guardan correctamente los datos en la BD
					$status = ['type'=>'success','description'=>'Se ha actualizado la Historia Clínica'];
				}else{
					$status = ['type'=>'danger','description'=>'No se han actualizado los datos correctamente'];
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('report_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'registrationDate'=>$registrationDate ));
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			// Enviamos el formulario y su vista a la plantilla TWIG					
			return $this->render('AppBundle:Report:report_Edit.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'report'=>$report,
					'form'=>$form->createView()
				)
			);
		/******************************************************************************************************/
	}		
/**************************************************************************************************************/
/* MÉTODO PARA CREAR INFORME **********************************************************************************/
	public function reportCreateAction(Request $request, $clinicNameUrl, $medicalHistoryNumber){
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
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede ver informes
			if( $permissionLoggedUser->getReportCreate() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede crear informes'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				$permissionDenied = true;
			};
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }			
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$report_repo = $em->getRepository("BackendBundle:Report");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,'clinic'=>$clinic));	
		/******************************************************************************************************/
		/* FORMULARO EDITAR HISTORIA **************************************************************************/
			// Creamos el Objeto Report con la información
			$report = new Report();
			$attr = array('clinicNameUrl'=>$clinicNameUrl, 'userLoggedId'=>$userLogged->getId(),'medicalHistoryNumber'=>$medicalHistoryNumber);
			// Creamos el formulario
			$form = $this->createForm(ReportType::class,
				$report,
				array(
					'allow_extra_fields'=> $permissionLoggedUser,
					'attr'=> $attr
				)
			);
			$form->handleRequest($request);
			if($form->isSubmitted()){
				if($form->isValid()){
					//$request->request->get('report')['medicalHistoryDataComplete'];
					$registrationDate = $form->get("registrationDate")->getData() ;
					$medicalHistory = null;
					if($request->request->get('medicalHistoryDataComplete')){
						$medicalHistoryDataComplete = $request->request->get('medicalHistoryDataComplete');
						$strLenghtMedicalHistoryNumber = stripos($medicalHistoryDataComplete,' - ');
						$medicalHistoryNumber = substr($medicalHistoryDataComplete,0,$strLenghtMedicalHistoryNumber);
						$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,'clinic'=>$clinic));
					}
					$report->setReasonConsultation($form->get("reasonConsultation")->getData());
					$report->setDiagnostic($form->get("diagnostic")->getData());
					$report->setTreatment($form->get("treatment")->getData());
					$report->setRegistrationDate($registrationDate);
					$report->setMedicalHistory($medicalHistory);
					$report->setUser($userLogged);																		
					/**********************************************************************************************/
					$em->persist($report);	// persistimos los datos dentro de Doctirne
					$flush = $em->flush();	// guardamos los datos persistidos dentro de la BD
					// Si se guardan correctamente los datos en la BD
					$status = ['type'=>'success','description'=>'Se ha creado un nuevo Informe'];
				}else{
					$status = ['type'=>'danger','description'=>'No se ha creado un nuevo Informe'];
				}
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				return $this->redirectToRoute('report_view',
					array('clinicNameUrl'=>$clinicNameUrl, 'medicalHistoryNumber'=>$medicalHistoryNumber, 'registrationDate'=>$registrationDate->format("Y_m_d")));
			}
		/******************************************************************************************************/
		/* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/
			// Enviamos el formulario y su vista a la plantilla TWIG					
			return $this->render('AppBundle:Report:report_Create.html.twig',
				array(
					'permissionLoggedUser'=>$permissionLoggedUser,
					'form'=>$form->createView()
				)
			);
		/******************************************************************************************************/
	}		
/**************************************************************************************************************/
/* MÉTODO PARA LANZAR PDF *************************************************************************************/
	public function reportPdfAction(Request $request, $clinicNameUrl, $medicalHistoryNumber, $registrationDate){
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
			// El usuario pertenece a la clínica y no puede ver otras clínicas
			if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false) {
				$status = ['type'=>'danger','description'=>'El usuario pertenece a otra clínica y no tiene acceso'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);
				$permissionDenied = true;
			};
			// El usuario puede ver informes
			if( $permissionLoggedUser->getReportPdf() == false ){
				$status = ['type'=>'danger','description'=>'El usuario no puede ver informes en pdf'];
				// generamos los mensajes FLASH (necesario activar las sesiones)
				$this->session->getFlashBag()->add("status", $status);		
				$permissionDenied = true;
			};
			if ($permissionDenied){ return $this->redirectToRoute('homepage'); }				
		/******************************************************************************************************/
		/* CARGO LOS REPOSITORIOS  ****************************************************************************/
			$report_repo = $em->getRepository("BackendBundle:Report");
			$clinic_repo = $em->getRepository("BackendBundle:Clinic");
			$medicalHistory_repo = $em->getRepository("BackendBundle:MedicalHistory");
		/******************************************************************************************************/
		/* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
			$clinic = $clinic_repo->findOneByNameUrl($clinicNameUrl);
			$medicalHistory = $medicalHistory_repo->findOneBy(array('medicalHistoryNumber'=>$medicalHistoryNumber,'clinic'=>$clinic));
			$reportList = $report_repo->findBy(array('medicalHistory'=>$medicalHistory));
			foreach ($reportList as $key=>$clave){
				if ($clave->getRegistrationDate()->format('Y_m_d') == $registrationDate ){
					$report = $clave;
				}
			}
		/******************************************************************************************************/
		/* GENERAMOS PDF Y LO GUARDAMOS ***************************************************************/		
			$img_clinic = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath().'/uploads/clinics/'.$medicalHistory->getClinic()->getNameUrl().'/'.$medicalHistory->getClinic()->getImage();
			$html = $this->renderView(
				// src/AppBundle/Resources/views/Pruebas/pruebas_View_pdf.html.twig			
				'AppBundle:Report:report_View_pdf.html.twig',
				// indicamos las variables de entrada a la plantilla
				array('report'=>$report,
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
}