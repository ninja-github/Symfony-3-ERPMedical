<?php
/* Indicamos el namespace del Bundle                     ******************************************************/
	namespace AppBundle\Form;
/**************************************************************************************************************/
	use Symfony\Component\Form\AbstractType;                // Clase necesario para AbstractType
	use Symfony\Component\Form\FormBuilderInterface;        // Clase necesario para AbstractType
	use Symfony\Component\OptionsResolver\OptionsResolver;  // Clase necesario para AbstractType
/* Añadimos las ENTIDADES que usaremos ************************************************************************/
	/*
	 * EntityType permite mostrar en el formulario un listado de opciones procedente
	 * de otro formulario
	 */
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;     // Campo Tipo EntityType
/**************************************************************************************************************/
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
	use Symfony\Component\Form\Extension\Core\Type\DateType;
	use Symfony\Component\Form\Extension\Core\Type\NumberType;
	use Symfony\Component\Form\Extension\Core\Type\SearchType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**************************************************************************************************************/
class OrthopodologyHistoryType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		// Usamos la propiedad 'allow_extra_fields' y 'attr' pasar las variables
		$permissionLoggedUser = $options['allow_extra_fields'];
		$medicalHistoryNumber = $options['attr']['medicalHistoryNumber'];
		$clinicNameUrl = $options['attr']['clinicNameUrl'];
		$userLoggedId = $options['attr']['userLoggedId'];
		if($medicalHistoryNumber == 'without_MedicalHistoryNumber' ){
			$builder
				->add('medicalHistory', EntityType::class,array(
					'class' => 'BackendBundle:MedicalHistory',
					'choice_label' => 'MedicalHistoryList',
					'query_builder' => function($er) use ($clinicNameUrl){
						return $er->createQueryBuilder('mH')
						->innerJoin('mH.clinic','c', 'c.id = mH.clinic')
						->where('c.nameUrl =:clinicNameUrl')
						->setParameter('clinicNameUrl', $clinicNameUrl);
					},
					'label' => 'userName',
					'expanded'     => false,       // Muestra todas las opciones (radio buttons O checkboxes)
					'multiple'     => false,      // Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
					'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
			));
		}
		$builder
			->add('reasonConsultation', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px;margin-top:3px;')))
			->add('background', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('articularExplorationRotaryPatternExternalLeft', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationRotaryPatternExternalRight', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationRotaryPatternInternalLeft', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationRotaryPatternInternalRight', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationHipLeft', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationHipRight', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationKneeLeft', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationKneeRight', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
        	->add('articularExplorationAnkleLeft', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
        	->add('articularExplorationAnkleRight', NumberType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationRetroPieLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100px; border: 0px;')))
			->add('articularExplorationRetroPieRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100px; border: 0px;')))
			->add('articularExplorationBeforeFootLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100px; border: 0px;')))
			->add('articularExplorationBeforeFootRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 100px; border: 0px;')))
			->add('articularExplorationFirstRadioLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationFirstRadioRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationFifthRadioLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationFifthRadioRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationCentralRadiosLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationCentralRadiosRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationFirstFingerLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationFirstFingerRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationSmallerFingersLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('articularExplorationSmallerFingersRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsFemoralLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsFemoralRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsGenusLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsGenusRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsAngleQLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsAngleQRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsTibialLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsTibialRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsHelbingLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('torsionsHelbingRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('dissimmetry', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('muscularExplorationDorsalFlexionLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationDorsalFlexionRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationPlantarFlexionLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationPlantarFlexionRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationEversionLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationEversionRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationReversalLeft', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('muscularExplorationReversalRight', TextType::class, array(
				'required'=>false,
				'attr'=>array('style' => 'margin-right:6px;width: 30px; border: 0px;')))
			->add('dinamicExploration', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('signsFootprint', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('suplementaryTest', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('diagnostic', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('treatment', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')));
		if($permissionLoggedUser->getMedicalHistoryUserRegistererEdit() == true){
			$builder
				->add('userRegisterer', EntityType::class,array(
					'class' => 'BackendBundle:User',
					'choice_label' => 'user',
					'query_builder' => function($er) use( $clinicNameUrl, $userLoggedId ) {
						return $er->getUserListOfClinic($clinicNameUrl, $userLoggedId);
                	},
					'label' => 'userName',
					'expanded' => false,		// Muestra todas las opciones (radio buttons O checkboxes)
					'multiple' => false,		// Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
					'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
				));
			}
		if($permissionLoggedUser->getMedicalHistoryRegistrationDateEdit() == true){
			$builder
				->add('registrationDate', DateType::class, array(
					'required'=>false,
					'widget' => 'single_text',
					'format'=>'dd/MM/yyyy',
					'html5' => false,
					'attr'=>array('class' => 'form-control')
				));
			}
		if($permissionLoggedUser->getMedicalHistoryUserModifierEdit() == true){
			$builder
				->add('userModifier', EntityType::class,array(
					'class' => 'BackendBundle:User',
					'choice_label' => 'user',
					'query_builder' => function($er) use( $clinicNameUrl, $userLoggedId ) {
						return $er->getUserListOfClinic($clinicNameUrl, $userLoggedId);
                	},
					'label' => 'userName',
					'expanded'     => false,       // Muestra todas las opciones (radio buttons O checkboxes)
					'multiple'     => false,      // Multiple seleccion ( select tag	 O select tag (with multiple attribute)	)
					'attr' =>array('class' => 'form-control', 'data-toggle-class' => 'btn-primary', 'style' => 'margin-bottom:13px')
				));
			}
		if($permissionLoggedUser->getMedicalHistoryModificationDateEdit() == true){
			$builder
				->add('modificationDate', DateType::class, array(
					'required'=>false,
					'widget' => 'single_text',
					'format'=>'dd/MM/yyyy',
					'html5' => false,
					'attr'=>array('class' => 'form-control')
				));
			}
		$builder
			->add('submit',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success', 'style' => 'margin-bottom:13px, display:block')));
    }
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array( 'data_class' => 'BackendBundle\Entity\OrthopodologyHistory' ));
    }
/**************************************************************************************************************/
    public function getBlockPrefix() { return 'backendbundle_orthopodologyhistory'; }
}
