<?php 
namespace App\Modules;
 
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $modules = config("module.modules");  
       /* dd($modules);*/      
        foreach($modules as $module){

            if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                include __DIR__.'/'.$module.'/routes.php';
            }
         
            if(is_dir(__DIR__.'/'.$module.'/views')) {                
                $this->loadViewsFrom(__DIR__.'/'.$module.'/views', $module);
            }

            /*if(is_dir(__DIR__.'/'.$module.'/Model')) {
                $this->loadViewsFrom(__DIR__.'/'.$module.'/Model', $module);
            }*/
            

        }
    }

    public function register() {}

}