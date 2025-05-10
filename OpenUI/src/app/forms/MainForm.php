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
    
    global $jar;
    
        if ($this->checkbox->selected != true){
            $this->fileChooser->filterName = "exe-файл";
            $this->fileChooser->filterExtensions = "*.exe";
            $jar = 0;
        }else{
            $this->fileChooser->filterName = "JAR-файл";
            $this->fileChooser->filterExtensions = "*.jar";
            $jar = 1;
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
    $this->textArea->text = "";
    $this->UIload->callAsync();
            
    }

    /**
     * @event button.construct 
     */
    function doButtonConstruct(UXEvent $e = null)
    {    
        app()->form('MainForm')->panel->hide();
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        
    }

}
