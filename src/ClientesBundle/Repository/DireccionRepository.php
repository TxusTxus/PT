<?php

namespace ClientesBundle\Repository;

/**
 * DireccionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DireccionRepository extends \Doctrine\ORM\EntityRepository
{
    /* 
    * Obtiene el listado de los clientes de una empresa
    */
    public function dameClienteDireccion($direccion){
            // Devuelve el código del cliente de una dirección dada

            $consulta = $this->getQueryBuilder();
            
            $consulta->select('c.id')
                     ->leftJoin('d.cliente', 'c')
                     ->Where("d.id =:id")
                     ->setParameter('id', $direccion);
            

            $cliente= $consulta->getQuery()->getResult();
            foreach ($cliente as $item){
               $codigoCliente =  $item['id']; 
            }
            return $codigoCliente;
    }
    
    public function dameDistritoDireccion(){
            // Devuelve los campos para el listado de dirtritos

            $consulta = $this->getQueryBuilder();
            
            $consulta->select('d.direccion',
                            'd.telefono',
                            'd.observaciones',
                            'dist.distrito',
                            'c.nombre', 'p.modelo', 'p.fechaNuevoMantenimiento','p.periodicidad','p.premium')
                     ->leftJoin('d.cliente', 'c')
                     ->leftJoin('d.producto', 'p')
                     ->leftJoin('d.distrito', 'dist');
            $consulta->orderby('d.distrito', 'ASC')
                     ->addOrderBy('p.fechaNuevoMantenimiento', 'DESC')
                     ->getQuery();
            

            $lista= $consulta->getQuery()->getResult();

            return $lista;
    }

    public function dameDistritoDireccionEntreFechas($inicio, $fin){
            // Devuelve los campos para el listado de dirtritos

            $consulta = $this->getQueryBuilder();
            
            $consulta->select('d.direccion',
                            'd.telefono',
                            'd.observaciones',
                            'dist.distrito',
                            'c.nombre', 'p.modelo', 'p.fechaNuevoMantenimiento','p.periodicidad','p.premium')
                    ->leftJoin('d.cliente', 'c')
                    ->leftJoin('d.producto', 'p')
                    ->leftJoin('d.distrito', 'dist')
                    ->Where('p.fechaNuevoMantenimiento BETWEEN :inicio AND :fin') 
                    ->setParameter('inicio', $inicio) 
                    ->setParameter('fin', $fin);
            $consulta->orderby('d.distrito', 'ASC')
                     ->addOrderBy('p.fechaNuevoMantenimiento', 'DESC')
                     ->getQuery();
            

            $lista= $consulta->getQuery()->getResult();

            return $lista;
    }
    
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();

        $qb = $em->getRepository('ClientesBundle:Direccion')
            ->createQueryBuilder('d');

        return $qb;
    }
}