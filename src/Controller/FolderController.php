<?php


namespace App\Controller;


use App\Http\Request;

class FolderController extends AbstractController
{
    /**
     * @Route("/folder", name="Folder")
     */
    public function index()
    {
        $a = 2;
        return $this->render("folder/list.html.twig", [
            "name"=>$a
        ]);
    }

    /**
     * @Route("/folder/list", name="Folder.list")
     */
    public function list(Request $request)
    {
        $a = $request->get("name") ?? 1;
        return $this->render("folder/list.html.twig", [
            "name"=>$a
        ]);
    }
}