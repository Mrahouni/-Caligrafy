<?php

use Caligrafy\Controller;

class ProjectController extends Controller {
    
    
    public function index()
    {
        $this->associate('Project','projects');
        $projects = $this->all()?? array();

        return view('showcase/index',array('projects'=>$projects));
        /*
        foreach ($projects as $key => $project)
        {
            echo'Project'.($key+1);
            echo'<br>';
            dump($project);
        }
        */

    }
    
    public function readProject()
    {
        $this->associate('Project','projects');
        $project=$this->find();
        dump($project);
        dump($project->user());
    }
    
    
    public function addProject()
    {
        $this->associate('Project','projects');
        $parameters=$this->request->parameters;
        //dump($parameters);exit;
        $project = new Project();
        $project->title= $parameters['title'] ?? 'no';
        $project->category= $parameters['category'] ?? 'no';
        $project->short_description= $parameters['short_description'] ?? 'no';
        $project->description= $parameters['description'] ?? 'no';
        $project->image_url= $parameters['image_url'] ?? 'no';
        $project->user_id= $parameters['user_id'] ?? 1;
        dump($this->save($project));

        /*
        $project = new Project();
        $project->title=' title 3';
        $project->category=' category 3';
        $project->short_description=' short_description 3';
        $project->description='description 3';
        $project->image_url='image_url 3';
        dump($this->save($project));
        */
    }

    public function updateProject()
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
            dump($this->save($project));
            dump($project->user());
        }else echo 'I could not find the Project for you';

    }

    public function deleteProject()
    {
        $this->associate('Project','projects');
        dump($this->delete());
    }

    /*
     *
     */

    
}