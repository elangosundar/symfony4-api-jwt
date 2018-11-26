<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Document\Users;

class ConvertionController extends FOSRestController
{
   
    /**
     * Matches /conversion
     * 
     * @Route("/conversion")
     * 
     */
    public function indexAction($id = null ) 
    {
        echo "<pre>";
        //Mongo Connection
        $dm = $this->get('doctrine_mongodb')->getManager();
        //print_R($dm);
        /*$repository = $dm->getRepository(Article::class);
                
        if($id != null)
            $Articles = $repository->findBy(['id' => $id]); 
        else
            $Articles = $repository->findAll();
        
        //echo "<pre>";print_R($Articles);exit;*/

        //Mysql Connections
        $em = $this->getDoctrine()->getManager();
        //$RAW_QUERY = 'SELECT * FROM my_table where my_table.field = :status LIMIT 5;';
        $query_table = 'SHOW TABLES;';
        $statement = $em->getConnection()->prepare($query_table);
        
        // Set parameters 
        //$statement->bindValue('status', 1);
        $statement->execute();
        $arr_tables_result = $statement->fetchAll();

        //print_r($arr_tables_result);
        
        if(!empty($arr_tables_result)){
                        
            $char_query = "SHOW VARIABLES LIKE 'character_set%'";
            $char_statement = $em->getConnection()->prepare($char_query);
            
            $char_statement->execute();
            $char_result = $char_statement->fetchAll();
            //print_r($char_result);
            //print_r($arr_tables_result);

            foreach($arr_tables_result as $c=>$v){
                //var_dump($v);
                if(is_array($v)){
                    foreach($v as $a => $b){
                        //echo "<h3>Tables: ".$b."</h3>";	
                        $table_name = $b;
                        $query_expl_table = "EXPLAIN ".$table_name;

                        //echo "<h1>$query_expl_table</h1>";
                        $statement_expl_table = $em->getConnection()->prepare($query_expl_table);
            
                        $statement_expl_table->execute();
                        $result_expl_table[$table_name] = $statement_expl_table->fetchAll();    
                        // print_r($result_expl_table);
                    }
                }
            }

            foreach($result_expl_table as $c => $v){
                $query_table_data = 'select * from '.$c;
                //echo "<br>".$query_table_data;
                //$dm = $dm->getRepository($c);
                $dm = $this->get('doctrine_mongodb')->getManager();
                //$dm = $dm->getRepository(Users::class);
                //$collection = $dm->$c;
                //$dm->persist($article);
                // $dm->flush();

                //$dm = $this->get('doctrine_mongodb')->getManager();
                //$dm->persist('Users:class');
                //$dm->flush();
                
                $statement_table_data = $em->getConnection()->prepare($query_table_data);
                $statement_table_data->execute();
                $result_table_data = $statement_table_data->fetchAll(); 

                print_R($result_table_data);

                $arr = Array();
                foreach($result_table_data as $c => $v){
                   foreach($v as $vc => $vv){
                        //echo "<br> ====>".$vc." , ".$vv;
                        $obj[$this->utf8_encode_suissa($vc)] = $this->utf8_encode_suissa($vv);
                    }
                    $arr[] = $obj;
                }
                
                print_R($arr);

                $erro = 0;			
                $this->getTime();
                foreach($arr as $cc => $Users){
                    print_R($Users);
                    
                    if(!$dm->persist($vv)){
                        echo "<br>Did not insert".print_r($c) ;
                        $erro++;
                        $var_erro[] = var_dump($vv);
                    }
                }

                /*
                $this->getTime();
                if($erro > 0){
                    echo "<h3> The following errors occurred:</h3>";
                    foreach($var_erro as $f => $g){
                        var_dump($g);
                    }
                }*/
                
            }
        }

        echo "<br> ====> end of loop ===";exit;
    }

    public function utf8_encode_suissa($s) {
        return iconv('iso-8859-1', 'utf-8', $s);
    }

    public function getTime(){
        static $tempo; 
        if( $tempo == NULL ){
            $tempo = microtime(true);
        }else{
            echo ' MongoDB insertion time (seconds): '.(microtime(true)-$tempo).''; 
        }
    }
}
