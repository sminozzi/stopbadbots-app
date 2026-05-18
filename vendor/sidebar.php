<?php

/**
 * @ Author: Bill Minozzi
 * @ Create Time: 1970-01-01 01:00:00
 * @ Modified time: 2022-02-14
 */

?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <img src="img/logo.png" alt="" style="width:200px;">
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="startup.php">
      <i class="fas fa-fw fa-question"></i>
      <span>Startup Guide</span></a>
  </li>
  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-medkit"></i>
      <span>Help</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="dashboard.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="setup.php">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Setup</span></a>
  </li>
  <!-- Nav Item - Pages Collapse Menu  -->
  <li class="nav-item active">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-cog"></i>
      <span>Tables</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Bots Tables:</h6>
        <a class="collapse-item active" href="tables.php">Bad Bots Table</a>
        <a class="collapse-item" href="tables-ip.php">Bad IP Table</a>
        <a class="collapse-item" href="tables-ref.php">Bad Referer Table</a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="http://stopbadbots.com/premium-non-wordpress/">
      <i class="fas fa-fw fa-plus"></i>
      <span>Go Pro</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>


