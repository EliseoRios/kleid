<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Imagenes;

class ImagenesController extends Controller
{
    public function imagen($id = 0){
        $imagen = Imagenes::find($id);

        if (!$imagen){
            //Leerimagen de dafault
            $blob = file_get_contents(asset('img/noencontrada.png'));
            $nombre = "nodisponible.png";
            $mime = 'image/png';
        } else {
            $blob = $imagen->imagen;
            $nombre = $imagen->archivo;
            $mime = $imagen->mime;
        }

    
        header("Content-Type: ".$mime);

        header('Content-Disposition: inline; filename="'.$nombre.'"');
        echo $blob;
    }
}
