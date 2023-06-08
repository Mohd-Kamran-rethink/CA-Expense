<style>
    .os-scrollbar-horizontal {
        display: none
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <a href="{{ url('/dashboard') }}" class="brand-link">
            <img src="https://imgs.search.brave.com/jjizMxNTRgX8Jd1PNu7XXsh0-_jVVpSJF-bVeHWJZ_c/rs:fit:860:900:1/g:ce/aHR0cHM6Ly93d3cu/a2luZHBuZy5jb20v/cGljYy9tLzc4LTc4/NjIwN191c2VyLWF2/YXRhci1wbmctdXNl/ci1hdmF0YXItaWNv/bi1wbmctdHJhbnNw/YXJlbnQucG5n"
                alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">CA Expense</span>
        </a>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item  ">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ url('/expense-type') }}"
                        class="nav-link {{ Request::is('expense-type') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>
                            My Expense
                        </p>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{ url('/expense-type') }}"
                        class="nav-link {{ Request::is('expense-type') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-th-large"></i>
                        <p>
                            Expense Type
                        </p>
                    </a>
                </li>
                {{-- <li
                class="nav-item {{ Request::is('deposit-banker') || Request::is('withdrawal-banker') || Request::is('depositers') || Request::is('withdrawrers') ? 'menu-is-opening menu-open' : '' }}">
                <a href="#"
                   class="nav-link {{ Request::is('deposit-banker') || Request::is('withdrawal-banker') || Request::is('depositers') || Request::is('withdrawrers') ? 'active' : '' }}">
                   <i class="nav-icon fa fa-users"></i>
                   <p>
                      Agents
                      <i class="right fas fa-angle-left"></i>
                   </p>
                </a>
                <ul class="nav nav-treeview"
                   style="display: {{ Request::is('deposit-banker') || Request::is('withdrawal-banker') || Request::is('depositers') || Request::is('withdrawrers') ? 'block' : 'none' }}">
                   <li class="nav-item  ">
                      <a href="{{ url('/deposit-banker') }}"
                         class="nav-link {{ Request::is('deposit-banker') ? 'active' : '' }}">
                         <p>
                            Deposit Banker
                         </p>
                         <span class="badge badge-info right">{{$depositBanker??0}}</span>
                      </a>
                   </li>
                </ul>
             </li> --}}
            </ul>
        </nav>
    </div>
</aside>
