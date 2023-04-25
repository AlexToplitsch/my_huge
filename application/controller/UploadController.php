<?php

class UploadController extends Controller
{


    public function __construct()
    {
        Auth::checkAuthentication();
        parent::__construct();
    }

    public function uploadImage()
    {
        if (isset($_POST['submit'])) {
            $fileName = $_FILES['uploadFile']['name'];
            $fileTmpName = $_FILES['uploadFile']['tmp_name'];
            $fileSize = $_FILES['uploadFile']['size'];
            $fileError = $_FILES['uploadFile']['error'];
            $fileExtension = explode('.', $fileName);
            $fileExtension = end($fileExtension);
            $fileActualExtension = strtolower($fileExtension);

            $res = $this->isImageValid($fileError, $fileSize, $fileActualExtension);
            $isImageValid = $res[0];
            $validationMessage = $res[1];
            if (!$isImageValid) {
                Session::add('feedback_negative', $validationMessage);
                Redirect::to('images/index');
                return;
            }
            $newFileName = uniqid('', false) . "." . $fileActualExtension;
            $destinationPath = Config::get('PATH_UPLOADS') . $newFileName;
            move_uploaded_file($fileTmpName, $destinationPath);
            ImageModel::storeImage($newFileName);
            Redirect::to('images/index');
        }
    }

    private function isImageValid($fileError, $fileSize, $fileActualExtension)
    {
        $allowed = array('jpg', 'jpeg', 'png');

        if (!in_array($fileActualExtension, $allowed)) {
            return array(false, "Only jpg, jpeg or png files are allowed");
        }
        if ($fileError !== 0) {
            return array(false, "There was an error uploading your file");
        }
        if ($fileSize > 1000000) {
            return array(false, "File is too big");
        }

        return array(true, "Ok");
    }
}
