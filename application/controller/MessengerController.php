<?php

/**
 * LoginController
 * Controls everything that is messenger related
 */
class MessengerController extends Controller
{


    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $unread_messages = array();
        foreach (MessageModel::getUnreadMessages() as $ur){
            $unread_messages[$ur->origin_user_id] = $ur->unread_messages;
        }

        $this->View->render('messenger/index', array(
            'users' => UserModel::getPublicProfilesOfAllUsers(),
            'unread_messages' => $unread_messages)
        );
    }
    public function showChat($user_id){
        if (isset($user_id)) {
            $this->setMessageRead($user_id);
            $this->View->render('messenger/chat', array(
                'user' => UserModel::getUsernameById($user_id),
                'messages' => MessageModel::getMessages($user_id))
            );
        } else {
            Redirect::home();
        }
    }

    public function sendMessage()
    {
        $chat_partner = Request::post('destination_id');
        if(MessageModel::sendMessage(
            Request::post('content'),
            $chat_partner
        )){
            Redirect::to("messenger/showChat/" . $chat_partner);
        }
        
    }

    public function setMessageRead($sender){
        MessageModel::updateMessagesRead($sender);
    }
}
