<?php
/*
 * Create User class document for MongoDB
*/

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */

    protected $userFirstName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $userLastName;

    /**
     * @MongoDB\Field(type="string")
     */

    protected $salary;

    /**
     * @MongoDB\Field(type="string")
     */

    protected $department;

    /**
     * @MongoDB\Field(type="string")
     */

    protected $status;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;
    }

    public function getUserFirstName()
    {
        return $this->userFirstName;
    }

    public function setUserLastName($userLastName)
    {
        $this->userLastName = $userLastName;
    }

    public function getUserLastName()
    {
        return $this->userLastName;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
