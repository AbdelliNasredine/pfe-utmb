<?php

namespace App\Controllers;


class AdminController extends BaseController
{
    /* méthod d'affichage de page d'administration */
    public function index($request, $response)
    {
        $this->view->render($response, 'admin/admin.view.twig', []);
    }
}