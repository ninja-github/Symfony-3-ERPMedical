<?php
/* Indicamos el namespace del Bundle **************************************************************************/
	namespace AppBundle\Controller;
/* COMPONENTES BÁSICOS DEL CONTROLADOR ************************************************************************/
	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
/* COMPONENTES SESSIÓN ****************************************************************************************/
	use Symfony\Component\HttpFoundation\Session\Session;
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	use BackendBundle\Entity\Clinic;        		// Da acceso a la Entidad Clinica
/* Añadimos los FORMULARIOS que usaremos **********************************************************************/
	use AppBundle\Form\ClinicType;                  // Da acceso al Formulario MedicalHistoryPatientType
/**************************************************************************************************************/
class AccountingController extends Controller {
/* OBJETO SESSIÓN - Para activar las sesiones inicializamos la variable e incluimos en ella el objeto Session()
 * No olvidar dar acceso al componenete de Symfony Session() permitirá usar los mensajes FLASHBAG             */
	private $session;
	public function __construct(){ $this->session = new Session(); }
/**************************************************************************************************************/
/* MÉTODO PARA RESUMEN CONTABILIDAD ***************************************************************************/
    public function accountingSummaryAction(Request $request, $clinicNameUrl, $year = null ){
        /* CARGA INICIAL **************************************************************************************/
            $em = $this->getDoctrine()->getManager();
            $userlogged = $this->getUser();	// extraemos el usuario de la sessión
        /******************************************************************************************************/
        /* INTRODUCE INFORMACIÓN SESIÓN USUARIO  **************************************************************/
            $setUserInformation = $em->getRepository("BackendBundle:UserSession")->setUserInformation($userlogged, $request);
        /******************************************************************************************************/
        /* EXTRAE PERMISOS DEL USUARIO  ***********************************************************************/
            $permissionLoggedUser = $em->getRepository("BackendBundle:UserPermission")->findOneByUser($userlogged);
        /******************************************************************************************************/
        /* PERMISO ACCESO *************************************************************************************/
            $permissionDenied = false;
            $clinicView= $em->getRepository("BackendBundle:Clinic")->findOneByNameUrl($clinicNameUrl);
            $clinicUserCorrect = $em->getRepository("BackendBundle:ClinicUser")->findOneBy(array('clinic'=>$clinicView, 'user'=>$userlogged));		
            if( $clinicUserCorrect == NULL && $permissionLoggedUser->getClinicViewOther() == false ){
                $status = ['type'=>'danger','description'=>'No tiene permisos suficientes para VISUALIZAR Clínicas Ajenas.'];
                // generamos los mensajes FLASH (necesario activar las sesiones)
                $this->session->getFlashBag()->add("status", $status);	
                $permissionDenied = true;				
            }
            if($permissionLoggedUser->getAccountingList() == false){ 
                $status = ['type'=>'danger','description'=>'No tiene permisos suficientes para VISUALIZAR la contabilidad.'];
                // generamos los mensajes FLASH (necesario activar las sesiones)
                $this->session->getFlashBag()->add("status", $status);	
                $permissionDenied = true;			
            }
            if ($permissionDenied == true){ return $this->redirectToRoute('homepage'); }
        /******************************************************************************************************/
        /* CARGO LOS REPOSITORIOS  ****************************************************************************/
            $clinic_repo = $em->getRepository("BackendBundle:Clinic");
            $tracing_repo = $em->getRepository("BackendBundle:Tracing");
            $invoiceIssued_repo = $em->getRepository("BackendBundle:InvoiceIssued"); 
            $invoiceService_repo = $em->getRepository("BackendBundle:InvoiceService"); 
            $payment_repo = $em->getRepository("BackendBundle:Payment"); 
        /******************************************************************************************************/
        /* REALIZO LAS CONSULTAS NECESARIAS A LA BD MEDIANTE LOS REPOSITORIOS *********************************/
            if($year == null){ 
                $date = new \DateTime("today");
                $year = $date->format('Y');
            }
            // listado de Cuentas
            $accountingSummary = $tracing_repo->getAccountingSummary($clinicNameUrl,$year);
            // Total mensual generado
            $accountingTotalFromTracingService = $tracing_repo->getAccountingTotal($clinicNameUrl,$year);
            $accountingTotalFromInvoiceService = $invoiceService_repo->getAccountingTotal($clinicNameUrl,$year);
            $accountingTotal = $accountingTotalFromTracingService;
            $months = array();
            foreach($accountingTotalFromInvoiceService as $month=>$value){
                if(!isset($accountingTotal[$month])){
                    $accountingTotal[$month] = $value;
                }else{
                    if(!isset($accountingTotalFromInvoiceService[$month]['countable'])){ $accountingTotalFromInvoiceService[$month]['countable'] = 0; }
                    if(!isset($accountingTotal[$month]['countable'])){$accountingTotal[$month]['countable'] = 0;}
                    $accountingTotal[$month]['countable'] = $accountingTotal[$month]['countable'] + $accountingTotalFromInvoiceService[$month]['countable'];
                    if(!isset($accountingTotalFromInvoiceService[$month]['noCountable'])){ $accountingTotalFromInvoiceService[$month]['noCountable'] = 0; }
                    if(!isset($accountingTotal[$month]['noCountable'])){$accountingTotal[$month]['noCountable'] = 0;}
                    $accountingTotal[$month]['noCountable'] = $accountingTotal[$month]['noCountable'] + $accountingTotalFromInvoiceService[$month]['noCountable'];
                }
            }
            // Total diario generado sin facturas (para los gráficos)
            $accountingTotalForDay = $payment_repo->getAccountingTotalForDay($clinicNameUrl,$year);
            // Listado de Años de los que hay datos (2015, 2016, 2017,...)
            $accountingOnlyYears = $tracing_repo->getAccountingOnlyYears($clinicNameUrl);
            $invoiceIssuedList = $invoiceIssued_repo->findAll(array('clinic'=>$clinicView,'medicalHistory'=>null));
        /******************************************************************************************************/			
        /* CARGAMOS LA VISTA CON SUS VARIABLES ****************************************************************/ 			
            return $this->render('AppBundle:Accounting:accounting_List.html.twig',
                array(
                    'permissionLoggedUser'=>$permissionLoggedUser,
                    'accountingSummary' => $accountingSummary,
                    'accountingTotal' => $accountingTotal,
                    'accountingOnlyYears'=>$accountingOnlyYears,
                    'invoiceIssuedList'=>$invoiceIssuedList,
                    'accountingTotalForDay'=>$accountingTotalForDay
                )
            );
        /******************************************************************************************************/			
        }
/**************************************************************************************************************/        
}