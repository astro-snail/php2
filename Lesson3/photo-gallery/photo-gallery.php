<?php

require_once 'vendor/autoload.php'; 

define("IMG_GALLERY", "small");
define("IMG_FULLSIZE", "big");

function get_path_small($filename) {
    return IMG_GALLERY."/".$filename;
}

function get_path_big($filename) {
    $arr = explode("_", $filename, 2);
    return IMG_FULLSIZE."/".$arr[0]."_1600x1600.jpg";
}

try {
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
 
    ob_start();
    
    if (isset($_GET['image'])) {
        
        $image = strip_tags($_GET['image']);
        
        $template = $twig->loadTemplate('photo.tmpl');
            
        echo $template->render(array('title' => $image, 'image' => get_path_big($image)));    
    
    } else {
        
        $images = [];

        foreach (array_diff(scandir(IMG_GALLERY), array(".", "..")) as $image) {
            $images[$image]['img_small'] = get_path_small($image);
            $images[$image]['img_big'] = get_path_big($image);
        }
        
        $template = $twig->loadTemplate('photo-gallery.tmpl');
    
        echo $template->render(array('title' => 'Photo Gallery', 'images' => $images));    
    }
    
    $content = ob_get_clean();
    echo $content;
    
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage()); 
} 

?> 