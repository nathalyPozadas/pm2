<?php

namespace Database\Seeders;

use App\Models\Almacen;
use App\Models\Empaque;
use App\Models\Empresa;
use App\Models\ListaEmpaques;
use App\Models\Proveedor;
use App\Models\Trabajador;
use App\Models\UbicacionAlmacen;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        $empresa = Empresa::create([
            'nombre_comercial' => 'Perbol',
            'razon_social' => 'Perbol',
            'nit' => '8565788152',
            'direccion' => 'Av banzer calle2',
            'icono'=> "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"
        ]);

        
        $trabajador = Trabajador::create([
            'nombres' => 'Pablo',
            'apellidos' => 'Suarez Merida',
            'fecha_nacimiento' => '2024-06-05',
            'cargo' => 'gerente',
            'telefono' => '67832810',
            'direccion' => 'Av Santa Cruz nro 125',
            'ci' => '8575455',
            'sexo' => 'M',
            'empresa_id' => $empresa->id
        ]);


       $usuario = User::create([
          // 'name' => 'pablo perez',
           'email' => 'pablo.suarez@gmail.com',
           'email_verified_at' => now(),
           'password' => Hash::make('admin'),
           'created_at' => now(),
           'updated_at' => now(),
           'trabajador_id' => $trabajador->id,
           'empresa_id' => $empresa->id
       ]);

        $proveedor = Proveedor::create([
            'nombre' => 'VODAFAST',
            'empresa_id' => $empresa->id
        ]);

        $almacen1 = Almacen::create([
            'nombre' => 'almacen temporal',
            'empresa_id' => $empresa->id,
            'descripcion_direccion' => 'av lazarte nro 12'
        ]);

        $ubicacion_almacen1_1 = UbicacionAlmacen::create([
            'nombre' => 'A',
            'almacen_id' => $almacen1->id,
            'empresa_id' => $empresa->id
        ]);

        $ubicacion_almacen1_2 = UbicacionAlmacen::create([
            'nombre' => 'B',
            'almacen_id' => $almacen1->id,
            'empresa_id' => $empresa->id
        ]);

        $almacen2 = Almacen::create([
            'nombre' => 'almacen Norte',
            'empresa_id' => $empresa->id,
            'descripcion_direccion' => 'av Beni'
        ]);

        $ubicacion_almacen2_1 = UbicacionAlmacen::create([
            'nombre' => 'A',
            'almacen_id' => $almacen2->id,
            'empresa_id' => $empresa->id
        ]);

        $ubicacion_almacen2_2 = UbicacionAlmacen::create([
            'nombre' => 'B',
            'almacen_id' => $almacen2->id,
            'empresa_id' => $empresa->id
        ]);

        $ubicacion_almacen2_3 = UbicacionAlmacen::create([
            'nombre' => 'C',
            'almacen_id' => $almacen2->id,
            'empresa_id' => $empresa->id
        ]);

        $listaEmpaques1 = ListaEmpaques::create([
            'codigo' => '20JA-02',
            'factura' => '12345678',
            'proveedor_id' => $proveedor->id,
            'stock_esperado' => 22,
            'almacen_id' => $almacen1->id,
            'fecha_recepcion' => now(),
            'fecha_llegada' => now(),
            'fecha_creacion' => now(),
            'encargado_id' => $trabajador->id,
            'empresa_id' => $empresa->id
        ]);

        $empaque1_1 = Empaque::create([


            'tipo'=>'caja',
            'numero'=>1,
            'descripcion' => 'desc caja',
            'estado'=>'dañado',
            'observacion_estado'=> 'la caja esta rota',
            'lista_empaques_id'=> $listaEmpaques1->id,
            'fecha_registro' => now(),
            'encargado_id' => $trabajador->id ,
            'ubicacion_almacen_id' => $ubicacion_almacen1_1->id,
            'criterio1'=>true,
            'criterio2'=>false,
            'criterio3'=>true,
            'empresa_id'=>$empresa->id

        ]);

        $listaEmpaques1->stock_registrado = $listaEmpaques1->stock_registrado+1;
        $listaEmpaques1->stock_actual = $listaEmpaques1->stock_actual+1;
        $listaEmpaques1->update();

        $empaque1_2 = Empaque::create([
            'tipo'=>'caja',
            'numero'=>2,
            'descripcion' => 'caja de tuercas',
            'estado'=>'dañado',
            'observacion_estado'=> 'la caja esta rota',
            'lista_empaques_id'=> $listaEmpaques1->id,
            'fecha_registro' => now(),
            'encargado_id' => $trabajador->id ,
            'ubicacion_almacen_id' => $ubicacion_almacen1_2->id,
            'criterio1'=>true,
            'criterio2'=>true,
            'criterio3'=>true,
            'empresa_id'=>$empresa->id

        ]);

        $listaEmpaques1->stock_registrado = $listaEmpaques1->stock_registrado+1;
        $listaEmpaques1->stock_actual = $listaEmpaques1->stock_actual+1;
        $listaEmpaques1->update();

        
    }
}
