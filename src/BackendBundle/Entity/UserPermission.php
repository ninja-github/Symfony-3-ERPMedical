<?php
/* Namespace **************************************************************************************************/
	namespace BackendBundle\Entity;
/* Añadimos el VALIDADOR **************************************************************************************/
/*
 * Definimos el sistema de validación de los datos en las entidades dentro de "app\config\config.yml"
 * y la gestionamos en "src\AppBundle\Resources\config\validation.yml",
 * cada entidad deberá llamar a "use Symfony\Component\Validator\Constraints as Assert;"
 * VER src\BackendBundle\Entity\User.php
 */
	use Symfony\Component\Validator\Constraints as Assert;
/**************************************************************************************************************/
class UserPermission {
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* idUser *****************************************************************************************************/
	private $user;
	public function setUser(\BackendBundle\Entity\User $user) { $this->user = $user; return $this; }
	public function getUser() { return $this->user; }
/**************************************************************************************************************/
/* USER *******************************************************************************************************/
	/* userList ***********************************************************************************************/
		private $userList = '0';
		public function setUserList($userList) { $this->userList = $userList; return $this; } 
		public function getUserList() { return $this->userList; }
	/**********************************************************************************************************/
	/* userView ***********************************************************************************************/		
		private $userView = '0';
		public function setUserView($userView) { $this->userView = $userView; return $this; } 
		public function getUserView() { return $this->userView; }
	/**********************************************************************************************************/
	/* userCreate *********************************************************************************************/
		private $userCreate = '0';
		public function setUserCreate($userCreate) { $this->userCreate = $userCreate; return $this; }
		public function getUserCreate() { return $this->userCreate; }
	/**********************************************************************************************************/
	/* userEdit ***********************************************************************************************/
		private $userEdit = '0';
		public function setUserEdit($userEdit) { $this->userEdit = $userEdit; return $this; }
		public function getUserEdit() { return $this->userEdit; }
	/**********************************************************************************************************/
	/* userRemove *********************************************************************************************/
		private $userRemove = '0';
		public function setUserRemove($userRemove) { $this->userRemove = $userRemove; return $this; }
		public function getUserRemove() { return $this->userRemove; }
	/**********************************************************************************************************/
	/* userDumpView *******************************************************************************************/
		private $userDumpView = '0';
		public function setUserDumpView($userDumpView) { $this->userDumpView = $userDumpView; return $this; }
		public function getUserDumpView() { return $this->userDumpView; }
	/**********************************************************************************************************/
	/* userPermission *****************************************************************************************/
		private $userPermission = '0';
		public function setUserPermission($userPermission) { $this->userPermission = $userPermission; return $this; }
		public function getUserPermission() { return $this->userPermission; }
	/**********************************************************************************************************/
	/* clinicViewOther ****************************************************************************************/
		private $clinicViewOther = '0';
		public function setClinicViewOther($clinicViewOther) { $this->clinicViewOther = $clinicViewOther; return $this; }
		public function getClinicViewOther() { return $this->clinicViewOther; }
	/**********************************************************************************************************/	
/**************************************************************************************************************/
/* CLINIC *****************************************************************************************************/
	/* clinicList *******************************************************************************************/		
		private $clinicList = '0';
		public function setClinicList($clinicList) { $this->clinicList = $clinicList; return $this; } 
		public function getClinicList() { return $this->clinicList; } 
	/**********************************************************************************************************/
	/* clinicCreate *******************************************************************************************/		
		private $clinicView = '0';
		public function setClinicView($clinicView) { $this->clinicView = $clinicView; return $this; } 
		public function getClinicView() { return $this->clinicView; } 
	/**********************************************************************************************************/
	/* clinicCreate *******************************************************************************************/
		private $clinicCreate = '0';
		public function setClinicCreate($clinicCreate) { $this->clinicCreate = $clinicCreate; return $this; }
		public function getClinicCreate() { return $this->clinicCreate; }
	/**********************************************************************************************************/
	/* clinicEdit *********************************************************************************************/
		private $clinicEdit = '0';
		public function setClinicEdit($clinicEdit) { $this->clinicEdit = $clinicEdit; return $this; }
		public function getClinicEdit() { return $this->clinicEdit; }
	/**********************************************************************************************************/
	/* clinicRemove *******************************************************************************************/
		private $clinicRemove = '0';
		public function setClinicRemove($clinicRemove) { $this->clinicRemove = $clinicRemove; return $this; }
		public function getClinicRemove() { return $this->clinicRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* CLINICDOC *****************************************************************************************************/
	/* clinicDocList *******************************************************************************************/		
		private $clinicDocList = '0';
		public function setClinicDocList($clinicDocList) { $this->clinicDocList = $clinicDocList; return $this; } 
		public function getClinicDocList() { return $this->clinicDocList; } 
	/**********************************************************************************************************/
	/* clinicDocCreate *******************************************************************************************/		
		private $clinicDocView = '0';
		public function setClinicDocView($clinicDocView) { $this->clinicDocView = $clinicDocView; return $this; } 
		public function getClinicDocView() { return $this->clinicDocView; } 
	/**********************************************************************************************************/
	/* clinicDocCreate *******************************************************************************************/
		private $clinicDocCreate = '0';
		public function setClinicDocCreate($clinicDocCreate) { $this->clinicDocCreate = $clinicDocCreate; return $this; }
		public function getClinicDocCreate() { return $this->clinicDocCreate; }
	/**********************************************************************************************************/
	/* clinicDocEdit *********************************************************************************************/
		private $clinicDocEdit = '0';
		public function setClinicDocEdit($clinicDocEdit) { $this->clinicDocEdit = $clinicDocEdit; return $this; }
		public function getClinicDocEdit() { return $this->clinicDocEdit; }
	/**********************************************************************************************************/
	/* clinicDocRemove *******************************************************************************************/
		private $clinicDocRemove = '0';
		public function setClinicDocRemove($clinicDocRemove) { $this->clinicDocRemove = $clinicDocRemove; return $this; }
		public function getClinicDocRemove() { return $this->clinicDocRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* MEDICALHISTORY *********************************************************************************************/
	/* medicalHistoryList ***********************************************************************************/		
		private $medicalHistoryList = '0';
		public function setMedicalHistoryList($medicalHistoryList) { $this->medicalHistoryList = $medicalHistoryList; return $this; } 
		public function getMedicalHistoryList() { return $this->medicalHistoryList; } 	
	/**********************************************************************************************************/		
	/* medicalHistoryView *************************************************************************************/
		private $medicalHistoryView = '0';
		public function setMedicalHistoryView($medicalHistoryView) { $this->medicalHistoryView = $medicalHistoryView; return $this; } 
		public function getMedicalHistoryView() { return $this->medicalHistoryView; } 	
	/**********************************************************************************************************/
	/* medicalHistoryCreate ***********************************************************************************/
		private $medicalHistoryCreate = '0';
		public function setMedicalHistoryCreate($medicalHistoryCreate) { $this->medicalHistoryCreate = $medicalHistoryCreate; return $this; }
		public function getMedicalHistoryCreate() { return $this->medicalHistoryCreate; }
	/**********************************************************************************************************/
	/* medicalHistoryEdit *************************************************************************************/
		private $medicalHistoryEdit = '0';
		public function setMedicalHistoryEdit($medicalHistoryEdit) { $this->medicalHistoryEdit = $medicalHistoryEdit; return $this; }
		public function getMedicalHistoryEdit() { return $this->medicalHistoryEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryRemove ***********************************************************************************/
		private $medicalHistoryRemove = '0';
		public function setMedicalHistoryRemove($medicalHistoryRemove) { $this->medicalHistoryRemove = $medicalHistoryRemove; return $this; }
		public function getMedicalHistoryRemove() { return $this->medicalHistoryRemove; }
	/**********************************************************************************************************/
	/* medicalHistoryRegistrationDateEdit *********************************************************************/
		private $medicalHistoryRegistrationDateEdit = '0';
		public function setMedicalHistoryRegistrationDateEdit($medicalHistoryRegistrationDateEdit) { $this->medicalHistoryRegistrationDateEdit = $medicalHistoryRegistrationDateEdit; return $this; }
		public function getMedicalHistoryRegistrationDateEdit() { return $this->medicalHistoryRegistrationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryIdUserRegistererEdit *********************************************************************/
		private $medicalHistoryUserRegistererEdit = '0';
		public function setMedicalHistoryUserRegistererEdit($medicalHistoryUserRegistererEdit) { $this->medicalHistoryUserRegistererEdit = $medicalHistoryUserRegistererEdit; return $this; }
		public function getMedicalHistoryUserRegistererEdit() { return $this->medicalHistoryUserRegistererEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryModificationDateEdit *********************************************************************/
		private $medicalHistoryModificationDateEdit = '0';
		public function setMedicalHistoryModificationDateEdit($medicalHistoryModificationDateEdit) { $this->medicalHistoryModificationDateEdit = $medicalHistoryModificationDateEdit; return $this; }
		public function getMedicalHistoryModificationDateEdit() { return $this->medicalHistoryModificationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryModifierDateEdit *************************************************************************/
		private $medicalHistoryUserModifierEdit = '0';
		public function setMedicalHistoryUserModifierEdit($medicalHistoryUserModifierEdit) { $this->medicalHistoryUserModifierEdit = $medicalHistoryUserModifierEdit; return $this; }
		public function getMedicalHistoryUserModifierEdit() { return $this->medicalHistoryUserModifierEdit; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* MEDICALHISTORYDOC ******************************************************************************************/
	/* medicalHistoryDocList **********************************************************************************/
		private $medicalHistoryDocList = '0';
		public function setMedicalHistoryDocList($medicalHistoryDocList) { $this->medicalHistoryDocList = $medicalHistoryDocList; return $this; } 
		public function getMedicalHistoryDocList() { return $this->medicalHistoryDocList; }	
	/**********************************************************************************************************/
	/* medicalHistoryDocList **********************************************************************************/	
		private $medicalHistoryDocView = '0';
		public function setMedicalHistoryDocView($medicalHistoryDocView) { $this->medicalHistoryDocView = $medicalHistoryDocView; return $this; } 
		public function getMedicalHistoryDocView() { return $this->medicalHistoryDocView; }	
	/**********************************************************************************************************/
	/* medicalHistoryDocCreate ********************************************************************************/
		private $medicalHistoryDocCreate = '0';
		public function setMedicalHistoryDocCreate($medicalHistoryDocCreate) { $this->medicalHistoryDocCreate = $medicalHistoryDocCreate; return $this; }
		public function getMedicalHistoryDocCreate() { return $this->medicalHistoryDocCreate; }
	/**********************************************************************************************************/
	/* medicalHistoryDocEdit **********************************************************************************/
		private $medicalHistoryDocEdit = '0';
		public function setMedicalHistoryDocEdit($medicalHistoryDocEdit) { $this->medicalHistoryDocEdit = $medicalHistoryDocEdit; return $this; }
		public function getMedicalHistoryDocEdit() { return $this->medicalHistoryDocEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocRemove ********************************************************************************/
		private $medicalHistoryDocRemove = '0';
		public function setMedicalHistoryDocRemove($medicalHistoryDocRemove) { $this->medicalHistoryDocRemove = $medicalHistoryDocRemove; return $this; }
		public function getMedicalHistoryDocRemove() { return $this->medicalHistoryDocRemove; }
	/**********************************************************************************************************/
	/* medicalHistoryDocRegistrationDateEdit ******************************************************************/
		private $medicalHistoryDocRegistrationDateEdit = '0';
		public function setMedicalHistoryDocRegistrationDateEdit($medicalHistoryDocRegistrationDateEdit) { $this->medicalHistoryDocRegistrationDateEdit = $medicalHistoryDocRegistrationDateEdit; return $this; }
		public function getMedicalHistoryDocRegistrationDateEdit() { return $this->medicalHistoryDocRegistrationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocIdUserRegistererEdit ******************************************************************/
		private $medicalHistoryDocUserRegistererEdit = '0';
		public function setMedicalHistoryDocUserRegistererEdit($medicalHistoryDocUserRegistererEdit) { $this->medicalHistoryDocUserRegistererEdit = $medicalHistoryDocUserRegistererEdit; return $this; }
		public function getMedicalHistoryDocUserRegistererEdit() { return $this->medicalHistoryDocUserRegistererEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocModificationDateEdit ******************************************************************/
		private $medicalHistoryDocModificationDateEdit = '0';
		public function setMedicalHistoryDocModificationDateEdit($medicalHistoryDocModificationDateEdit) { $this->medicalHistoryDocModificationDateEdit = $medicalHistoryDocModificationDateEdit; return $this; }
		public function getMedicalHistoryDocModificationDateEdit() { return $this->medicalHistoryDocModificationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocModifierDateEdit **********************************************************************/
		private $medicalHistoryDocUserModifierEdit = '0';
		public function setMedicalHistoryDocUserModifierEdit($medicalHistoryDocUserModifierEdit) { $this->medicalHistoryDocUserModifierEdit = $medicalHistoryDocUserModifierEdit; return $this; }
		public function getMedicalHistoryDocUserModifierEdit() { return $this->medicalHistoryDocUserModifierEdit; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* ORTHOPODOLOGYHISTORY ***************************************************************************************/
	/* orthopodologyHistoryList *****************************************************************************/
		private $orthopodologyHistoryList = '0';
		public function setOrthopodologyHistoryList($orthopodologyHistoryList) { $this->orthopodologyHistoryList = $orthopodologyHistoryList; return $this; }
		public function getOrthopodologyHistoryList() { return $this->orthopodologyHistoryList; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryView *****************************************************************************/
		private $orthopodologyHistoryView = '0';
		public function setOrthopodologyHistoryView($orthopodologyHistoryView) { $this->orthopodologyHistoryView = $orthopodologyHistoryView; return $this; }
		public function getOrthopodologyHistoryView() { return $this->orthopodologyHistoryView; }
	/**********************************************************************************************************/	
	/* orthopodologyHistoryCreate *****************************************************************************/
		private $orthopodologyHistoryCreate = '0';
		public function setOrthopodologyHistoryCreate($orthopodologyHistoryCreate) { $this->orthopodologyHistoryCreate = $orthopodologyHistoryCreate; return $this; }
		public function getOrthopodologyHistoryCreate() { return $this->orthopodologyHistoryCreate; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryEdit *******************************************************************************/
		private $orthopodologyHistoryEdit = '0';
		public function setOrthopodologyHistoryEdit($orthopodologyHistoryEdit) { $this->orthopodologyHistoryEdit = $orthopodologyHistoryEdit; return $this; }
		public function getOrthopodologyHistoryEdit() { return $this->orthopodologyHistoryEdit; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryRemove *****************************************************************************/
		private $orthopodologyHistoryRemove = '0';
		public function setOrthopodologyHistoryRemove($orthopodologyHistoryRemove) { $this->orthopodologyHistoryRemove = $orthopodologyHistoryRemove; return $this; }
		public function getOrthopodologyHistoryRemove() { return $this->orthopodologyHistoryRemove; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryRegistrationDateEdit ***************************************************************/
		private $orthopodologyHistoryRegistrationDateEdit = '0';
		public function setOrthopodologyHistoryRegistrationDateEdit($orthopodologyHistoryRegistrationDateEdit) { $this->orthopodologyHistoryRegistrationDateEdit = $orthopodologyHistoryRegistrationDateEdit; return $this; }
		public function getOrthopodologyHistoryRegistrationDateEdit() { return $this->orthopodologyHistoryRegistrationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryIdUserRegistererEdit *********************************************************************/
		private $orthopodologyHistoryUserRegistererEdit = '0';
		public function setOrthopodologyHistoryUserRegistererEdit($orthopodologyHistoryUserRegistererEdit) { $this->orthopodologyHistoryUserRegistererEdit = $orthopodologyHistoryUserRegistererEdit; return $this; }
		public function getOrthopodologyHistoryUserRegistererEdit() { return $this->orthopodologyHistoryUserRegistererEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryModificationDateEdit *********************************************************************/
		private $orthopodologyHistoryModificationDateEdit = '0';
		public function setOrthopodologyHistoryModificationDateEdit($orthopodologyHistoryModificationDateEdit) { $this->orthopodologyHistoryModificationDateEdit = $orthopodologyHistoryModificationDateEdit; return $this; }
		public function getOrthopodologyHistoryModificationDateEdit() { return $this->orthopodologyHistoryModificationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryModifierDateEdit *************************************************************************/
		private $orthopodologyHistoryUserModifierEdit = '0';
		public function setOrthopodologyHistoryUserModifierEdit($orthopodologyHistoryUserModifierEdit) { $this->orthopodologyHistoryUserModifierEdit = $orthopodologyHistoryUserModifierEdit; return $this; }
		public function getOrthopodologyHistoryUserModifierEdit() { return $this->orthopodologyHistoryUserModifierEdit; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* ORTHOPODOLOGYHISTORYDOC ************************************************************************************/
	/* orthopodologyHistoryDocList ****************************************************************************/
		private $orthopodologyHistoryDocList = '0';
		public function setOrthopodologyHistoryDocList($orthopodologyHistoryDocList) { $this->orthopodologyHistoryDocList = $orthopodologyHistoryDocList; return $this; } 
		public function getOrthopodologyHistoryDocList() { return $this->orthopodologyHistoryDocList; } 
	/**********************************************************************************************************/  
	/* orthopodologyHistoryDocView ****************************************************************************/	  	
		private $orthopodologyHistoryDocView = '0'; 
		public function setOrthopodologyHistoryDocView($orthopodologyHistoryDocView) { $this->orthopodologyHistoryDocView = $orthopodologyHistoryDocView; return $this; } 
		public function getOrthopodologyHistoryDocView() { return $this->orthopodologyHistoryDocView; } 	
	/**********************************************************************************************************/  
	/* orthopodologyHistoryDocCreate **************************************************************************/
		private $orthopodologyHistoryDocCreate = '0';
		public function setOrthopodologyHistoryDocCreate($orthopodologyHistoryDocCreate) { $this->orthopodologyHistoryDocCreate = $orthopodologyHistoryDocCreate; return $this; }
		public function getOrthopodologyHistoryDocCreate() { return $this->orthopodologyHistoryDocCreate; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryDocEdit ****************************************************************************/
		private $orthopodologyHistoryDocEdit = '0';
		public function setOrthopodologyHistoryDocEdit($orthopodologyHistoryDocEdit) { $this->orthopodologyHistoryDocEdit = $orthopodologyHistoryDocEdit; return $this; }
		public function getOrthopodologyHistoryDocEdit() { return $this->orthopodologyHistoryDocEdit; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryDocRemove **************************************************************************/
		private $orthopodologyHistoryDocRemove = '0';
		public function setOrthopodologyHistoryDocRemove($orthopodologyHistoryDocRemove) { $this->orthopodologyHistoryDocRemove = $orthopodologyHistoryDocRemove; return $this; }
		public function getOrthopodologyHistoryDocRemove() { return $this->orthopodologyHistoryDocRemove; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryDocRegistrationDateEdit ************************************************************/
		private $orthopodologyHistoryDocRegistrationDateEdit = '0';
		public function setOrthopodologyHistoryDocRegistrationDateEdit($orthopodologyHistoryDocRegistrationDateEdit) { $this->orthopodologyHistoryDocRegistrationDateEdit = $orthopodologyHistoryDocRegistrationDateEdit; return $this; }
		public function getOrthopodologyHistoryDocRegistrationDateEdit() { return $this->orthopodologyHistoryDocRegistrationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocIdUserRegistererEdit ******************************************************************/
		private $orthopodologyHistoryDocUserRegistererEdit = '0';
		public function setOrthopodologyHistoryDocUserRegistererEdit($orthopodologyHistoryDocUserRegistererEdit) { $this->orthopodologyHistoryDocUserRegistererEdit = $orthopodologyHistoryDocUserRegistererEdit; return $this; }
		public function getOrthopodologyHistoryDocUserRegistererEdit() { return $this->orthopodologyHistoryDocUserRegistererEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocModificationDateEdit ******************************************************************/
		private $orthopodologyHistoryDocModificationDateEdit = '0';
		public function setOrthopodologyHistoryDocModificationDateEdit($orthopodologyHistoryDocModificationDateEdit) { $this->orthopodologyHistoryDocModificationDateEdit = $orthopodologyHistoryDocModificationDateEdit; return $this; }
		public function getOrthopodologyHistoryDocModificationDateEdit() { return $this->orthopodologyHistoryDocModificationDateEdit; }
	/**********************************************************************************************************/
	/* medicalHistoryDocModifierDateEdit **********************************************************************/
		private $orthopodologyHistoryDocUserModifierEdit = '0';
		public function setOrthopodologyHistoryDocUserModifierEdit($orthopodologyHistoryDocUserModifierEdit) { $this->orthopodologyHistoryDocUserModifierEdit = $orthopodologyHistoryDocUserModifierEdit; return $this; }
		public function getOrthopodologyHistoryDocUserModifierEdit() { return $this->orthopodologyHistoryDocUserModifierEdit; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* REPORT ****************************************************************************************************/
	/* reportList ******************************************************************************************/
		private $reportList = '0';
		public function setReportList($reportList) { $this->reportList = $reportList; return $this; }
		public function getReportList() { return $this->reportList; }
	/**********************************************************************************************************/
	/* reportView ******************************************************************************************/
		private $reportView = '0';
		public function setReportView($reportView) { $this->reportView = $reportView; return $this; }
		public function getReportView() { return $this->reportView; }
	/**********************************************************************************************************/	
	/* reportCreate ******************************************************************************************/
		private $reportCreate = '0';
		public function setReportCreate($reportCreate) { $this->reportCreate = $reportCreate; return $this; }
		public function getReportCreate() { return $this->reportCreate; }
	/**********************************************************************************************************/
	/* reportEdit ********************************************************************************************/
		private $reportEdit = '0';
		public function setReportEdit($reportEdit) { $this->reportEdit = $reportEdit; return $this; }
		public function getReportEdit() { return $this->reportEdit; }
	/**********************************************************************************************************/
	/* reportRemove ******************************************************************************************/
		private $reportRemove = '0';
		public function setReportRemove($reportRemove) { $this->reportRemove = $reportRemove; return $this; }
		public function getReportRemove() { return $this->reportRemove; }
	/**********************************************************************************************************/
	/* reportRemove ******************************************************************************************/
		private $reportPdf = '0';
		public function setReportPdf($reportPdf) { $this->reportPdf = $reportPdf; return $this; }
		public function getReportPdf() { return $this->reportPdf; }
	/**********************************************************************************************************/		
/**************************************************************************************************************/
/* INVOICE ****************************************************************************************************/
	/* invoiceList ******************************************************************************************/
		private $invoiceIssuedList = '0';
		public function setInvoiceIssuedList($invoiceIssuedList) { $this->invoiceIssuedList = $invoiceIssuedList; return $this; }
		public function getInvoiceIssuedList() { return $this->invoiceIssuedList; }
	/**********************************************************************************************************/
	/* invoiceView ******************************************************************************************/
		private $invoiceIssuedView = '0';
		public function setInvoiceIssuedView($invoiceIssuedView) { $this->invoiceIssuedView = $invoiceIssuedView; return $this; }
		public function getInvoiceIssuedView() { return $this->invoiceIssuedView; }
	/**********************************************************************************************************/	
	/* invoiceCreate ******************************************************************************************/
		private $invoiceIssuedCreate = '0';
		public function setInvoiceIssuedCreate($invoiceIssuedCreate) { $this->invoiceIssuedCreate = $invoiceIssuedCreate; return $this; }
		public function getInvoiceIssuedCreate() { return $this->invoiceIssuedCreate; }
	/**********************************************************************************************************/
	/* invoiceEdit ********************************************************************************************/
		private $invoiceIssuedEdit = '0';
		public function setInvoiceIssuedEdit($invoiceIssuedEdit) { $this->invoiceIssuedEdit = $invoiceIssuedEdit; return $this; }
		public function getInvoiceIssuedEdit() { return $this->invoiceIssuedEdit; }
	/**********************************************************************************************************/
	/* invoiceRemove ******************************************************************************************/
		private $invoiceIssuedRemove = '0';
		public function setInvoiceIssuedRemove($invoiceIssuedRemove) { $this->invoiceIssuedRemove = $invoiceIssuedRemove; return $this; }
		public function getInvoiceIssuedRemove() { return $this->invoiceIssuedRemove; }
	/**********************************************************************************************************/	
/**************************************************************************************************************/
/* SERVICE ****************************************************************************************************/
	/* serviceList ********************************************************************************************/
		private $serviceList = '0';
		public function setServiceList($serviceList) { $this->serviceList = $serviceList; return $this; } 
		public function getServiceList() { return $this->serviceList; }
	/**********************************************************************************************************/
	/* serviceView ********************************************************************************************/
		private $serviceView = '0';
		public function setServiceView($serviceView) { $this->serviceView = $serviceView; return $this; } 
		public function getServiceView() { return $this->serviceView; }	
	/* serviceCreate ******************************************************************************************/
		private $serviceCreate = '0';
		public function setServiceCreate($serviceCreate) { $this->serviceCreate = $serviceCreate; return $this; }
		public function getServiceCreate() { return $this->serviceCreate; }
	/**********************************************************************************************************/
	/* serviceEdit ********************************************************************************************/
		private $serviceEdit = '0';
		public function setServiceEdit($serviceEdit) { $this->serviceEdit = $serviceEdit; return $this; }
		public function getServiceEdit() { return $this->serviceEdit; }
	/**********************************************************************************************************/
	/* serviceRemove ******************************************************************************************/
		private $serviceRemove = '0';
		public function setServiceRemove($serviceRemove) { $this->serviceRemove = $serviceRemove; return $this; }
		public function getServiceRemove() { return $this->serviceRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* SCHEDULE ***************************************************************************************************/
	/* serviceList ********************************************************************************************/
		private $scheduleList = '0';
		public function setScheduleList($scheduleList) { $this->scheduleList = $scheduleList; return $this; } 
		public function getScheduleList() { return $this->scheduleList; }
	/**********************************************************************************************************/
	/* serviceView ********************************************************************************************/
		private $scheduleView = '0';
		public function setScheduleView($scheduleView) { $this->scheduleView = $scheduleView; return $this; } 
		public function getScheduleView() { return $this->scheduleView; }	
	/* serviceCreate ******************************************************************************************/
		private $scheduleCreate = '0';
		public function setScheduleCreate($scheduleCreate) { $this->scheduleCreate = $scheduleCreate; return $this; }
		public function getScheduleCreate() { return $this->scheduleCreate; }
	/**********************************************************************************************************/
	/* serviceEdit ********************************************************************************************/
		private $scheduleEdit = '0';
		public function setScheduleEdit($scheduleEdit) { $this->scheduleEdit = $scheduleEdit; return $this; }
		public function getScheduleEdit() { return $this->scheduleEdit; }
	/**********************************************************************************************************/
	/* serviceRemove ******************************************************************************************/
		private $scheduleRemove = '0';
		public function setScheduleRemove($scheduleRemove) { $this->scheduleRemove = $scheduleRemove; return $this; }
		public function getScheduleRemove() { return $this->scheduleRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* TRACING ****************************************************************************************************/
	/* tracingList ********************************************************************************************/
		private $tracingList = '0';
		public function setTracingList($tracingList) { $this->tracingList = $tracingList; return $this; }
		public function getTracingList() { return $this->tracingList; }
	/**********************************************************************************************************/
	/* tracingView ********************************************************************************************/
		private $tracingView = '0';
		public function setTracingView($tracingView) { $this->tracingView = $tracingView; return $this; }
		public function getTracingView() { return $this->tracingView; }
	/**********************************************************************************************************/
	/* tracingCreate ******************************************************************************************/
		private $tracingCreate = '0';
		public function setTracingCreate($tracingCreate) { $this->tracingCreate = $tracingCreate; return $this; }
		public function getTracingCreate() { return $this->tracingCreate; }
	/**********************************************************************************************************/
	/* tracingEdit ********************************************************************************************/
		private $tracingEdit = '0';
		public function setTracingEdit($tracingEdit) { $this->tracingEdit = $tracingEdit; return $this; }
		public function getTracingEdit() { return $this->tracingEdit; }
	/**********************************************************************************************************/
	/* tracingRemove ******************************************************************************************/
		private $tracingRemove = '0';
		public function setTracingRemove($tracingRemove) { $this->tracingRemove = $tracingRemove; return $this; }
		public function getTracingRemove() { return $this->tracingRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* TRACING SERVICE ********************************************************************************************/
	/* tracingServiceList ***********************************************************************************/
		private $tracingServiceList = '0';
		public function setTracingServiceList($tracingServiceList) { $this->tracingServiceList = $tracingServiceList; return $this; }
		public function getTracingServiceList() { return $this->tracingServiceList; }
	/**********************************************************************************************************/
	/* tracingServiceView *************************************************************************************/
		private $tracingServiceView = '0';
		public function setTracingServiceView($tracingServiceView) { $this->tracingServiceView = $tracingServiceView; return $this; }
		public function getTracingServiceView() { return $this->tracingServiceView; }
	/**********************************************************************************************************/
	/* tracingServiceCreate ***********************************************************************************/
		private $tracingServiceCreate = '0';
		public function setTracingServiceCreate($tracingServiceCreate) { $this->tracingServiceCreate = $tracingServiceCreate; return $this; }
		public function getTracingServiceCreate() { return $this->tracingServiceCreate; }
	/**********************************************************************************************************/
	/* tracingServiceEdit *************************************************************************************/
		private $tracingServiceEdit = '0';
		public function setTracingServiceEdit($tracingServiceEdit) { $this->tracingServiceEdit = $tracingServiceEdit; return $this; }
		public function getTracingServiceEdit() { return $this->tracingServiceEdit; }
	/**********************************************************************************************************/
	/* tracingServiceRemove ***********************************************************************************/
		private $tracingServiceRemove = '0';
		public function setTracingServiceRemove($tracingServiceRemove) { $this->tracingServiceRemove = $tracingServiceRemove; return $this; }
		public function getTracingServiceRemove() { return $this->tracingServiceRemove; }
	/**********************************************************************************************************/
	/* tracingServiceChangeCountableStatus ***********************************************************************************/
		private $tracingServiceChangeCountableStatus = '0';
		public function setTracingServiceChangeCountableStatus($tracingServiceChangeCountableStatus) { $this->tracingServiceChangeCountableStatus = $tracingServiceChangeCountableStatus; return $this; }
		public function getTracingServiceChangeCountableStatus() { return $this->tracingServiceChangeCountableStatus; }
	/**********************************************************************************************************/
	/* tracingServiceChangeConsolidatedStatus ***********************************************************************************/
		private $tracingServiceChangeConsolidatedStatus = '0';
		public function setTracingServiceChangeConsolidatedStatus($tracingServiceChangeConsolidatedStatus) { $this->tracingServiceChangeConsolidatedStatus = $tracingServiceChangeConsolidatedStatus; return $this; }
		public function getTracingServiceChangeConsolidatedStatus() { return $this->tracingServiceChangeConsolidatedStatus; }
	/**********************************************************************************************************/		
/**************************************************************************************************************/
/* ADMIN ******************************************************************************************************/
	/* adminSectionAccess**************************************************************************************/
		private $adminSectionAccess = '0';
		public function setAdminSectionAccess($adminSectionAccess) { $this->adminSectionAccess = $adminSectionAccess; return $this; }
		public function getAdminSectionAccess() { return $this->adminSectionAccess; }
	/**********************************************************************************************************/
	/* adminGeneralDataAccess *********************************************************************************/
		private $adminGeneralDataAccess = '0';
		public function setAdminGeneralDataAccess($adminGeneralDataAccess) { $this->adminGeneralDataAccess = $adminGeneralDataAccess; return $this; }
		public function getAdminGeneralDataAccess() { return $this->adminGeneralDataAccess; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
}
