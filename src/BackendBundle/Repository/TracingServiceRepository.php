<?php
namespace BackendBundle\Repository;
/* Un EntityRepository sirve como un repositorio para entidades con métodos genéricos y específicos del negocio para recuperar entidades. Esta clase está diseñada para herencia y los usuarios pueden clasificar esta clase para escribir sus propios repositorios con métodos específicos de negocios para ubicar entidades. */
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;
/* REPOSITORY- Es necesario definir el repositorio dentro del ORM, en este caso en src/BackendBundle/Resources/config/doctrine/Service.orm.yml con la siguiente línea:
BackendBundle\Entity\Service:
    type: entity
    repositoryClass: BackendBundle\Repository\InvoiceServiceRepository
*/
class TracingServiceRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE LA DATOS CONTABLES PACIENTE ***********************************************************/
	// gastado y pagado
/*	public function getCostEarnings ( $clinicNameUrl, $medicalHistoryNumber ){
		$em=$this->getEntityManager();
		$tracingService = $this->createQueryBuilder('ts')
			->innerJoin('ts.tracing', 't', 't.id = ts.tracing')
			->innerJoin('t.medicalHistory', 'mh', 'mh.id = t.medicalHistory')
			->innerJoin('mh.clinic', 'cl', 'cl.id = mh.clinic')
			->where('mh.medicalHistoryNumber =:medicalHistoryNumber AND cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->setParameter('medicalHistoryNumber', $medicalHistoryNumber)
			->getQuery()
			->getResult();
			$earnings = 0;
			$cost = 0;
			foreach( $tracingService as $service => $value){

				if($value->getService() != null){
					$typeService = $value->getService()->getTypeService();
					if($typeService){
						// si es igual a true es un ingreso
						$price = $value->getPrice();
						$earnings = $earnings + $price;
						//var_dump($price);echo '<br>';
						//var_dump($earnings);echo '<br>';echo '<br>';
					}else{
						// si es igual a true es un coste
						$price = $value->getPrice();
						$discount = $value->getDiscount();
						$cost = $cost + ($price * (( 100 - $discount ) / 100 ));
						//var_dump($price);echo '<br>';
						//var_dump($cost);echo '<br>';echo '<br>';
					}
				}else{
					$price = $value->getPrice();
					$discount = $value->getDiscount();
					$cost = $cost + ($price * (( 100 - $discount ) / 100 ));
					//var_dump($price);echo '<br>';
					//var_dump($cost);echo '<br>';echo '<br>';					
				}
				
			}
			$getCostEarnings = ['cost'=>$cost, 'earnings'=>$earnings];
		return $getCostEarnings;
	}
*/
/*************************************************************************************************/


}