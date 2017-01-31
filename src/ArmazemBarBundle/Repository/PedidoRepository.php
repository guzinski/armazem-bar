<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PedidoRepository
 *
 * @author Luciano
 */
class PedidoRepository extends EntityRepository
{
    
    /**
     * Retorna os pedidos da cozinha
     * 
     * @param boolean $concluidos Se TRUE - Tras "somente" os pedidos finalizados
     * @param boolean $cancelados Se TRUE - Tras "também" os pedidos cancelados
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPedidosCozinha($concluidos = FALSE, $cancelados = FALSE)
    {
        $hoje = new \DateTime("now");
        $query = $this->createQueryBuilder("P");
        if ($concluidos) {
            $query->andWhere($query->expr()->eq("P.situacao", ":situacao"));
        } else {
            $query->andWhere($query->expr()->neq("P.situacao", ":situacao"));
        }
        
        if (!$cancelados) {
            $query->andWhere($query->expr()->eq("P.cancelado", ":cancelado"))
                ->setParameter("cancelado", FALSE);
        }
        
        $query->andWhere($query->expr()->between("P.dataCadastro", ":inicioDoDia", ":finalDoDIa"))
                ->setParameter("situacao", \ArmazemBarBundle\Entity\Pedido::CONCLUIDO)
                ->setParameter("inicioDoDia", $hoje->setTime("0", "0", "0")->format("Y-m-d H:i:s"))
                ->setParameter("finalDoDIa", $hoje->setTime("23", "59", "59")->format("Y-m-d H:i:s"))
                ->addOrderBy($query->expr()->asc("P.cancelado"))
                ->addOrderBy($query->expr()->desc("P.situacao"))
                ->addOrderBy($query->expr()->desc("P.dataCadastro"));
        
        return $query->getQuery()->getResult();
    }
    
    public function getRelatorio($periodoInicio = null, $periodoFim = null)
    {
        $query = $this->createQueryBuilder("P");
        
        if ($periodoInicio) {
            $query->andWhere($query->expr()->gt("P.dataCadastro", ":periodoInicio"))
                    ->setParameter("periodoInicio", $periodoInicio->format("Y-m-d"). " 00:00");
        }
        if ($periodoFim) {
            $query->andWhere($query->expr()->lt("P.dataCadastro", ":periodoFim"))
                    ->setParameter("periodoFim", $periodoFim->format("Y-m-d"). " 23:59");
        }
        $query->andWhere($query->expr()->eq("P.situacao", ":situacao"))
                ->setParameter("situacao", \ArmazemBarBundle\Entity\Pedido::CONCLUIDO);
        
        return $query->getQuery()->getResult();
    }

}
