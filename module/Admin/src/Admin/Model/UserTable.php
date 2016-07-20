<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Model;
/**
 * Description of UserTable
 *
 * @author USER
 */
use \Zend\Db\Adapter\Adapter;
use \Zend\Db\TableGateway\AbstractTableGateway;
//use \Zend\Db\Sql\Select;

class UserTable extends AbstractTableGateway
{
    protected $table = 'users';

	public function __construct(\Zend\ServiceManager\ServiceManager $serviceLocator) {
		$this->adapter = $serviceLocator->get('authdb');
		$this->initialize();
    }
	
    public function fetchAll() {
        $resultSet =	$this->select(function (\Zend\Db\Sql\Select $select) //Zend\Db\ResultSet\ResultSet
						{
							$select->order('created ASC');
						});
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new \Admin\Model\User();
            $entity	->setId($row->id)
					->setUsername($row->username)
					->setPassword($row->password)
					->setGender($row->gender)
					->setEmail($row->email)
					->setActive($row->active)
					->setCreated($row->created);
            $entities[] = $entity;
        }
        return $entities;
    }
	
    public function getUser($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $stickyNote = new \Admin\Model\User(array(
                    'id' => $row->id,
                    'user' => $row->username,
                    'created' => $row->created,
                ));
        return $stickyNote;
    }
	
	public function saveUser(\Admin\Model\User $user) {
        $data = array(
            'username'	=> $user->getNote(),
			'active'	=> $user->getActive(),
            'created'	=> $user->getCreated(),
        );

        $id = (int) $user->getId();

        if (!$id) {
            $data['created'] = date('Y-m-d H:i:s');
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getUser($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
	
    public function removeUser($id) {
        return $this->delete(array('id' => (int) $id));
    }
}
