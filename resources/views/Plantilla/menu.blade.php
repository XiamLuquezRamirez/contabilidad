<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li id="inicio">
                    <a href="{{ url('/Inicio') }}"> <i class="menu-icon fa fa-dashboard"></i>Inicio </a>
                </li>
                <li id="empresa">
                    <a href="{{ url('/Empresas') }}"> <i class="menu-icon fa fa-building-o"></i>Gestionar empresas </a>
                </li>
                <li id="parametros" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Parametros generales</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li id="parametrosCompromiso"><i class="fa fa-legal"></i><a href="{{ url('/Compromisos') }}">Compromisos</a></li>
                        <li id="parametrosConceptos"><i class="fa fa-dollar"></i><a href="{{ url('/Conceptos') }}">Conceptos de pago</a></li>
                    </ul>
                </li>

                <li id="usuarioMenu">
                    <a href="{{ url('/Usuarios') }}"> <i class="menu-icon fa fa-users"></i>Gestionar usuarios </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>