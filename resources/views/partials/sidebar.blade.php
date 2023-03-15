 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @auth

        <li class="nav-item">
          <a class="nav-link " href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->


      <li class="nav-item">
        <a class="nav-link" href="{{ route('datawarga') }}">
            <i class="bi bi-grid"></i>
            <span> Data Warga </span>
        </a>
      </li>
      @auth

      @if (auth()->user()->role == 1)

        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="{{ route('datawarga') }}">
          <i class="bi bi-journal-text"></i><span>Iuran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('iuran') }}">
              <i class="bi bi-circle"></i><span>Iuran Dansos</span>
            </a>
        </li>
        </ul>
      </li><!-- End Forms Nav -->



      @endif
      @endauth

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/profile">
            <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
    </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
    </li><!-- End Contact Page Nav -->



    </ul>
    @else
      <li class="nav-item">
        <a class="nav-link collapsed" href="/login">
          <i class="bi bi-envelope"></i>
          <span>Masuk</span>
        </a>
    </li><!-- End Contact Page Nav -->
    @endauth
  </aside><!-- End Sidebar-->
