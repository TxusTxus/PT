<?php

namespace AlbaranesBundle\Repository;

use Doctrine\Common\Collections\Criteria;

/**
 * AlbaranRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlbaranRepository extends \Doctrine\ORM\EntityRepository
{
    
    /* 
    * Obtiene el listado de los albaranes
    * según un criterio de búsqueda
    */
    public function buscaAlbaranSegunTexto($cadena){
            // Listado completo de clientes

        
            $consulta = $this->getQueryBuilder();
            $consulta ->leftJoin('a.concepto', 'con')
                      ->leftJoin('a.cliente', 'cli');
                    $criterio = Criteria::create()
                    ->andwhere(Criteria::expr()->ORX(
                            Criteria::expr()->contains('cli.nombre',$cadena),
                            Criteria::expr()->contains('con.concepto',$cadena)
                            )); 
                    $consulta->addCriteria($criterio);
            $consulta->getQuery();

            return $consulta->getQuery()->getResult();
    }    
    
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();

        $qb = $em->getRepository('AlbaranesBundle:Albaran')
            ->createQueryBuilder('a');

        return $qb;
    }
}