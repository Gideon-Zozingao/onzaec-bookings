<nav id="sidebar" class="active">
        <div class="sidebar-header">
            <span class="close" id="close-sidebar">&times;</span>
            <h6><a href="account"><?php echo$_SESSION['accountName']?></a></h6>
        </div>
        <ul class="list-unstyled components">
            <li class="bg-dark">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                      <i class="fas fa-cog"></i>
                        Management
                </a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                      <li>
                          <a href='account?action=add&a?=room' class='dropdown-item' id='signup'>Add Room</a>
                      </li>
                        <li>
                          <a href='/add/service' class='dropdown-item' id='signup'>Add Service</a>
                        </li>
                        <li>
                            <a href='/add/facility' class='dropdown-item' id='signup'>Add  Facility</a>
                        </li>
                        <li>
                            <a href='/add/employee' class='dropdown-item' id='signup'>Add Employee</a>
                        </li>
                        <li>
                            <a href='?action=view&page=property-site-management' class='dropdown-item' id='signup'>Site Management</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-copy"></i>
                        Pages
                    </a>
                  <ul class="collapse  list-unstyled" id="pageSubmenu">
                  <li class="">
    <a class="nav-link" href="account"><i class="fas fa-home"></i>Dashboard</a>
  </li>
  <li>
    <a class="" href="#section-1"><i class="fas fa-cog"></i> Bookings</a>
  </li>
  <li>
    <a class="" href="#section-2"><i class="fas fa-user"></i> Customers</a>
  </li>
  <li>
    <a class="" href="#section-2"><i class="fas fa-user"></i> Events</a>
  </li>
  <li>
    <a class="" href="#section-2"><i class="fas fa-user"></i> Facilities</a>
  </li>
  <li>
    <a class="" href="#section-5"><i class="fas fa-pencil-alt"></i> Rooms</a>
  </li>
  <li>
    <a class="" href="#section-6"><i class="fas fa-envelope"></i> Services</a>
  </li>
                    </ul>
                </li>
                <li>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-image"></i>
                        Portfolio
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-question"></i>
                        FAQ
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-paper-plane"></i>
                        Contact
                    </a>
                </li>
            </ul>
        </nav>
