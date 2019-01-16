<?php

namespace PartesBundle\Repository;

/**
 * PartesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartesRepository extends \Doctrine\ORM\EntityRepository
{
    
    /* 
    * Obtiene el listado de los partes de una empresa en una fecha dada
    */
    public function damePartesEmpresa($empresa,$fecha){
            // Listado completo de trabajadores

            $consulta = $this->getQueryBuilder();

            $consulta->leftJoin('p.direccion', 'd')
                    ->Where("p.empresa =:empresa") 
                    ->setParameter('empresa', $empresa);
            $consulta->andWhere("p.fechaParte =:fecha")
                    ->setParameter('fecha', $fecha);
            $consulta->orderby('p.trabajador', 'ASC')
                    ->addOrderBy('p.fechaEntrada', 'ASC')
            ->getQuery();

            return $consulta->getQuery()->getResult();
    }
    
//    public function damePartesEntreFechas($inicio, $fin){
//        $consulta = $this->getQueryBuilder();
//        $consulta->Where("p.empresa =:empresa") 
//                ->setParameter('empresa', $empresa)
//                ->andWhere('p.fecha BETWEEN :inicio AND :fin') 
//                ->setParameter('inicio', $inicio) 
//                ->setParameter('fin', $fin);
//           
//        $consulta->orderby('p.fechaParte', 'ASC')
//            ->getQuery(); 
//
//    return $consulta;   
//    }

    
    /* 
     * Obtiene el listado de los partes de una empresa 
     * de un cliente determinado y entre las fechas dadas
     */    
    public function damePartesClienteEntreFechas($inicio, $fin, $cliente){
        $consulta = $this->getQueryBuilder();
        $consulta->Where("p.empresa =:empresa") 
                ->setParameter('empresa', $empresa)
                ->andWhere("p.cliente =:cliente") 
                ->setParameter('cliente', $cliente)
                ->andWhere('p.fecha BETWEEN :inicio AND :fin') 
                ->setParameter('inicio', $inicio) 
                ->setParameter('fin', $fin);
           
        $consulta->orderby('p.fechaParte', 'ASC')
            ->getQuery(); 

    return $consulta;   
    }

    /* 
     * Obtiene el listado de los partes de una empresa 
     * de un trabajador determinado y entre las fechas dadas
     */ 
    public function damePartesTrabajadorEntreFechas($inicio, $fin, $trabajador){
        $consulta = $this->getQueryBuilder();
        $consulta->Where("p.empresa =:empresa") 
                ->setParameter('empresa', $empresa)
                ->andWhere("p.trabajador =:trabajador") 
                ->setParameter('trabajador', $trabajador)
                ->andWhere('p.fecha BETWEEN :inicio AND :fin') 
                ->setParameter('inicio', $inicio) 
                ->setParameter('fin', $fin);
           
        $consulta->orderby('p.fechaParte', 'ASC')
            ->getQuery(); 

    return $consulta;   
    }


    public function dameFechasPartes($empresa, $fecha){
        $inicio = $this->dameFechaInicial($fecha);
        $fin = $this->dameFechaFinal($fecha);
        $consulta = $this->getQueryBuilder();
        $consulta
                ->Select('distinct p.fechaParte')
                ->Where("p.empresa =:empresa") 
                ->setParameter('empresa', $empresa)
                ->andWhere('p.fechaParte BETWEEN :inicio AND :fin') 
                ->setParameter('inicio', $inicio) 
                ->setParameter('fin', $fin);
                ;        
        $consulta->orderby('p.fechaParte', 'ASC')
                ->groupBy('p.fechaParte')
            ->getQuery(); 

    return $consulta->getQuery()->getResult();
    }
    
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();

        $qb = $em->getRepository('PartesBundle:Partes')
            ->createQueryBuilder('p');

        return $qb;
    }
    
    private function damefechaInicial(String $fecha){
        
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2)),1,intval(substr($fecha,6,4))));
        
    }
    private function damefechaFinal(String $fecha){
        
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2))+1,0,intval(substr($fecha,6,4))));
        
    }
}
