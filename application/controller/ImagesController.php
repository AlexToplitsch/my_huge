<?php

class ImagesController extends Controller
{


    public function __construct()
    {
        Auth::checkAuthentication();
        parent::__construct();
    }

    public function index()
    {
        $this->View->render('images/index', array(
            'images' => ImageModel::getImagesByUserId(),
        ));
    }

    public function showImage($fileName)
    {
        $image = ImageModel::getIamgeByName($fileName);
        if (empty($image) || !$image[0]->is_public) {
           Redirect::to('index');
           return;
        }
        $this->View->render('images/showImage', array(
            'image' => $fileName
        ));
    }

    public function setImagePublic()
    {
        $fileName = Request::post('id');
        ImageModel::setImagePublic($fileName);
        Redirect::to('images/index');
    }

    public function setImagePrivate($fileName)
    {
        ImageModel::setImagePrivate($fileName);
        Redirect::to("images/index");
    }
}
