<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Productos;

class ImagenProductos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kleid:imagen_principal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seleccionar imagen para producto';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->cargar_imagen();
    }

    public function cargar_imagen()
    {
        $productos = Productos::all();

        $bar = $this->output->createProgressBar(count($productos));

        $bar->start();

        foreach ($productos as $key => $producto) {
            //Seleccionar imagen principal
            $primer_imagen= $producto->imagenes()->first();
            $producto->imagen_principal_id = (isset($primer_imagen))?$primer_imagen->id:0;
            $producto->save();

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
    }
}
