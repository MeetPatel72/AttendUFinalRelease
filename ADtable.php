<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allerta">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search-1.css">
    <link rel="stylesheet" href="assets/css/Table-With-Search.css">
    <link rel="stylesheet" href="assets/css/Team-Boxed.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="height: 780px;">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#" style="height: 0px;padding: 14px;">
                    <div class="sidebar-brand-icon rotate-n-15"></div>
                    <div class="sidebar-brand-text mx-3"><span><a href="" style="color: rgb(251,251,251);">ATTENDU</a></span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="ADtable.php"><i class="fas fa-table"></i><span >Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <!--div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div-->
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><strong class="mr-2 text-gray-600 small">Admin</strong><img class="border rounded-circle img-profile" src="assets/img/user.jpeg"></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                        <a class="dropdown-item" role="presentation" href="ADprofile.html">
                                          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="index.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">
                <h3 class="text-dark mb-4">Dashboard</h3>
                <div class="card shadow">
                    <div class="card-header py-3" style="margin-top: -11px;">
                        <p class="text-primary m-0 font-weight-bold" style="font-size: 28px;">Instructors<button class="btn btn-primary float-right" type="button" style="width: 160px;" onclick="window.location.href=&#39;ADAddProf.html&#39;">Add Instrutor</button></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-nowrap">
                                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label>Show&nbsp;<select class="form-control form-control-sm custom-select custom-select-sm"><option value="10" selected="">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;</label></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" onkeyup="myFunction()" id="myInput" placeholder="Search"></label></div>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <table class="table dataTable my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Office</th>
                                        <th>Phone Number</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar1.jpeg" href="courses.html"><a href="ADprofile.html" style="color: rgb(137,139,153);">Airi Satou</a></td>
                                        <td>example@school.edu</td>
                                        <td>TL304</td>
                                        <td>(123)456-7891</td>
                                        <td>Biology</td>
                                    </tr>
                                    <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar3.jpeg"><a href="ADprofile.html" style="color: rgb(144,146,160);">Bob Vance</a></td>
                                        <td>example@school.edu</td>
                                        <td>HD304</td>
                                        <td>(123)456-7891</td>
                                        <td>Computer Science<br></td>
                                    </tr>
                                    <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                      <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/avatar4.jpeg">Cara Stevens</td>
                                        <td>example@school.edu</td>
                                        <td>SER530</td>
                                        <td>(123)456-7891</td>
                                        <td>Chemistry<br></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td><strong>Email</strong></td>
                                        <td><strong>Office</strong></td>
                                        <td><strong>Phone paging_simple_numbers</strong></td>
                                        <td><strong>Department</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 3 of 3</p>
                            </div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer" style="margin-bottom: -9px;"></footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("dataTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init-1.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script src="assets/js/Table-With-Search.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/popup.js"></script>
</body>

</html>
