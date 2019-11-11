<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Recibe un archivo json
     * Lee las rutas de las imágenes que el json provee para que se copien a otro destino
     * 
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getJson(Request $request)
    {
        $file = $request->json;
        $json = json_decode(file_get_contents($file->path()), true);
        
        $dest = 'copy/';
        $locations = [];
        $destPaths = [];

        foreach ($json['data'] as $data) {
            array_push($locations, $data['path_image']);
            array_push($destPaths, $dest.$data['path_image']);
        }

        $this->copyImage($locations, $dest);
        $result = $this->notCopied($locations, $dest);

        return view('result', compact('result', 'dest'));

    }

    /**
     * Verifica qué imágenes no se ha encontrado en la ruta destino y las retorna si es que encuentra
     * 
     * @param array $locations
     * @param string $dest
     * @return array
     */
    public function notCopied($locations, $dest)
    {
        $notCopied = [];
        foreach ($locations as $location) {
            if (!Storage::exists($dest.$location)) {
                array_push($notCopied, $location);
            }
        }
        return ($notCopied);
    }

    /**
     * Copia las imágenes que se le dé como parámetro al Storage en la carpeta especificada
     * Crea el registro en la base de datos
     * 
     * @param array $locations
     * @param string $dest
     */
    public function copyImage($locations, $dest)
    {
        foreach($locations as $location){
            if (!Storage::exists($dest.$location)) {
                Storage::disk('local')->copy($location, $dest.$location);
    
                Image::updateOrCreate(      //Si es que por alguna razón ya estaba registrado en la bd mas la imagen no estaba en el storage
                    [
                        'name_image' => $dest.$location
                    ],
                    [
                        'name_image' => $dest.$location,
                        'date_created' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Si hay imágenes que no se pudieron copiar
     * Con este método se puede volver a intentar individualmente 
     * 
     * @return string
     */
    public function copyOneImage()
    {
        $path = $this->request->input('path');
        $dest = $this->request->input('dest');
        $this->copyImage((array) $path, $dest);
     
        return 'copiado';
    }

}
