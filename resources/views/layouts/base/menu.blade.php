<div class="sidebar sidebar-style-2" data-background-color="dark">           
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('templates/atlantis/assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::user()->nombre }}
                            <span class="user-level">{{ config('sistema.perfiles')[Auth::user()->perfiles_id] }}</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MENU PRINCIPAL</h4>
                </li>

                @foreach ($menus as $menu)

                <?php 
                  $opcs   = DB::table('menus')->where( DB::raw('substr(codigo,1,2)'),'=',substr($menu->codigo,0,2) )->select('id','codigo','dependencia','area','opcion','url')->OrderBy('id')->get();
                 
                  $icono = array('Catálogos' => 'diagnoses','CRM' => 'users-cog','Ventas' => 'shopping-cart','Configuración'=>'cog');
                ?>

                @if(Auth::user()->permiso_area($menu->area))
                <li class="nav-item">
                    <a data-toggle="collapse" href="#{{ $menu->id }}">
                        <i class="fa fa-{{ $icono[$menu->area] }}"></i>
                        <p>{{ $menu->area }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="{{ $menu->id }}">
                        <ul class="nav nav-collapse">
                            @foreach( $opcs as $opc)
                                @if(Auth::user()->permiso(['menu',$opc->codigo]) > 0)
                                <li>
                                    <a href="{{ URL::to($opc->url) }}">
                                        <span class="sub-item">{{ $opc->opcion }}</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endif

                @endforeach
                
            </ul>
        </div>
    </div>
</div>