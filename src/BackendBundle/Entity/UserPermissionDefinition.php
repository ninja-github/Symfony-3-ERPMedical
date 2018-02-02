<?php
/* Namespace **************************************************************************************************/
    namespace BackendBundle\Entity;
/* Añadimos el VALIDADOR **************************************************************************************
 * Definimos el sistema de validación de los datos en las entidades dentro de "app\config\config.yml"
 * y la gestionamos en "src\AppBundle\Resources\config\validation.yml",
 * cada entidad deberá llamar a "use Symfony\Component\Validator\Constraints as Assert;"
 * VER src\BackendBundle\Entity\User.php
 */
    use Symfony\Component\Validator\Constraints as Assert;
    use Doctrine\Common\Collections\ArrayCollection;
/**************************************************************************************************************/
class UserPermissionDefinition { 
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* USER *******************************************************************************************************/
	/* userList ***********************************************************************************************/
		private $userList;
		public function setUserList($userList) { $this->userList = $userList; return $this; } 
		public function getUserList() { return $this->userList; }
	/**********************************************************************************************************/
	/* userView ***********************************************************************************************/		
		private $userView;
		public function setUserView($userView) { $this->userView = $userView; return $this; } 
		public function getUserView() { return $this->userView; }
	/**********************************************************************************************************/
	/* userCreate *********************************************************************************************/	
		private $userCreate;
		public function setUserCreate($userCreate) { $this->userCreate = $userCreate; return $this; } 
		public function getUserCreate() { return $this->userCreate; }
	/**********************************************************************************************************/
	/* userEdit ***********************************************************************************************/
		private $userEdit;
		public function setUserEdit($userEdit) { $this->userEdit = $userEdit; return $this; } 
		public function getUserEdit() { return $this->userEdit; }
	/**********************************************************************************************************/
	/* userRemove *********************************************************************************************/	
		private $userRemove;
		public function setUserRemove($userRemove) { $this->userRemove = $userRemove; return $this; } 
		public function getUserRemove() { return $this->userRemove; } 
	/**********************************************************************************************************/
	/* userDumpView *******************************************************************************************/			
		private $userDumpView;
		public function setUserDumpView($userDumpView) { $this->userDumpView = $userDumpView; return $this; } 
		public function getUserDumpView() { return $this->userDumpView; } 
	/**********************************************************************************************************/
	/* userPermission *****************************************************************************************/	
		private $userPermission;
		public function setUserPermission($userPermission) { $this->userPermission = $userPermission; return $this; } 
		public function getUserPermission() { return $this->userPermission; } 
	/**********************************************************************************************************/
	/* clinicViewOther ****************************************************************************************/		
		private $clinicViewOther;
		public function setClinicViewOther($clinicViewOther) { $this->clinicViewOther = $clinicViewOther; return $this; } 
		public function getClinicViewOther() { return $this->clinicViewOther; }
	/**********************************************************************************************************/
/**************************************************************************************************************/		
/* CLINIC *****************************************************************************************************/
	/* clinicList *******************************************************************************************/		
		private $clinicList;
		public function setClinicList($clinicList) { $this->clinicList = $clinicList; return $this; } 
		public function getClinicList() { return $this->clinicList; } 
	/**********************************************************************************************************/
	/* clinicCreate *******************************************************************************************/		
		private $clinicView;
		public function setClinicView($clinicView) { $this->clinicView = $clinicView; return $this; } 
		public function getClinicView() { return $this->clinicView; } 
	/**********************************************************************************************************/
	/* clinicCreate *******************************************************************************************/		
		private $clinicCreate;
		public function setClinicCreate($clinicCreate) { $this->clinicCreate = $clinicCreate; return $this; } 
		public function getClinicCreate() { return $this->clinicCreate; } 
	/**********************************************************************************************************/
	/* clinicEdit *********************************************************************************************/	
		private $clinicEdit;
		public function setClinicEdit($clinicEdit) { $this->clinicEdit = $clinicEdit; return $this; } 
		public function getClinicEdit() { return $this->clinicEdit; } 
	/**********************************************************************************************************/
	/* clinicRemove *******************************************************************************************/	
		private $clinicRemove;
		public function setClinicRemove($clinicRemove) { $this->clinicRemove = $clinicRemove; return $this; } 
		public function getClinicRemove() { return $this->clinicRemove; } 	
	/**********************************************************************************************************/
/**************************************************************************************************************/		
/* MEDICAL HISTORY ********************************************************************************************/
	/* medicalHistoryList ***********************************************************************************/		
		private $medicalHistoryList;
		public function setMedicalHistoryList($medicalHistoryList) { $this->medicalHistoryList = $medicalHistoryList; return $this; } 
		public function getMedicalHistoryList() { return $this->medicalHistoryList; } 	
	/**********************************************************************************************************/		
	/* medicalHistoryView *************************************************************************************/
		private $medicalHistoryView;
		public function setMedicalHistoryView($medicalHistoryView) { $this->medicalHistoryView = $medicalHistoryView; return $this; } 
		public function getMedicalHistoryView() { return $this->medicalHistoryView; } 	
	/**********************************************************************************************************/
	/* medicalHistoryCreate ***********************************************************************************/		
		private $medicalHistoryCreate;
		public function setMedicalHistoryCreate($medicalHistoryCreate) { $this->medicalHistoryCreate = $medicalHistoryCreate; return $this; } 
		public function getMedicalHistoryCreate() { return $this->medicalHistoryCreate; } 	
	/**********************************************************************************************************/		
	/* medicalHistoryEdit *************************************************************************************/
		private $medicalHistoryEdit;
		public function setMedicalHistoryEdit($medicalHistoryEdit) { $this->medicalHistoryEdit = $medicalHistoryEdit; return $this; } 
		public function getMedicalHistoryEdit() { return $this->medicalHistoryEdit; } 	
	/**********************************************************************************************************/
	/* medicalHistoryRemove ***********************************************************************************/			
		private $medicalHistoryRemove;
		public function setMedicalHistoryRemove($medicalHistoryRemove) { $this->medicalHistoryRemove = $medicalHistoryRemove; return $this; } 
		public function getMedicalHistoryRemove() { return $this->medicalHistoryRemove; }
	/**********************************************************************************************************/
	/* medicalHistoryRegistrationDateEdit *********************************************************************/		
		private $medicalHistoryRegistrationDateEdit;
		public function setMedicalHistoryRegistrationDateEdit($medicalHistoryRegistrationDateEdit) { $this->medicalHistoryRegistrationDateEdit = $medicalHistoryRegistrationDateEdit; return $this; } 
		public function getMedicalHistoryRegistrationDateEdit() { return $this->medicalHistoryRegistrationDateEdit; } 	
	/**********************************************************************************************************/
	/* medicalHistoryModificationDateEdit *********************************************************************/		
		private $medicalHistoryModificationDateEdit;
		public function setMedicalHistoryModificationDateEdit($medicalHistoryModificationDateEdit) { $this->medicalHistoryModificationDateEdit = $medicalHistoryModificationDateEdit; return $this; } 
		public function getMedicalHistoryModificationDateEdit() { return $this->medicalHistoryModificationDateEdit; } 
	/**********************************************************************************************************/
	/* medicalHistoryUserRegistererEdit ***********************************************************************/
		private $medicalHistoryUserRegistererEdit;
		public function setMedicalHistoryUserRegistererEdit($medicalHistoryUserRegistererEdit) { $this->medicalHistoryUserRegistererEdit = $medicalHistoryUserRegistererEdit; return $this; } 
		public function getMedicalHistoryUserRegistererEdit() { return $this->medicalHistoryUserRegistererEdit; }	
	/**********************************************************************************************************/
	/* medicalHistoryUserModifierEdit *************************************************************************/		
		private $medicalHistoryUserModifierEdit;
		public function setMedicalHistoryUserModifierEdit($medicalHistoryUserModifierEdit) { $this->medicalHistoryUserModifierEdit = $medicalHistoryUserModifierEdit; return $this; } 
		public function getMedicalHistoryUserModifierEdit() { return $this->medicalHistoryUserModifierEdit; }  	
/**************************************************************************************************************/		
/* MEDICAL HISTORY DOC*****************************************************************************************/
	/* medicalHistoryDocList **********************************************************************************/
		private $medicalHistoryDocList;
		public function setMedicalHistoryDocList($medicalHistoryDocList) { $this->medicalHistoryDocList = $medicalHistoryDocList; return $this; } 
		public function getMedicalHistoryDocList() { return $this->medicalHistoryDocList; }	
	/**********************************************************************************************************/
	/* medicalHistoryDocList **********************************************************************************/	
		private $medicalHistoryDocView;
		public function setMedicalHistoryDocView($medicalHistoryDocView) { $this->medicalHistoryDocView = $medicalHistoryDocView; return $this; } 
		public function getMedicalHistoryDocView() { return $this->medicalHistoryDocView; }	
	/**********************************************************************************************************/
	/* medicalHistoryDocCreate ********************************************************************************/		
		private $medicalHistoryDocCreate;
		public function setMedicalHistoryDocCreate($medicalHistoryDocCreate) { $this->medicalHistoryDocCreate = $medicalHistoryDocCreate; return $this; } 
		public function getMedicalHistoryDocCreate() { return $this->medicalHistoryDocCreate; } 
	/**********************************************************************************************************/
	/* medicalHistoryDocEdit **********************************************************************************/			
		private $medicalHistoryDocEdit;
		public function setMedicalHistoryDocEdit($medicalHistoryDocEdit) { $this->medicalHistoryDocEdit = $medicalHistoryDocEdit; return $this; } 
		public function getMedicalHistoryDocEdit() { return $this->medicalHistoryDocEdit; }	
	/**********************************************************************************************************/
	/* medicalHistoryDocRemove ********************************************************************************/		
		private $medicalHistoryDocRemove;
		public function setMedicalHistoryDocRemove($medicalHistoryDocRemove) { $this->medicalHistoryDocRemove = $medicalHistoryDocRemove; return $this; } 
		public function getMedicalHistoryDocRemove() { return $this->medicalHistoryDocRemove; } 
	/**********************************************************************************************************/
	/* medicalHistoryDocRegistrationDateEdit ******************************************************************/			
		private $medicalHistoryDocRegistrationDateEdit;
		public function setMedicalHistoryDocRegistrationDateEdit($medicalHistoryDocRegistrationDateEdit) { $this->medicalHistoryDocRegistrationDateEdit = $medicalHistoryDocRegistrationDateEdit; return $this; } 
		public function getMedicalHistoryDocRegistrationDateEdit() { return $this->medicalHistoryDocRegistrationDateEdit; } 	
	/**********************************************************************************************************/
	/* medicalHistoryDocModificationDateEdit ******************************************************************/		
		private $medicalHistoryDocModificationDateEdit;
		public function setMedicalHistoryDocModificationDateEdit($medicalHistoryDocModificationDateEdit) { $this->medicalHistoryDocModificationDateEdit = $medicalHistoryDocModificationDateEdit; return $this; } 
		public function getMedicalHistoryDocModificationDateEdit() { return $this->medicalHistoryDocModificationDateEdit; } 
	/**********************************************************************************************************/
	/* medicalHistoryDocUserRegistererEdit ********************************************************************/			
		private $medicalHistoryDocUserRegistererEdit;
		public function setMedicalHistoryDocUserRegistererEdit($medicalHistoryDocUserRegistererEdit) { $this->medicalHistoryDocUserRegistererEdit = $medicalHistoryDocUserRegistererEdit; return $this; } 
		public function getMedicalHistoryDocUserRegistererEdit() { return $this->medicalHistoryDocUserRegistererEdit; } 	
	/**********************************************************************************************************/
	/* medicalHistoryDocUserModifierEdit **********************************************************************/		
		private $medicalHistoryDocUserModifierEdit;
		public function setMedicalHistoryDocUserModifierEdit($medicalHistoryDocUserModifierEdit) { $this->medicalHistoryDocUserModifierEdit = $medicalHistoryDocUserModifierEdit; return $this; } 
		public function getMedicalHistoryDocUserModifierEdit() { return $this->medicalHistoryDocUserModifierEdit; }	
/**************************************************************************************************************/
/* ORTHOPODOLOGYHISTORY ***************************************************************************************/
	/* orthopodologyHistoryList *******************************************************************************/
		private $orthopodologyHistoryList;
		public function setOrthopodologyHistoryList($orthopodologyHistoryList) { $this->orthopodologyHistoryList = $orthopodologyHistoryList; return $this; }
		public function getOrthopodologyHistoryList() { return $this->orthopodologyHistoryList; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryView *******************************************************************************/
		private $orthopodologyHistoryView;
		public function setOrthopodologyHistoryView($orthopodologyHistoryView) { $this->orthopodologyHistoryView = $orthopodologyHistoryView; return $this; }
		public function getOrthopodologyHistoryView() { return $this->orthopodologyHistoryView; }
	/**********************************************************************************************************/    
	/* orthopodologyHistoryCreate *****************************************************************************/
		private $orthopodologyHistoryCreate ;
		public function setOrthopodologyHistoryCreate($orthopodologyHistoryCreate) { $this->orthopodologyHistoryCreate = $orthopodologyHistoryCreate; return $this; }
		public function getOrthopodologyHistoryCreate() { return $this->orthopodologyHistoryCreate; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryEdit *******************************************************************************/
		private $orthopodologyHistoryEdit;
		public function setOrthopodologyHistoryEdit($orthopodologyHistoryEdit) { $this->orthopodologyHistoryEdit = $orthopodologyHistoryEdit; return $this; }
		public function getOrthopodologyHistoryEdit() { return $this->orthopodologyHistoryEdit; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryRemove *****************************************************************************/
		private $orthopodologyHistoryRemove;
		public function setOrthopodologyHistoryRemove($orthopodologyHistoryRemove) { $this->orthopodologyHistoryRemove = $orthopodologyHistoryRemove; return $this; }
		public function getOrthopodologyHistoryRemove() { return $this->orthopodologyHistoryRemove; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryRegistrationDateEdit ***************************************************************/
		private $orthopodologyHistoryRegistrationDateEdit;
		public function setOrthopodologyHistoryRegistrationDateEdit($orthopodologyHistoryRegistrationDateEdit) { $this->orthopodologyHistoryRegistrationDateEdit = $orthopodologyHistoryRegistrationDateEdit; return $this; }
		public function getOrthopodologyHistoryRegistrationDateEdit() { return $this->orthopodologyHistoryRegistrationDateEdit; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryUserRegistererEdit *****************************************************************/
		private $orthopodologyHistoryUserRegistererEdit;
		public function setOrthopodologyHistoryUserRegistererEdit($orthopodologyHistoryUserRegistererEdit) { $this->orthopodologyHistoryUserRegistererEdit = $orthopodologyHistoryUserRegistererEdit; return $this; }
		public function getOrthopodologyHistoryUserRegistererEdit() { return $this->orthopodologyHistoryUserRegistererEdit; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryModificationDateEdit ***************************************************************/
		private $orthopodologyHistoryModificationDateEdit;
		public function setOrthopodologyHistoryModificationDateEdit($orthopodologyHistoryModificationDateEdit) { $this->orthopodologyHistoryModificationDateEdit = $orthopodologyHistoryModificationDateEdit; return $this; }
		public function getOrthopodologyHistoryModificationDateEdit() { return $this->orthopodologyHistoryModificationDateEdit; }
	/**********************************************************************************************************/
	/* orthopodologyHistoryUserModifierEdit *******************************************************************/
		private $orthopodologyHistoryUserModifierEdit;
		public function setOrthopodologyHistoryUserModifierEdit($orthopodologyHistoryUserModifierEdit) { $this->orthopodologyHistoryUserModifierEdit = $orthopodologyHistoryUserModifierEdit; return $this; }
		public function getOrthopodologyHistoryUserModifierEdit() { return $this->orthopodologyHistoryUserModifierEdit; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* ORTHOPODOLOGYHISTORY DOC ***********************************************************************************/
	/* orthopodologyHistoryDocList ****************************************************************************/
		private $orthopodologyHistoryDocList; 
		public function setOrthopodologyHistoryDocList($orthopodologyHistoryDocList) { $this->orthopodologyHistoryDocList = $orthopodologyHistoryDocList; return $this; } 
		public function getOrthopodologyHistoryDocList() { return $this->orthopodologyHistoryDocList; } 
	/**********************************************************************************************************/  
	/* orthopodologyHistoryDocView ****************************************************************************/	  	
		private $orthopodologyHistoryDocView; 
		public function setOrthopodologyHistoryDocView($orthopodologyHistoryDocView) { $this->orthopodologyHistoryDocView = $orthopodologyHistoryDocView; return $this; } 
		public function getOrthopodologyHistoryDocView() { return $this->orthopodologyHistoryDocView; } 	
	/**********************************************************************************************************/  
	/* orthopodologyHistoryDocCreate **************************************************************************/		
		private $orthopodologyHistoryDocCreate; 
		public function setOrthopodologyHistoryDocCreate($orthopodologyHistoryDocCreate) { $this->orthopodologyHistoryDocCreate = $orthopodologyHistoryDocCreate; return $this; } 
		public function getOrthopodologyHistoryDocCreate() { return $this->orthopodologyHistoryDocCreate; } 	
		private $orthopodologyHistoryDocEdit; 
		public function setOrthopodologyHistoryDocEdit($orthopodologyHistoryDocEdit) { $this->orthopodologyHistoryDocEdit = $orthopodologyHistoryDocEdit; return $this; } 
		public function getOrthopodologyHistoryDocEdit() { return $this->orthopodologyHistoryDocEdit; } 	
		private $orthopodologyHistoryDocRemove; 
		public function setOrthopodologyHistoryDocRemove($orthopodologyHistoryDocRemove) { $this->orthopodologyHistoryDocRemove = $orthopodologyHistoryDocRemove; return $this; } 
		public function getOrthopodologyHistoryDocRemove() { return $this->orthopodologyHistoryDocRemove; } 	
		private $orthopodologyHistoryDocRegistrationDateEdit; 
		public function setOrthopodologyHistoryDocRegistrationDateEdit($orthopodologyHistoryDocRegistrationDateEdit) { $this->orthopodologyHistoryDocRegistrationDateEdit = $orthopodologyHistoryDocRegistrationDateEdit; return $this; } 
		public function getOrthopodologyHistoryDocRegistrationDateEdit() { return $this->orthopodologyHistoryDocRegistrationDateEdit; } 	
		private $orthopodologyHistoryDocModificationDateEdit; 
		public function setOrthopodologyHistoryDocModificationDateEdit($orthopodologyHistoryDocModificationDateEdit) { $this->orthopodologyHistoryDocModificationDateEdit = $orthopodologyHistoryDocModificationDateEdit; return $this; } 
		public function getOrthopodologyHistoryDocModificationDateEdit() { return $this->orthopodologyHistoryDocModificationDateEdit; } 	
		private $orthopodologyHistoryDocUserRegistererEdit; 
		public function setOrthopodologyHistoryDocUserRegistererEdit($orthopodologyHistoryDocUserRegistererEdit) { $this->orthopodologyHistoryDocUserRegistererEdit = $orthopodologyHistoryDocUserRegistererEdit; return $this; } 
		public function getOrthopodologyHistoryDocUserRegistererEdit() { return $this->orthopodologyHistoryDocUserRegistererEdit; } 	
		private $orthopodologyHistoryDocUserModifierEdit;
		public function setOrthopodologyHistoryDocUserModifierEdit($orthopodologyHistoryDocUserModifierEdit) { $this->orthopodologyHistoryDocUserModifierEdit = $orthopodologyHistoryDocUserModifierEdit; return $this; } 
		public function getOrthopodologyHistoryDocUserModifierEdit() { return $this->orthopodologyHistoryDocUserModifierEdit; } 	
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* REPORT *****************************************************************************************************/
	/* reportList ********************************************************************************************/
		private $reportList;
		public function setReportList($reportList) { $this->reportList = $reportList; return $this; }
		public function getReportList() { return $this->reportList; }
	/**********************************************************************************************************/
	/* reportView ********************************************************************************************/
		private $reportView;
		public function setReportView($reportView) { $this->reportView = $reportView; return $this; }
		public function getReportView() { return $this->reportView; }
	/**********************************************************************************************************/    
	/* reportCreate ******************************************************************************************/
		private $reportCreate;
		public function setReportCreate($reportCreate) { $this->reportCreate = $reportCreate; return $this; }
		public function getReportCreate() { return $this->reportCreate; }
	/**********************************************************************************************************/
	/* reportEdit ********************************************************************************************/
		private $reportEdit;
		public function setReportEdit($reportEdit) { $this->reportEdit = $reportEdit; return $this; }
		public function getReportEdit() { return $this->reportEdit; }
	/**********************************************************************************************************/
	/* reportRemove ******************************************************************************************/
		private $reportRemove;
		public function setReportRemove($reportRemove) { $this->reportRemove = $reportRemove; return $this; }
		public function getReportRemove() { return $this->reportRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* INVOICE ****************************************************************************************************/
	/* invoiceList ******************************************************************************************/
		private $invoiceList;
		public function setInvoiceList($invoiceList) { $this->invoiceList = $invoiceList; return $this; }
		public function getInvoiceList() { return $this->invoiceList; }
	/**********************************************************************************************************/
	/* invoiceView ******************************************************************************************/
		private $invoiceView;
		public function setInvoiceView($invoiceView) { $this->invoiceView = $invoiceView; return $this; }
		public function getInvoiceView() { return $this->invoiceView; }
	/**********************************************************************************************************/	
	/* invoiceCreate ******************************************************************************************/
		private $invoiceCreate;
		public function setInvoiceCreate($invoiceCreate) { $this->invoiceCreate = $invoiceCreate; return $this; }
		public function getInvoiceCreate() { return $this->invoiceCreate; }
	/**********************************************************************************************************/
	/* invoiceEdit ********************************************************************************************/
		private $invoiceEdit;
		public function setInvoiceEdit($invoiceEdit) { $this->invoiceEdit = $invoiceEdit; return $this; }
		public function getInvoiceEdit() { return $this->invoiceEdit; }
	/**********************************************************************************************************/
	/* invoiceRemove ******************************************************************************************/
		private $invoiceRemove;
		public function setInvoiceRemove($invoiceRemove) { $this->invoiceRemove = $invoiceRemove; return $this; }
		public function getInvoiceRemove() { return $this->invoiceRemove; }
	/**********************************************************************************************************/	
/**************************************************************************************************************/
/* SERVICE ****************************************************************************************************/
		private $serviceList;
		public function setServiceList($serviceList) { $this->serviceList = $serviceList; return $this; } 
		public function getServiceList() { return $this->serviceList; }
		private $serviceView;
		public function setServiceView($serviceView) { $this->serviceView = $serviceView; return $this; } 
		public function getServiceView() { return $this->serviceView; }		
		private $serviceCreate;
		public function setServiceCreate($serviceCreate) { $this->serviceCreate = $serviceCreate; return $this; } 
		public function getServiceCreate() { return $this->serviceCreate; } 		
		private $serviceEdit;
		public function setServiceEdit($serviceEdit) { $this->serviceEdit = $serviceEdit; return $this; } 
		public function getServiceEdit() { return $this->serviceEdit; } 			
		private $serviceRemove;
		public function setServiceRemove($serviceRemove) { $this->serviceRemove = $serviceRemove; return $this; } 
		public function getServiceRemove() { return $this->serviceRemove; } 
/**************************************************************************************************************/
/* SCHEDULE ***************************************************************************************************/
	/* serviceList ********************************************************************************************/
		private $scheduleList;
		public function setScheduleList($scheduleList) { $this->scheduleList = $scheduleList; return $this; } 
		public function getScheduleList() { return $this->scheduleList; }
	/**********************************************************************************************************/
	/* serviceView ********************************************************************************************/
		private $scheduleView;
		public function setScheduleView($scheduleView) { $this->scheduleView = $scheduleView; return $this; } 
		public function getScheduleView() { return $this->scheduleView; }	
	/* serviceCreate ******************************************************************************************/
		private $scheduleCreate;
		public function setScheduleCreate($scheduleCreate) { $this->scheduleCreate = $scheduleCreate; return $this; }
		public function getScheduleCreate() { return $this->scheduleCreate; }
	/**********************************************************************************************************/
	/* serviceEdit ********************************************************************************************/
		private $scheduleEdit;
		public function setScheduleEdit($scheduleEdit) { $this->scheduleEdit = $scheduleEdit; return $this; }
		public function getScheduleEdit() { return $this->scheduleEdit; }
	/**********************************************************************************************************/
	/* serviceRemove ******************************************************************************************/
		private $scheduleRemove;
		public function setScheduleRemove($scheduleRemove) { $this->scheduleRemove = $scheduleRemove; return $this; }
		public function getScheduleRemove() { return $this->scheduleRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* TRACING ****************************************************************************************************/
	/* tracingList ********************************************************************************************/
		private $tracingList;
		public function setTracingList($tracingList) { $this->tracingList = $tracingList; return $this; }
		public function getTracingList() { return $this->tracingList; }
	/**********************************************************************************************************/
	/* tracingView ********************************************************************************************/
		private $tracingView;
		public function setTracingView($tracingView) { $this->tracingView = $tracingView; return $this; }
		public function getTracingView() { return $this->tracingView; }
	/**********************************************************************************************************/
		private $tracingCreate;
		public function setTracingCreate($tracingCreate) { $this->tracingCreate = $tracingCreate; return $this; } 
		public function getTracingCreate() { return $this->tracingCreate; } 		
		private $tracingEdit;
		public function setTracingEdit($tracingEdit) { $this->tracingEdit = $tracingEdit; return $this; } 
		public function getTracingEdit() { return $this->tracingEdit; } 		
		private $tracingRemove;
		public function setTracingRemove($tracingRemove) { $this->tracingRemove = $tracingRemove; return $this; } 
		public function getTracingRemove() { return $this->tracingRemove; } 		
/**************************************************************************************************************/
/* TRACING SERVICE ********************************************************************************************/
	/* tracingServiceList ***********************************************************************************/
		private $tracingServiceList;
		public function setTracingServiceList($tracingServiceList) { $this->tracingServiceList = $tracingServiceList; return $this; }
		public function getTracingServiceList() { return $this->tracingServiceList; }
	/**********************************************************************************************************/
	/* tracingServiceView *************************************************************************************/
		private $tracingServiceView;
		public function setTracingServiceView($tracingServiceView) { $this->tracingServiceView = $tracingServiceView; return $this; }
		public function getTracingServiceView() { return $this->tracingServiceView; }
	/**********************************************************************************************************/
	/* tracingServiceCreate ***********************************************************************************/
		private $tracingServiceCreate;
		public function setTracingServiceCreate($tracingServiceCreate) { $this->tracingServiceCreate = $tracingServiceCreate; return $this; }
		public function getTracingServiceCreate() { return $this->tracingServiceCreate; }
	/**********************************************************************************************************/
	/* tracingServiceEdit *************************************************************************************/
		private $tracingServiceEdit;
		public function setTracingServiceEdit($tracingServiceEdit) { $this->tracingServiceEdit = $tracingServiceEdit; return $this; }
		public function getTracingServiceEdit() { return $this->tracingServiceEdit; }
	/**********************************************************************************************************/
	/* tracingServiceRemove ***********************************************************************************/
		private $tracingServiceRemove;
		public function setTracingServiceRemove($tracingServiceRemove) { $this->tracingServiceRemove = $tracingServiceRemove; return $this; }
		public function getTracingServiceRemove() { return $this->tracingServiceRemove; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
/* ADMIN ******************************************************************************************************/
	/* adminSectionAccess**************************************************************************************/
		private $adminSectionAccess;
		public function setAdminSectionAccess($adminSectionAccess) { $this->adminSectionAccess = $adminSectionAccess; return $this; }
		public function getAdminSectionAccess() { return $this->adminSectionAccess; }
	/**********************************************************************************************************/
	/* adminGeneralDataAccess *********************************************************************************/
		private $adminGeneralDataAccess;
		public function setAdminGeneralDataAccess($adminGeneralDataAccess) { $this->adminGeneralDataAccess = $adminGeneralDataAccess; return $this; }
		public function getAdminGeneralDataAccess() { return $this->adminGeneralDataAccess; }
	/**********************************************************************************************************/
/**************************************************************************************************************/
}
