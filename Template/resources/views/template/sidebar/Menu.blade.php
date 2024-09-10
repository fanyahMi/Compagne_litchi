<ul class="sidebar-menu scrollable pos-r">
    <li class="nav-item mT-30">
      <a class="sidebar-link" href="/" >
        <span class="icon-holder">
          <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Simple</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="sidebar-link" href="{{ url('export/csv') }}">
        <span class="icon-holder">
          <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Export CSV</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="sidebar-link" href="{{ url('export/excel') }}">
        <span class="icon-holder">
          <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Export Excels</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="sidebar-link" href="{{ url('pdf') }}">
        <span class="icon-holder">
          <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Pdf</span>
      </a>
    </li>

    <li class="nav-item">
        <a class="sidebar-link" href="{{ url('formgeneralize') }}">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Formulaire</span>
        </a>
      </li>

    <li class="nav-item">
        <a class="sidebar-link" href="{{ url('tableau') }}">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Tableau</span>
        </a>
      </li>

    <li class="nav-item">
        <a class="sidebar-link" href="{{ url('tableauNormal') }}">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Tableau Normal</span>
        </a>
      </li>

    <li class="nav-item">
        <a class="sidebar-link" href="{{ url('recherche') }}">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Recherche</span>
        </a>
      </li>

    <li class="nav-item">
        <a class="sidebar-link" href="{{ url('/sendMail') }}">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Send Email</span>
        </a>
      </li>

    <li class="nav-item">
        <a class="sidebar-link" href="{{ url('/viderTables') }}">
          <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
          </span>
          <span class="title">Vider Tables</span>
        </a>
      </li>


   <li class="nav-item dropdown">
      <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
          <i class="c-orange-500 ti-layout-list-thumb"></i>
        </span>
        <span class="title">List</span>
        <span class="arrow">
          <i class="ti-angle-right"></i>
        </span>
      </a>
      <ul class="dropdown-menu">
        <li>
          <a class="sidebar-link" href="#">option A</a>
        </li>
        <li>
          <a class="sidebar-link" href="#">option B</a>
        </li>
      </ul>
    </li>
</ul>
