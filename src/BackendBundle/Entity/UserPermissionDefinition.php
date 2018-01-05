<?php

namespace BackendBundle\Entity;

/**
 * UserPermissionDefinition
 */
class UserPermissionDefinition
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $userCreate;

    /**
     * @var string
     */
    private $userEdit;

    /**
     * @var string
     */
    private $userRemove;

    /**
     * @var string
     */
    private $userDumpView;

    /**
     * @var string
     */
    private $userPermission;

    /**
     * @var string
     */
    private $clinicViewOther;

    /**
     * @var string
     */
    private $clinicCreate;

    /**
     * @var string
     */
    private $clinicEdit;

    /**
     * @var string
     */
    private $clinicRemove;

    /**
     * @var string
     */
    private $medicalHistoryCreate;

    /**
     * @var string
     */
    private $medicalHistoryEdit;

    /**
     * @var string
     */
    private $medicalHistoryRemove;

    /**
     * @var string
     */
    private $medicalHistoryRegistrationDateEdit;

    /**
     * @var string
     */
    private $medicalHistoryModificationDateEdit;

    /**
     * @var string
     */
    private $medicalHistoryUserRegistererEdit;

    /**
     * @var string
     */
    private $medicalHistoryUserModifierEdit;

    /**
     * @var string
     */
    private $medicalHistoryDocCreate;

    /**
     * @var string
     */
    private $medicalHistoryDocEdit;

    /**
     * @var string
     */
    private $medicalHistoryDocRemove;

    /**
     * @var string
     */
    private $medicalHistoryDocRegistrationDateEdit;

    /**
     * @var string
     */
    private $medicalHistoryDocModificationDateEdit;

    /**
     * @var string
     */
    private $medicalHistoryDocUserRegistererEdit;

    /**
     * @var string
     */
    private $medicalHistoryDocUserModifierEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryCreate;

    /**
     * @var string
     */
    private $orthopodologyHistoryEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryRemove;

    /**
     * @var string
     */
    private $orthopodologyHistoryRegistrationDateEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryModificationDateEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryUserRegistererEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryUserModifierEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocCreate;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocRemove;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocRegistrationDateEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocModificationDateEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocUserRegistererEdit;

    /**
     * @var string
     */
    private $orthopodologyHistoryDocUserModifierEdit;

    /**
     * @var string
     */
    private $serviceCreate;

    /**
     * @var string
     */
    private $serviceEdit;

    /**
     * @var string
     */
    private $serviceRemove;

    /**
     * @var string
     */
    private $tracingCreate;

    /**
     * @var string
     */
    private $tracingEdit;

    /**
     * @var string
     */
    private $tracingRemove;

    /**
     * @var string
     */
    private $adminSectionAccess;

    /**
     * @var string
     */
    private $adminGeneralDataAccess;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userCreate
     *
     * @param string $userCreate
     *
     * @return UserPermissionDefinition
     */
    public function setUserCreate($userCreate)
    {
        $this->userCreate = $userCreate;

        return $this;
    }

    /**
     * Get userCreate
     *
     * @return string
     */
    public function getUserCreate()
    {
        return $this->userCreate;
    }

    /**
     * Set userEdit
     *
     * @param string $userEdit
     *
     * @return UserPermissionDefinition
     */
    public function setUserEdit($userEdit)
    {
        $this->userEdit = $userEdit;

        return $this;
    }

    /**
     * Get userEdit
     *
     * @return string
     */
    public function getUserEdit()
    {
        return $this->userEdit;
    }

    /**
     * Set userRemove
     *
     * @param string $userRemove
     *
     * @return UserPermissionDefinition
     */
    public function setUserRemove($userRemove)
    {
        $this->userRemove = $userRemove;

        return $this;
    }

    /**
     * Get userRemove
     *
     * @return string
     */
    public function getUserRemove()
    {
        return $this->userRemove;
    }

    /**
     * Set userDumpView
     *
     * @param string $userDumpView
     *
     * @return UserPermissionDefinition
     */
    public function setUserDumpView($userDumpView)
    {
        $this->userDumpView = $userDumpView;

        return $this;
    }

    /**
     * Get userDumpView
     *
     * @return string
     */
    public function getUserDumpView()
    {
        return $this->userDumpView;
    }

    /**
     * Set userPermission
     *
     * @param string $userPermission
     *
     * @return UserPermissionDefinition
     */
    public function setUserPermission($userPermission)
    {
        $this->userPermission = $userPermission;

        return $this;
    }

    /**
     * Get userPermission
     *
     * @return string
     */
    public function getUserPermission()
    {
        return $this->userPermission;
    }

    /**
     * Set clinicViewOther
     *
     * @param string $clinicViewOther
     *
     * @return UserPermissionDefinition
     */
    public function setClinicViewOther($clinicViewOther)
    {
        $this->clinicViewOther = $clinicViewOther;

        return $this;
    }

    /**
     * Get clinicViewOther
     *
     * @return string
     */
    public function getClinicViewOther()
    {
        return $this->clinicViewOther;
    }

    /**
     * Set clinicCreate
     *
     * @param string $clinicCreate
     *
     * @return UserPermissionDefinition
     */
    public function setClinicCreate($clinicCreate)
    {
        $this->clinicCreate = $clinicCreate;

        return $this;
    }

    /**
     * Get clinicCreate
     *
     * @return string
     */
    public function getClinicCreate()
    {
        return $this->clinicCreate;
    }

    /**
     * Set clinicEdit
     *
     * @param string $clinicEdit
     *
     * @return UserPermissionDefinition
     */
    public function setClinicEdit($clinicEdit)
    {
        $this->clinicEdit = $clinicEdit;

        return $this;
    }

    /**
     * Get clinicEdit
     *
     * @return string
     */
    public function getClinicEdit()
    {
        return $this->clinicEdit;
    }

    /**
     * Set clinicRemove
     *
     * @param string $clinicRemove
     *
     * @return UserPermissionDefinition
     */
    public function setClinicRemove($clinicRemove)
    {
        $this->clinicRemove = $clinicRemove;

        return $this;
    }

    /**
     * Get clinicRemove
     *
     * @return string
     */
    public function getClinicRemove()
    {
        return $this->clinicRemove;
    }

    /**
     * Set medicalHistoryCreate
     *
     * @param string $medicalHistoryCreate
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryCreate($medicalHistoryCreate)
    {
        $this->medicalHistoryCreate = $medicalHistoryCreate;

        return $this;
    }

    /**
     * Get medicalHistoryCreate
     *
     * @return string
     */
    public function getMedicalHistoryCreate()
    {
        return $this->medicalHistoryCreate;
    }

    /**
     * Set medicalHistoryEdit
     *
     * @param string $medicalHistoryEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryEdit($medicalHistoryEdit)
    {
        $this->medicalHistoryEdit = $medicalHistoryEdit;

        return $this;
    }

    /**
     * Get medicalHistoryEdit
     *
     * @return string
     */
    public function getMedicalHistoryEdit()
    {
        return $this->medicalHistoryEdit;
    }

    /**
     * Set medicalHistoryRemove
     *
     * @param string $medicalHistoryRemove
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryRemove($medicalHistoryRemove)
    {
        $this->medicalHistoryRemove = $medicalHistoryRemove;

        return $this;
    }

    /**
     * Get medicalHistoryRemove
     *
     * @return string
     */
    public function getMedicalHistoryRemove()
    {
        return $this->medicalHistoryRemove;
    }

    /**
     * Set medicalHistoryRegistrationDateEdit
     *
     * @param string $medicalHistoryRegistrationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryRegistrationDateEdit($medicalHistoryRegistrationDateEdit)
    {
        $this->medicalHistoryRegistrationDateEdit = $medicalHistoryRegistrationDateEdit;

        return $this;
    }

    /**
     * Get medicalHistoryRegistrationDateEdit
     *
     * @return string
     */
    public function getMedicalHistoryRegistrationDateEdit()
    {
        return $this->medicalHistoryRegistrationDateEdit;
    }

    /**
     * Set medicalHistoryModificationDateEdit
     *
     * @param string $medicalHistoryModificationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryModificationDateEdit($medicalHistoryModificationDateEdit)
    {
        $this->medicalHistoryModificationDateEdit = $medicalHistoryModificationDateEdit;

        return $this;
    }

    /**
     * Get medicalHistoryModificationDateEdit
     *
     * @return string
     */
    public function getMedicalHistoryModificationDateEdit()
    {
        return $this->medicalHistoryModificationDateEdit;
    }

    /**
     * Set medicalHistoryIdUserRegistererEdit
     *
     * @param string $medicalHistoryIdUserRegistererEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryUserRegistererEdit($medicalHistoryUserRegistererEdit)
    {
        $this->medicalHistoryUserRegistererEdit = $medicalHistoryUserRegistererEdit;

        return $this;
    }

    /**
     * Get medicalHistoryIdUserRegistererEdit
     *
     * @return string
     */
    public function getMedicalHistoryUserRegistererEdit()
    {
        return $this->medicalHistoryUserRegistererEdit;
    }

    /**
     * Set medicalHistoryIdUserModifierEdit
     *
     * @param string $medicalHistoryIdUserModifierEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryUserModifierEdit($medicalHistoryUserModifierEdit)
    {
        $this->medicalHistoryUserModifierEdit = $medicalHistoryUserModifierEdit;

        return $this;
    }

    /**
     * Get medicalHistoryIdUserModifierEdit
     *
     * @return string
     */
    public function getMedicalHistoryUserModifierEdit()
    {
        return $this->medicalHistoryUserModifierEdit;
    }

    /**
     * Set medicalHistoryDocCreate
     *
     * @param string $medicalHistoryDocCreate
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocCreate($medicalHistoryDocCreate)
    {
        $this->medicalHistoryDocCreate = $medicalHistoryDocCreate;

        return $this;
    }

    /**
     * Get medicalHistoryDocCreate
     *
     * @return string
     */
    public function getMedicalHistoryDocCreate()
    {
        return $this->medicalHistoryDocCreate;
    }

    /**
     * Set medicalHistoryDocEdit
     *
     * @param string $medicalHistoryDocEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocEdit($medicalHistoryDocEdit)
    {
        $this->medicalHistoryDocEdit = $medicalHistoryDocEdit;

        return $this;
    }

    /**
     * Get medicalHistoryDocEdit
     *
     * @return string
     */
    public function getMedicalHistoryDocEdit()
    {
        return $this->medicalHistoryDocEdit;
    }

    /**
     * Set medicalHistoryDocRemove
     *
     * @param string $medicalHistoryDocRemove
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocRemove($medicalHistoryDocRemove)
    {
        $this->medicalHistoryDocRemove = $medicalHistoryDocRemove;

        return $this;
    }

    /**
     * Get medicalHistoryDocRemove
     *
     * @return string
     */
    public function getMedicalHistoryDocRemove()
    {
        return $this->medicalHistoryDocRemove;
    }

    /**
     * Set medicalHistoryDocRegistrationDateEdit
     *
     * @param string $medicalHistoryDocRegistrationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocRegistrationDateEdit($medicalHistoryDocRegistrationDateEdit)
    {
        $this->medicalHistoryDocRegistrationDateEdit = $medicalHistoryDocRegistrationDateEdit;

        return $this;
    }

    /**
     * Get medicalHistoryDocRegistrationDateEdit
     *
     * @return string
     */
    public function getMedicalHistoryDocRegistrationDateEdit()
    {
        return $this->medicalHistoryDocRegistrationDateEdit;
    }

    /**
     * Set medicalHistoryDocModificationDateEdit
     *
     * @param string $medicalHistoryDocModificationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocModificationDateEdit($medicalHistoryDocModificationDateEdit)
    {
        $this->medicalHistoryDocModificationDateEdit = $medicalHistoryDocModificationDateEdit;

        return $this;
    }

    /**
     * Get medicalHistoryDocModificationDateEdit
     *
     * @return string
     */
    public function getMedicalHistoryDocModificationDateEdit()
    {
        return $this->medicalHistoryDocModificationDateEdit;
    }

    /**
     * Set medicalHistoryDocIdUserRegistererEdit
     *
     * @param string $medicalHistoryDocIdUserRegistererEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocUserRegistererEdit($medicalHistoryDocUserRegistererEdit)
    {
        $this->medicalHistoryDocUserRegistererEdit = $medicalHistoryDocUserRegistererEdit;

        return $this;
    }

    /**
     * Get medicalHistoryDocIdUserRegistererEdit
     *
     * @return string
     */
    public function getMedicalHistoryDocUserRegistererEdit()
    {
        return $this->medicalHistoryDocUserRegistererEdit;
    }

    /**
     * Set medicalHistoryDocIdUserModifierEdit
     *
     * @param string $medicalHistoryDocIdUserModifierEdit
     *
     * @return UserPermissionDefinition
     */
    public function setMedicalHistoryDocUserModifierEdit($medicalHistoryDocUserModifierEdit)
    {
        $this->medicalHistoryDocUserModifierEdit = $medicalHistoryDocUserModifierEdit;

        return $this;
    }

    /**
     * Get medicalHistoryDocIdUserModifierEdit
     *
     * @return string
     */
    public function getMedicalHistoryDocUserModifierEdit()
    {
        return $this->medicalHistoryDocUserModifierEdit;
    }

    /**
     * Set orthopodologyHistoryCreate
     *
     * @param string $orthopodologyHistoryCreate
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryCreate($orthopodologyHistoryCreate)
    {
        $this->orthopodologyHistoryCreate = $orthopodologyHistoryCreate;

        return $this;
    }

    /**
     * Get orthopodologyHistoryCreate
     *
     * @return string
     */
    public function getOrthopodologyHistoryCreate()
    {
        return $this->orthopodologyHistoryCreate;
    }

    /**
     * Set orthopodologyHistoryEdit
     *
     * @param string $orthopodologyHistoryEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryEdit($orthopodologyHistoryEdit)
    {
        $this->orthopodologyHistoryEdit = $orthopodologyHistoryEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryEdit()
    {
        return $this->orthopodologyHistoryEdit;
    }

    /**
     * Set orthopodologyHistoryRemove
     *
     * @param string $orthopodologyHistoryRemove
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryRemove($orthopodologyHistoryRemove)
    {
        $this->orthopodologyHistoryRemove = $orthopodologyHistoryRemove;

        return $this;
    }

    /**
     * Get orthopodologyHistoryRemove
     *
     * @return string
     */
    public function getOrthopodologyHistoryRemove()
    {
        return $this->orthopodologyHistoryRemove;
    }

    /**
     * Set orthopodologyHistoryRegistrationDateEdit
     *
     * @param string $orthopodologyHistoryRegistrationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryRegistrationDateEdit($orthopodologyHistoryRegistrationDateEdit)
    {
        $this->orthopodologyHistoryRegistrationDateEdit = $orthopodologyHistoryRegistrationDateEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryRegistrationDateEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryRegistrationDateEdit()
    {
        return $this->orthopodologyHistoryRegistrationDateEdit;
    }

    /**
     * Set orthopodologyHistoryModificationDateEdit
     *
     * @param string $orthopodologyHistoryModificationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryModificationDateEdit($orthopodologyHistoryModificationDateEdit)
    {
        $this->orthopodologyHistoryModificationDateEdit = $orthopodologyHistoryModificationDateEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryModificationDateEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryModificationDateEdit()
    {
        return $this->orthopodologyHistoryModificationDateEdit;
    }

    /**
     * Set orthopodologyHistoryIdUserRegistererEdit
     *
     * @param string $orthopodologyHistoryIdUserRegistererEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryUserRegistererEdit($orthopodologyHistoryUserRegistererEdit)
    {
        $this->orthopodologyHistoryUserRegistererEdit = $orthopodologyHistoryUserRegistererEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryIdUserRegistererEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryUserRegistererEdit()
    {
        return $this->orthopodologyHistoryUserRegistererEdit;
    }

    /**
     * Set orthopodologyHistoryIdUserModifierEdit
     *
     * @param string $orthopodologyHistoryIdUserModifierEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryUserModifierEdit($orthopodologyHistoryUserModifierEdit)
    {
        $this->orthopodologyHistoryUserModifierEdit = $orthopodologyHistoryUserModifierEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryIdUserModifierEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryUserModifierEdit()
    {
        return $this->orthopodologyHistoryUserModifierEdit;
    }

    /**
     * Set orthopodologyHistoryDocCreate
     *
     * @param string $orthopodologyHistoryDocCreate
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocCreate($orthopodologyHistoryDocCreate)
    {
        $this->orthopodologyHistoryDocCreate = $orthopodologyHistoryDocCreate;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocCreate
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocCreate()
    {
        return $this->orthopodologyHistoryDocCreate;
    }

    /**
     * Set orthopodologyHistoryDocEdit
     *
     * @param string $orthopodologyHistoryDocEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocEdit($orthopodologyHistoryDocEdit)
    {
        $this->orthopodologyHistoryDocEdit = $orthopodologyHistoryDocEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocEdit()
    {
        return $this->orthopodologyHistoryDocEdit;
    }

    /**
     * Set orthopodologyHistoryDocRemove
     *
     * @param string $orthopodologyHistoryDocRemove
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocRemove($orthopodologyHistoryDocRemove)
    {
        $this->orthopodologyHistoryDocRemove = $orthopodologyHistoryDocRemove;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocRemove
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocRemove()
    {
        return $this->orthopodologyHistoryDocRemove;
    }

    /**
     * Set orthopodologyHistoryDocRegistrationDateEdit
     *
     * @param string $orthopodologyHistoryDocRegistrationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocRegistrationDateEdit($orthopodologyHistoryDocRegistrationDateEdit)
    {
        $this->orthopodologyHistoryDocRegistrationDateEdit = $orthopodologyHistoryDocRegistrationDateEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocRegistrationDateEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocRegistrationDateEdit()
    {
        return $this->orthopodologyHistoryDocRegistrationDateEdit;
    }

    /**
     * Set orthopodologyHistoryDocModificationDateEdit
     *
     * @param string $orthopodologyHistoryDocModificationDateEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocModificationDateEdit($orthopodologyHistoryDocModificationDateEdit)
    {
        $this->orthopodologyHistoryDocModificationDateEdit = $orthopodologyHistoryDocModificationDateEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocModificationDateEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocModificationDateEdit()
    {
        return $this->orthopodologyHistoryDocModificationDateEdit;
    }

    /**
     * Set orthopodologyHistoryDocIdUserRegistererEdit
     *
     * @param string $orthopodologyHistoryDocIdUserRegistererEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocUserRegistererEdit($orthopodologyHistoryDocUserRegistererEdit)
    {
        $this->orthopodologyHistoryDocUserRegistererEdit = $orthopodologyHistoryDocUserRegistererEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocIdUserRegistererEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocUserRegistererEdit()
    {
        return $this->orthopodologyHistoryDocUserRegistererEdit;
    }

    /**
     * Set orthopodologyHistoryDocIdUserModifierEdit
     *
     * @param string $orthopodologyHistoryDocIdUserModifierEdit
     *
     * @return UserPermissionDefinition
     */
    public function setOrthopodologyHistoryDocUserModifierEdit($orthopodologyHistoryDocUserModifierEdit)
    {
        $this->orthopodologyHistoryDocUserModifierEdit = $orthopodologyHistoryDocUserModifierEdit;

        return $this;
    }

    /**
     * Get orthopodologyHistoryDocIdUserModifierEdit
     *
     * @return string
     */
    public function getOrthopodologyHistoryDocUserModifierEdit()
    {
        return $this->orthopodologyHistoryDocUserModifierEdit;
    }

    /**
     * Set serviceCreate
     *
     * @param string $serviceCreate
     *
     * @return UserPermissionDefinition
     */
    public function setServiceCreate($serviceCreate)
    {
        $this->serviceCreate = $serviceCreate;

        return $this;
    }

    /**
     * Get serviceCreate
     *
     * @return string
     */
    public function getServiceCreate()
    {
        return $this->serviceCreate;
    }

    /**
     * Set serviceEdit
     *
     * @param string $serviceEdit
     *
     * @return UserPermissionDefinition
     */
    public function setServiceEdit($serviceEdit)
    {
        $this->serviceEdit = $serviceEdit;

        return $this;
    }

    /**
     * Get serviceEdit
     *
     * @return string
     */
    public function getServiceEdit()
    {
        return $this->serviceEdit;
    }

    /**
     * Set serviceRemove
     *
     * @param string $serviceRemove
     *
     * @return UserPermissionDefinition
     */
    public function setServiceRemove($serviceRemove)
    {
        $this->serviceRemove = $serviceRemove;

        return $this;
    }

    /**
     * Get serviceRemove
     *
     * @return string
     */
    public function getServiceRemove()
    {
        return $this->serviceRemove;
    }

    /**
     * Set tracingCreate
     *
     * @param string $tracingCreate
     *
     * @return UserPermissionDefinition
     */
    public function setTracingCreate($tracingCreate)
    {
        $this->tracingCreate = $tracingCreate;

        return $this;
    }

    /**
     * Get tracingCreate
     *
     * @return string
     */
    public function getTracingCreate()
    {
        return $this->tracingCreate;
    }

    /**
     * Set tracingEdit
     *
     * @param string $tracingEdit
     *
     * @return UserPermissionDefinition
     */
    public function setTracingEdit($tracingEdit)
    {
        $this->tracingEdit = $tracingEdit;

        return $this;
    }

    /**
     * Get tracingEdit
     *
     * @return string
     */
    public function getTracingEdit()
    {
        return $this->tracingEdit;
    }

    /**
     * Set tracingRemove
     *
     * @param string $tracingRemove
     *
     * @return UserPermissionDefinition
     */
    public function setTracingRemove($tracingRemove)
    {
        $this->tracingRemove = $tracingRemove;

        return $this;
    }

    /**
     * Get tracingRemove
     *
     * @return string
     */
    public function getTracingRemove()
    {
        return $this->tracingRemove;
    }

    /**
     * Set adminSectionAccess
     *
     * @param string $adminSectionAccess
     *
     * @return UserPermissionDefinition
     */
    public function setAdminSectionAccess($adminSectionAccess)
    {
        $this->adminSectionAccess = $adminSectionAccess;

        return $this;
    }

    /**
     * Get adminSectionAccess
     *
     * @return string
     */
    public function getAdminSectionAccess()
    {
        return $this->adminSectionAccess;
    }

    /**
     * Set adminGeneralDataAccess
     *
     * @param string $adminGeneralDataAccess
     *
     * @return UserPermissionDefinition
     */
    public function setAdminGeneralDataAccess($adminGeneralDataAccess)
    {
        $this->adminGeneralDataAccess = $adminGeneralDataAccess;

        return $this;
    }

    /**
     * Get adminGeneralDataAccess
     *
     * @return string
     */
    public function getAdminGeneralDataAccess()
    {
        return $this->adminGeneralDataAccess;
    }
/* TRACING SERVICE ****************************************************************************************************/
    /* tracingServiceCreate ******************************************************************************************/
        private $tracingServiceCreate;
        public function setTracingServiceCreate($tracingServiceCreate) { $this->tracingServiceCreate = $tracingServiceCreate; return $this; }
        public function getTracingServiceCreate() { return $this->tracingServiceCreate; }
    /**********************************************************************************************************/
    /* tracingServiceEdit ********************************************************************************************/
        private $tracingServiceEdit;
        public function setTracingServiceEdit($tracingServiceEdit) { $this->tracingServiceEdit = $tracingServiceEdit; return $this; }
        public function getTracingServiceEdit() { return $this->tracingServiceEdit; }
    /**********************************************************************************************************/
    /* tracingServiceRemove ******************************************************************************************/
        private $tracingServiceRemove;
        public function setTracingServiceRemove($tracingServiceRemove) { $this->tracingServiceRemove = $tracingServiceRemove; return $this; }
        public function getTracingServiceRemove() { return $this->tracingServiceRemove; }
    /**********************************************************************************************************/
/**************************************************************************************************************/
}

