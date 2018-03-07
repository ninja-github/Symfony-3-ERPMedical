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
/* Añadimos los componentes que permitirán el uso de EntityField **********************************************/
	/*
	 * EntityType permite mostrar en el formulario un listado de opciones procedente
	 * de otro formulario
	 */
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
class ClinicType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		/*
		 * Usamos la propiedad 'empty_data' para pasar la variable
		 * ( viene de 'src\AppBundle\Controller\MedicalHistoryController.php',
		 * 'src\AppBundle\form\MedicalHistoryType.php',
		 * 'src\BackendBundle\Repository\MedicalHistoryRepository.php' y
		 * 'src\BackendBundle\Resources\config\doctrine\MedicalHistory.orm.yml')
		 */
		// $user = $options['empty_data'];
		$builder
			// 'name' será el nombre de la columna de la base de datos
			->add('name', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('phone', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('address', TextType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			/**************************************************************************************************/
		 	->add('city', TextType::class, array(
		 		'required'=>false,
		 		'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:0px', 'id'=>'search-box')))
			/**************************************************************************************************/		
			->add('Nueva Clínica',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success', 'style' => 'margin-bottom:13px, display:block')));
    }
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver)    {
        $resolver->setDefaults(array('data_class' => 'BackendBundle\Entity\Clinic'));
    }
/**************************************************************************************************************/
}
