<?php

/**
 * Handles the CRUD operations for images
 */
class ImageModel
{

    public static function storeImage($fileName){
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO images (user_id, name) VALUES (:user_id, :file_name);";
        $query = $db->prepare($sql);
        $query->execute(
            array(
                ':user_id' => Session::get('user_id'),
                ':file_name' => $fileName 
            )
        );
        return true;
    }

    public static function getImagesByUserId(){
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT name, is_public FROM images where user_id=:user_id;";
        $query = $db->prepare($sql);
        $query->execute(
            array(
                ':user_id' => Session::get('user_id')
            )
        );
        $res = $query->fetchAll();
        return $res;
    }

    public static function getIamgeByName($fileName){
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT name, is_public FROM images where name=:file_name and is_public=1";
        $query = $db->prepare($sql);
        $query->execute(
            array(
                ':file_name' => $fileName
            )
        );
        $res = $query->fetchAll();
        return $res;
    }

    public static function setImagePublic($fileName){
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE images SET is_public=1 WHERE name=:file_name;";
        $query = $db->prepare($sql);
        $query->execute(
            array(
                ':file_name' => $fileName 
            )
        );
        return true;
    }

    public static function setImagePrivate($fileName){
        var_dump($fileName);
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE images SET is_public=0 WHERE name=:file_name;";
        $query = $db->prepare($sql);
        $query->execute(
            array(
                ':file_name' => $fileName 
            )
        );
        return true;
    }
}
