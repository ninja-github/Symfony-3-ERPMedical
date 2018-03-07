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
	use Doctrine\ORM\EntityRepository;
/* Añadimos los componentes que permitirán el uso de EntityField **********************************************/
	/*
	 * EntityType permite mostrar en el formulario un listado de opciones procedente
	 * de otro formulario
	 */
/* Añadimos los componentes que permitirán el uso de nuevas clases ********************************************/
	use Symfony\Component\Form\Extension\Core\Type\DateType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**************************************************************************************************************/
class DocumentsType extends AbstractType {
/* CONSTRUCTOR DEL FORMULARIO *********************************************************************************/
	public function buildForm(FormBuilderInterface $builder, array $options) {
		// Usamos la propiedad 'allow_extra_fields' pasar las variables
		$userPermission = $options['allow_extra_fields'];
		$clinicNameUrl = $options['attr']['clinicNameUrl'];
		$builder
			->add('title', TextType::class, array(
				'required'=>true,
				'attr'=>array('class'=>'form-control', "style" => "margin-bottom:10px", 'placeholder'=>'Título del Documento')
			))
			->add('doc', FileType::class, array(
				'label'=>'Foto',
				'required'=>true,
				'data_class'=>null, // campo independiente
				'multiple'=>true,
				'attr'=>array('class'=>'form-image form-control', "style" => "margin-bottom:10px")
			))
			->add('description', TextareaType::class, array(
				'required'=>false,
				'attr'=>array('class'=>'form-control', 'style' => 'margin-bottom:13px')))
			->add('add',SubmitType::class, array(
				'attr'=>array('class'=>'form-submit btn btn-success')));			
	   }
/**************************************************************************************************************/
/* DEFINIMOS LA ENTIDAD DONDE SE INCLUIRAN LOS DATOS EN LA BD *************************************************/
    public function configureOptions(OptionsResolver $resolver)    {
        $resolver->setDefaults(array('data_class' => 'BackendBundle\Entity\Documents'));
    }
/**************************************************************************************************************/
}			