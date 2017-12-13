<?php

namespace App\Backend;

class SiteController
{
//    /**
//     * @Inject
//     * @var DbConnection
//     */
//    private $db;

    public function actionIndex(Request $request)
    {
        echo 'Hello, index page';

//        var_dump($this->db->getAtlas());
    }

    public function actionError(Request $request)
    {
        printf('Bad request. <a href="%s">Go back.</a>', $request->createUrl('home'));
    }

    public function actionPhpInfo()
    {
        phpinfo();
    }
}