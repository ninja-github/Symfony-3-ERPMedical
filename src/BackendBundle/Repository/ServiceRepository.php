<?php
namespace BackendBundle\Repository;
/* Un EntityRepository sirve como un repositorio para entidades con métodos genéricos y específicos del negocio para recuperar entidades. Esta clase está diseñada para herencia y los usuarios pueden clasificar esta clase para escribir sus propios repositorios con métodos específicos de negocios para ubicar entidades. */
use Doctrine\ORM\EntityRepository;
/* REPOSITORY- Es necesario definir el repositorio dentro del ORM, en este caso en src/BackendBundle/Resources/config/doctrine/Service.orm.yml con la siguiente línea:
BackendBundle\Entity\Service:
    type: entity
    repositoryClass: BackendBundle\Repository\ServiceRepository
*/
class ServiceRepository extends \Doctrine\ORM\EntityRepository {
/* OBTIENE EL ARRAY CON SERVICIOS SEGÚN CLÍNICA **************************************************/
	public function getServiceListQuery($clinicNameUrl){
		$em=$this->getEntityManager();
		$serviceList = $this->createQueryBuilder('s')
			->select( 's.id', 's.service', 'IDENTITY(s.parent) AS parent', 's.description', 's.minimalPrice', 's.maximumPrice', 's.state', 'IDENTITY(s.updatedService) AS updatedService', 's.registrationDate', 's.modificationDate')
			->innerJoin('s.clinic', 'cl', 'cl.id = s.clinic')
			->where('cl.nameUrl=:clinicNameUrl')
			->setParameter('clinicNameUrl', $clinicNameUrl)
			->orderBy('s.id','ASC')
			->getQuery()
			->getResult();
		$serviceListBasic = array();
		foreach($serviceList as $service => $data){
			if($data['parent'] == NULL){
				$serviceListBasic[$data['id']]=$data;
			}else{
				$serviceListFristLevel[$service] = $data;
			}
		}
		foreach($serviceListFristLevel as $serviceFristLevel => $dataFristLevel){
			if( array_key_exists($dataFristLevel['parent'], $serviceListBasic)){
				$serviceListBasic[ $dataFristLevel['parent'] ]['children'][$dataFristLevel['id']]=$dataFristLevel;
			}else{
				$serviceListSecondLevel[$serviceFristLevel] = $dataFristLevel;
			}
		}

		foreach($serviceListSecondLevel as $serviceSecondLevel => $dataSecondLevel){
			// Listado que falta adjundicar
			foreach($serviceListBasic as $serviceBasic => $dataBasic){
				// Recorremos Listado nivel 1
				$keys = array_keys($dataBasic);
				$parent = $dataSecondLevel['parent'];
				if( in_array('children', $keys)){
					// Dentro tiene hijos?
					foreach($dataBasic['children'] as $grandChildren=>$dataGrandChildren){
						// Recorremos Listado nivel 2
						if($dataSecondLevel['parent'] == $grandChildren){
							$serviceListBasic[$serviceBasic]['children'][$dataSecondLevel['parent']]['children'][$dataSecondLevel['id']]=$dataSecondLevel;
						}
					}
				}
			}
		}
		return $serviceListBasic;
	}
/*************************************************************************************************/
}