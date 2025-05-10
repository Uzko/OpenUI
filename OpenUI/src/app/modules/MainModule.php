<?php
namespace app\modules;

use php\compress\ZipException;
use Exception;
use php\compress\ZipFile;
use std, gui, framework, app;


class MainModule extends AbstractModule
{

    /**
     * @event UIload.action 
     */
    function doUIloadAction(ScriptEvent $e = null)
    {   
    global $logs;  
    $nameus = get_current_user();
    $proverkafo = "C:/Users/". $nameus ."/.Develnext";
    if (is_dir($proverkafo)){
        
    }else{
        return;
    }
    
$logs = 0;

if (app()->form('MainForm')->checkboxAlt->selected == true) {
    $logs = 1;
    file_put_contents("logs.txt", "");
}else{
    fs::delete("logs.txt");
}
    
         if (fs::exists('dnprject')){
            fs::clean('dnprject');
            fs::delete('dnprject');
        }
    
            $textar = $this->textArea->text;
       
            $id = app()->form('MainForm')->edit->text;
            if (fs::exists($id)){
                    $afterSlash = fs::nameNoExt($id) . "\\";
                    fs::makeDir($afterSlash);
                    fs::makeDir($afterSlash . "/src/.theme");
                    fs::makeDir($afterSlash . "/src/app/forms");
                    fs::makeDir($afterSlash . "/src/app/modules");
                    fs::makeDir($afterSlash . "/src/.data/img");
                    echo "Project folder created \n";
                    fs::makeDir("dnprject");
                    echo "dn too";
                    fs::makeDir("Time \n");
                }else{
                    echo "File not found | Файл не был найден";
                    return;
                }
                
    $zip = new ZipFile($id);
    $zip->unpack("./Time");
           
           $targetTheme = "./Time/.theme";  //path to unpacked app | temporary files
           $targetForms = "Time/app/forms"; //path to unpacked app | temporary files
           $targetModules = "Time/app/modules"; //path to unpacked app | temporary files
           $targetImage = "Time/.data/img"; //path to unpacked app | temporary files
           $targetAudio = "Time/.data/audio"; //path to unpacked app | temporary files
           
           
           $targetcss = $afterSlash . "/src/.theme/";
           
           //theme projectf
            fs::scan($targetTheme, function (File $filet, $depth) use ($targetcss, $logs)  {
            if ($logs == 1){
                file_put_contents("logs.txt", $filet . "\n");
                $this->textArea->text .= $filet . "\n";
            }
                echo $filet, "\n";
                $fileName = fs::name($filet);
                fs::copy($filet, $targetcss . $fileName);
            });
            
            //image projectf
            
$targetimg = $afterSlash . "/src/.data/img";

fs::scan($targetImage, function (File $fileimg, $depth) use ($targetimg, $logs) {
    $targetPath = $targetimg . "/" . fs::name($fileimg);
                if ($logs == 1){
                file_put_contents("logs.txt", $fileimg . "\n", FILE_APPEND);
                 $this->textArea->text .= $fileimg . "\n";
            }
    echo $fileimg, "\n";
    if ($fileimg->isFile()) {
        fs::copy($fileimg, $targetPath);
    } else if ($fileimg->isDirectory()) {
        fs::makeDir($targetPath);
        fs::scan($fileimg, function (File $subfile) use ($targetPath) {
            if ($subfile->isFile()) {
                fs::copy($subfile, $targetPath . "/" . fs::name($subfile));
            }
        });
    }
});

$targetaudio = $afterSlash . "/src/.data/audio";
fs::makeDir($targetaudio);
fs::scan($targetAudio, function (File $fileaudio, $depth) use ($targetaudio, $logs) {
    $targetPath = $targetaudio . "/" . fs::name($fileaudio);
    if ($logs == 1){
        file_put_contents("logs.txt", $fileaudio . "\n", FILE_APPEND);
         $this->textArea->text .= $fileaudio . "\n";
    }
    echo $fileaudio, "\n";
    if ($fileaudio->isFile()) {
        fs::copy($fileaudio, $targetPath);
    } else if ($fileaudio->isDirectory()) {
        fs::makeDir($targetPath);
        fs::scan($fileaudio, function (File $subfile) use ($targetPath) {
            if ($subfile->isFile()) {
                fs::copy($subfile, $targetPath . "/" . fs::name($subfile));
            }
        });
    }
});
            
            $targetform = $afterSlash . "/src/app/forms/";
            
            //forms projectf
            fs::scan($targetForms, function (File $filef, $depth) use ($targetform, $logs){
                        if ($logs == 1){
                file_put_contents("logs.txt", $filef . "\n", FILE_APPEND);
                $this->textArea->text .= $filef . "\n";
            }
                echo $filef, "\n";
                $fileName = fs::name($filef);
                fs::copy($filef, $targetform . $fileName);
            });
            
            //modules projectf
            
            $targetmod = $afterSlash . "/src/app/modules/";
           
            fs::scan($targetModules, function (File $filem, $depth) use ($targetmod, $logs)  {
                            if ($logs == 1){
                file_put_contents("logs.txt", $filem . "\n", FILE_APPEND);
                $this->textArea->text .= $filem . "\n";
            }
                echo $filem, "\n";
                $fileName = fs::name($filem);
                fs::copy($filem, $targetmod . $fileName);
            });   
             
                
            $dnproj = "res://.data/dn_prject.rar";
            copy($dnproj, "dn_prject.rar");
            $zipdn = new ZipFile("dn_prject.rar");
            
            $zipdn->unpack("dnprject");
            $filezip = new File("dn_prject.rar");
            $filezip->delete();
            
function copyAll($from, $to) {
    fs::makeDir($to);
    fs::scan($from, function(File $file) use ($to) {
        $target = $to . "/" . fs::name($file);
        if ($file->isFile()) {
            fs::copy($file, $target);
        } else if ($file->isDirectory()) {
            copyAll($file, $target);
        }
    });
}

$dn = $afterSlash . "src/.data/img";
$slash = "dnprject/src/.data/img";
copyAll($dn, $slash);
 
            fs::clean("dn_prject/src/.theme");
            fs::clean("Time");
            fs::delete("Time");
            
            $dn = $afterSlash . "src/.theme/"; 
            $slash = "dnprject/src/.theme/";
            
            //Theme copied!
            
            fs::scan($dn, function (File $filetheme, $depth) use ($slash){
                $fileName = fs::name($filetheme);
                fs::copy($filetheme, $slash . $fileName);
            });
            
            
            
            
            $dn = $afterSlash . "src/app/forms/";
            $slash  = "dnprject/src/app/forms/";
            $mForm = $slash . "MainForm.php";
            
            //php form copied! (forms)
            
            fs::scan($dn, function (File $fileforms, $depth) use ($slash, $mForm){        
                if ($fileforms->isFile() && fs::ext($fileforms) === "phb"){
                    $fileName = fs::name($fileforms);
                    $fileName = str_replace(".phb", "", $fileName);
                    fs::copy($mForm, $slash . $fileName . ".php");
                    wait(1000);
                    fs::delete($fileforms);
                }
            });
            
            //axml, fxml, conf, behaviour, php.axml copied! (forms)
            
            fs::scan($dn, function (File $fileaxml, $depth) use ($slash){
                $fileName = fs::name($fileaxml);
                fs::copy($fileaxml, $slash . $fileName);
            });
            
            $dn = $afterSlash . "src/.data/audio/";
$slash = "dnprject/src/.data/audio/";
fs::makeDir($slash);
fs::scan($dn, function (File $fileaudio, $depth) use ($slash){
    $fileName = fs::name($fileaudio);
    fs::copy($fileaudio, $slash . $fileName);
});

            
                                    $dn = $afterSlash . "src/app/modules/";
            $slash  = "dnprject/src/app/modules/";
            $mForm = $slash . "MainModule.php";
            
            //php form copied! (forms)
            
            fs::scan($dn, function (File $fileforms, $depth) use ($slash, $mForm){        
                if ($fileforms->isFile() && fs::ext($fileforms) === "phb"){
                    $fileName = fs::name($fileforms);
                    $fileName = str_replace(".phb", "", $fileName);
                    fs::copy($mForm, $slash . $fileName . ".php");
                    wait(1000);
                    fs::delete($fileforms);
                }
            });
            
            fs::scan($dn, function (File $filemod, $depth) use ($slash){
                $fileName = fs::name($filemod);
                fs::copy($filemod, $slash . $fileName);
            });
            
            $audiofold = new File($slash);
            
            if (fs::exists($afterSlash . "src/app/.data/audio/")){
            
            fs::makeDir('dnprject/src/.data/audio');
            
            $dn = $afterSlash . "src/.data/audio/";
            $slash  = "dnprject/src/.data/audio/";
            
                fs::scan($dn, function (File $filemod, $depth) use ($slash){
                    $fileName = fs::name($filemod);
                    fs::copy($filemod, $slash . $fileName);
                });
            
            }
            fs::clean($afterSlash);
            fs::delete($afterSlash); 
            
            open("dnprject/openuicompleted.dnproject");
            
            app()->shutdown();
            
            //version 1.0.1.8
            //Added images, modules, thread, logs,
    }
        
}
