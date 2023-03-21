<?php

/**
 * Handles the CRUD operations for messages and the join table for it
 */
class MessageModel
{

    /**
     * Sends a message to the chatpartner given by the destination_id
     * @param mixed $content
     * @param mixed $destination_user_id
     * @return bool true if the sending process was successfull; otherwise false
     */
    public static function sendMessage($content, $destination_user_id)
    {
        // None of the passed parameters can be null
        if ($content == null || $destination_user_id == null) {
            Session::add('feedback_negative', Text::get("FEEDBACK_COULD_NOT_SEND_MSG"));
            return false;
        }
        // If the no user exists by the given user ids 
        if (
            !UserModel::userExistsById($destination_user_id)
        ) {
            Session::add('feedback_negative', Text::get("FEEDBACK_COULD_NOT_SEND_MSG"));
            return false;
        }

        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO messages
                (content, origin_user_id, destination_user_id, datetime_sent)
                VALUES (:content, :origin_id, :destination_id, :datetime_sent);";
        $query = $db->prepare($sql);
        $query->execute(
            array(
                ':content' => $content,
                ':origin_id' => Session::get('user_id'),
                ':destination_id' => $destination_user_id,
                ':datetime_sent' => date('d-m-y H:i:s')
            )
        );
        Session::add('feedback_positive', Text::get('FEEDBACK_MESSAGE_SENT'));
        return true;
    }

    /**
     * @param mixed $chat_partner_id
     * @return array All message with the given chat partner; otherwise an empty array
     */
    public static function getMessages($chat_partner_id)
    {
        if ($chat_partner_id == null || !UserModel::userExistsById($chat_partner_id)) {
            return array();
        }

        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT content, u.user_id AS 'from', us.user_id AS 'to' FROM messages
                    JOIN users AS u ON u.user_id = messages.origin_user_id
                    JOIN users AS us ON us.user_id = messages.destination_user_id
                    WHERE (messages.origin_user_id = :user_id AND	messages.destination_user_id = :chat_partner)
                        OR (messages.destination_user_id = :user_id AND messages.origin_user_id = :chat_partner)
                        ORDER BY messages.datetime_sent;";
        $query = $db->prepare($sql);
        $query->execute(array(
            ':user_id' => Session::get('user_id'),
            ':chat_partner' => $chat_partner_id
        ));
        $res = $query->fetchAll();
        return $res;
    }

    /**
     * Updates the messages to read
     * @param mixed $sender
     * @return bool true if the update process was successfull; otherwise false
     */
    public static function updateMessagesRead($sender)
    {
        if ($sender == null || $sender == "") {
            return false;
        }
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE messages 
                    SET messages.read=1 
                    WHERE messages.origin_user_id = :sender AND	messages.destination_user_id = :receiver;";
        $query = $db->prepare($sql);
        $res = $query->execute(array(
            ':sender' => $sender,
            ':receiver' => Session::get('user_id')
        ));
        if (!$res) {
            Session::add('feedback_negative', Text::get("FEEDBACK_COULD_NOT_UPDATE_MSG"));
            return false;
        }
        return true;
    }

    /**
     * Summary of getUnreadMessages
     * @return array
     */
    public static function getUnreadMessages(){
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT COUNT(id) AS 'unread_messages', origin_user_id FROM messages WHERE destination_user_id=:receiver AND messages.read=0;";
        $query = $db->prepare($sql);
        $query->execute(array(
            ':receiver' => Session::get('user_id')
        ));

        $res = $query->fetchAll();
        return $res;
    }
}
