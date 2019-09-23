<?php 

namespace App\Repository;

ini_set('display_startup_errors', 0);
ini_set('display_errors', 0);
ini_set("memory_limit","-1");
error_reporting(0);

//use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

use App\Document\Article;

class ArticleRepository extends DocumentRepository
{
    public function findDisabled()
    {
        $qb = $this->createAggregationBuilder(Article::class);

        $qb->group()
            ->field('id')
            ->expression('$department')
            ->field('department')
            ->first('$department')
            ->field('number_record')
            ->sum(1);

        $results = $qb->execute()->toArray();
        //echo "<pre>";print_R($results);

        // exit;
        // $results = $this->findBy(['status' => "0"]);

        // $results = $this->createQueryBuilder(\App\Document\Article::class)
        //     ->find()
        //     ->field('status')->equals('0')
        //     ->getQuery()
        //     ->execute()
        //     ->toArray();
        
        return $results;
    }

    

    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder()
            ->sort('salary', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function groupByFamily(): array
    {
        $builder = $this->createAggregationBuilder(\App\Document\Article::class);
        //$builder->match()->field('salary')->count('numSingleItemOrders');
        echo 'count:===>';count($builder);

        // $qb = $this->createQueryBuilder(Article::class)->select('status');
        // $query = $qb->getQuery();
        // $users = $query->execute();
        // print_r($users);
               
        /* $qb = $this->createAggregationBuilder(Article::class);

        $qb->group()
        ->field('id')
        ->expression('$department')
        ->field('department')
        ->first('$department')
        ->field('number_record')
        ->sum(1);

        $results = $qb->execute();
        $query = $qb->getQuery();
        $debug = $query->debug();
        print_R($debug);
         echo "Testtt==>";print_R($results);exit;
        // return $results; */
    }
}

