<?php

use Caligrafy\Controller;

class PageController extends Controller {
    
    
    public function index()
    {
        if(!authorized()){
            redirect('/login');
        }
        else{
            $this->associate('Project','projects');
            $projects = $this->all()?? array();

            return view('showcase/index',array('projects'=>$projects,'metadata'=>metadata(),
                'social'=>true,'google_analytics'=>true));
        }
        /*
        return view('showcase/index',array('title'=>'Hello form pug',
            'heading'=>'heading 1',
            'h1'=>'heading 2',
            'heading2'=>' section heading ',
            'paragraphe'=>' paragraphe'
            ));
        */
    }

    public function showcaseForm()
    {
        return view('showcase/add');
    }

    public function add()
    {
        if(!authorized()){
            redirect('/login');
        }
        else{

        $this->associate('Project','projects');
        $parameters=$this->request->parameters;
        $userInput=(Object)$parameters;

        $validate=$this->validator->check($parameters,array('title'=>'required | max_len,20',
            'category'=>'required ',
            'short_description'=>'required | max_len,200',
            'description'=>'required',
            'image_url'=>'required_file|extension,png;jpg;jpge'));

        if($validate !==true) {
            return view('showcase/add',array('error'=>true,
                'status'=>'danger','message_header'=>'Whooops ,something went wrong',
                'message'=>'Some of the inputs are invalid . Make sure are all the required inputs entered properly ',
                'errors'=>$validate,
                'project'=>$userInput));
            exit;
        }

        $file=$this->request->files('image_url');
        if($file){
            $image_url = uploadFile($file);
        }

        $project = new Project();
        $project->title= $parameters['title'] ?? 'no';
        $project->category= $parameters['category'] ?? 'no';
        $project->short_description= $parameters['short_description'] ?? 'no';
        $project->description= $parameters['description'] ?? 'no';
        $project->image_url= isset($image_url)  ? $image_url : 'http:';
        $project->user_id= $parameters['user_id'] ?? 1;
        $this->save($project);
        redirect('/');
        }

    }

    public function update()
    {
        $this->associate('Project','projects');
        $project=$this->find();
        if ($project)
        {
            $parameters=$this->request->parameters;
            $project->title= $parameters['title'] ?? $project->title;
            $project->category= $parameters['category'] ?? $project->category;
            $project->short_description= $parameters['short_description'] ?? $project->short_description;
            $project->description= $parameters['description'] ?? $project->description;
            $project->image_url= $parameters['image_url'] ?? $project->image_url;
            $project->user_id= $parameters['user_id'] ?? $project->user_id;
            $this->save($project);
            $project->user();
        }else echo 'I could not find the Project for you';

    }


    public function delete()
    {
        $this->associate('Project','projects');
        $this->delete();
        redirect('/');
    }

    /*
     *
     */
    
}