<div class="menu">
    <ul class="list">
        <li class="header">MENU PRINCIPAL</li>

        <li class="active">
            <a href="{{ url('/') }}">
                <i class="material-icons">pie_chart</i>
                <span>Inicio</span>
            </a>
        </li>

        <li>
        @foreach ($menus as $menu)

            <?php 
              $opcs   = DB::table('menus')->where( DB::raw('substr(codigo,1,2)'),'=',substr($menu->codigo,0,2) )->select('id','codigo','dependencia','area','opcion','url')->OrderBy('id')->get();
             
              $icono = array('Catálogos' => 'account_balance_wallet','CRM' => 'face','Ventas' => 'shopping_cart','Configuración'=>'settings');
            ?>

            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">{{ $icono[$menu->area] }}</i>
                <span>{{ $menu->area }}</span>
            </a>

            <ul class="ml-menu">

                @foreach( $opcs as $opc)
                <li>
                    <a href="{{ URL::to($opc->url) }}">
                        <span>{{ $opc->opcion }}</span>
                    </a>
                </li>
                @endforeach
                
            </ul>
        @endforeach
        </li>
    </ul>
</div>