<?php

/**
 * Class UserRoleModel
 *
 * This class contains everything that is related to up- and downgrading accounts.
 */
class UserRoleModel
{
    /**
     * Upgrades / downgrades the user's account. Currently it's just the field user_account_type in the database that
     * can be 1 or 2 (maybe "basic" or "premium"). Put some more complex stuff in here, maybe a pay-process or whatever
     * you like.
     *
     * @param $type
     *
     * @return bool
     */
    public static function changeUserRole($type)
    {
        if (!$type) {
            return false;
        }

        // save new role to database
        if (self::saveRoleToDatabase($type)) {
            Session::add('feedback_positive', Text::get('FEEDBACK_ACCOUNT_TYPE_CHANGE_SUCCESSFUL'));
            return true;
        } else {
            Session::add('feedback_negative', Text::get('FEEDBACK_ACCOUNT_TYPE_CHANGE_FAILED'));
            return false;
        }
    }

    /**
     * Writes the new account type marker to the database and to the session
     *
     * @param $type
     *
     * @return bool
     */
    public static function saveRoleToDatabase($type)
    {
        // if $type is not 1 or 2
        if (!in_array($type, [1, 2])) {
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("UPDATE users SET user_account_type = :new_type WHERE user_id = :user_id LIMIT 1");
        $query->execute(array(
            ':new_type' => $type,
            ':user_id' => Session::get('user_id')
        ));

        if ($query->rowCount() == 1) {
            // set account type in session
            Session::set('user_account_type', $type);
            return true;
        }

        return false;
    }

    /**
     * Gets an array that contains all the user_roles in the database. The array's keys are the user_role ids.
     * Each array element is an object, containing the role_name and the id of the user_role. 
     * 
     * @return array The role_name and the id of the user_role table
     */
    public static function getAllroles(){
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "select id, role_name from user_roles;";
        $query = $database->prepare($sql);
        $query->execute();

        $roles = array();

        foreach($query->fetchAll() as $role){
            $roles[$role->id] = new stdClass();
            $roles[$role->id]->id = $role->id;
            $roles[$role->id]->role_name = $role->role_name;
        }

        return $roles;
    }
}
