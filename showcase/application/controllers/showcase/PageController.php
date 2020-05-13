<?php

use Caligrafy\Controller;

class PageController extends Controller {
    
    
    public function index()
    {
        return view('showcase/index',array('title'=>'Hello form pug',
            'heading'=>'heading 1',
            'h1'=>'heading 2',
            'heading2'=>' section heading ',
            'paragraphe'=>' paragraphe'
            ));
    }

    /*
     *
     */
    
}