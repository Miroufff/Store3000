<?php

/**
 * Created by PhpStorm.
 * User: mirouf
 * Date: 23/06/16
 * Time: 14:32
 */

namespace AppBundle\Services;
use Doctrine\ORM\EntityManager;

/**
 * Class RefGeneratorService
 *
 * @package AppBundle\Services
 */
class RefGeneratorService
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @param EntityManager     $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * @param  string $entityName
     *
     * @return string
     */
    public function getLastInsertedId($entityName)
    {
        $result = $this->em->createQueryBuilder();
        $last_inserted_id = $result->select('MAX(x.id) as id')
            ->from("AppBundle:".$entityName, 'x')
            ->getQuery()
            ->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        if ($last_inserted_id['id'] != null) {
            $last_inserted_id['id'] = $last_inserted_id['id'] + 1;
            return ucfirst($entityName[0])."-0".$last_inserted_id['id'];
        } else {
            return ucfirst($entityName[0])."-01";
        }
    }
}