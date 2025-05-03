<?php
namespace app\forms;

use php\compress\ZipFile;
use std, gui, framework, app;


class MainForm extends AbstractForm
{

     /**
     * @event buttonAlt.click-Left 
     */
    function doButtonAltClickLeft(UXMouseEvent $e = null)
    {    
    
        if ($this->checkbox->selected != true){
            $this->fileChooser->filterName = "exe-файл";
            $this->fileChooser->filterExtensions = "*.exe";
        }else{
            $this->fileChooser->filterName = "JAR-файл";
            $this->fileChooser->filterExtensions = "*.jar";
        }
        $wtf = $this->fileChooser->execute();
        $this->edit->text = $wtf;
    }

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    { 
    app()->form('MainForm')->panel->show();              
    $this->script->callAsync();
            
    }

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->panel->hide();
    }

}
