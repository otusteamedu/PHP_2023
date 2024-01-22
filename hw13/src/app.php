<?php
namespace elena\hw13;

use Elena\Hw13\ActiveRecord\Attribute;
use Exception;
use PDO;

class app {

    function run()
    {
        try {
            $PDO = new PDO('mysql:host=db;dbname=cinema', 'root', 'root');
            $activeRecordAttribute = new Attribute($PDO);
            $id=9;
            echo('</br>'.'Поиск по id='.$id.'</br>');
            $ar = $activeRecordAttribute->findOneById($id);
            echo($ar->getId()." | ".$ar->getIdType()." | ".$ar->getName()." | ".$ar->getType().'</br>');

            echo('</br>'.'INSERT'.'</br>');

            $id_type = 1;
            $name='Комментарий';
            $activeRecordAttribute->setIdType($id_type);
            $activeRecordAttribute->setName($name);
            $id =$activeRecordAttribute->insert();
            echo($id.'</br>');

            echo('</br>'.'UPDATE'.'</br>');
            $id_type = 2;
            $name='Комментарий2';
            $activeRecordAttribute->setIdType($id_type);
            $activeRecordAttribute->setName($name);
            $result = $activeRecordAttribute->update($id);
            echo($result.'</br>');


            echo('</br>'.'Удаление'.'</br>');
           $result = $activeRecordAttribute->delete($id);
           echo($result.'</br>');

        } catch (Exception $e) {
            return( " Error ".$e->getMessage());
        }
    }

}
