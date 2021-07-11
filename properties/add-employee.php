<?php
if(isset($_SESSION["logedin"])&&$_SESSION['userType']=="admin"&&$_SESSION['accountType']="propertyacc"){
  ?>
  <section>
    <br>
    <div class="section-title">
      <h2>Add Employee</h2>
    </div>
    <div  class="card">
      <div  class="card-body">
          <h4 class="text-left">Employee Registration</h3>
            <hr>
            <form method="POST"  action="controllers/add.employee">
              <div  class="row">
                <div  class="form-group col-md-4">
                  <label  class="h5">Employee Name</label>
                  <input type="text" name="empName" class="form-control  form-control-lg">
                </div>
                <div  class="form-group col-md-4">
                  <label  class="h5">Surname</label>
                  <input type="text" name="empSurName" class="form-control  form-control-lg">
                </div>
                <div  class="form-group col-md-4">
                  <label  class="h5">Email</label>
                  <input type="text" name="empEmail" class="form-control  form-control-lg">
                </div>
              </div>
              <div  class="row">
                <div  class="form-group col-md-4">
                  <label  class="h5">Default  Password</label>
                  <input type="text" name="empDefaultPassword" class="form-control  form-control-lg">
                </div>
              </div>
              <div class="col-md-12">
                <h3 class="text-left">Employee  Previlliges</h3>
                <table  class="table  text-left">
                  <tr>
                    <td>
                      <label>  Manage and  Update  Property Site</label>
                    </td>
                    <td>
                      <input type="checkbox" name="managePropertySite" value="Yes">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label>Create and Manage Rooms</label>
                    </td>
                    <td>
                      <input type="checkbox" name="createAndManageRooms" value="Yes">
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <label>Create and manage  Services</label>
                    </td>
                    <td>
                      <input type="checkbox" name="createAndManageSerices" value="Yes">
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <label>Create and Managem Facilitise Information</label>
                    </td>
                    <td>
                      <input type="checkbox" name="createAndManageFacilities" value="Yes">
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <label>Manage Bookings</label>
                    </td>
                    <td>
                      <input type="checkbox" name="manageBookings" value="Yes" checked>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <label>Send News  Letters</label>
                    </td>
                    <td>
                      <input type="checkbox" name="sendNewsLetters" value="Yes">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label> Create  and manage Promotions  and Ads</label>
                    </td>
                    <td>
                      <input type="checkbox" name="createandManagePromotionsAndAds" value="Yes">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label> Create and  Manage  Events</label>
                    </td>
                    <td>
                      <input type="checkbox" name="createAndManageEvents" value="Yes">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label> Write  Property  News</label>
                    </td>
                    <td>
                       <input type="checkbox" name="writePropertyNews" value="Yes">
                    </td>
                  </tr>
                </table>
              </div>
              <hr>
                <div  class="row">
                  <div  class=" col-md-4">
                  </div>
                  <div  class=" col-md-4">
                    <button type="submit" name="employeeRegButton"  class="btn-block btn-primary btn-lg">Register Employee</button>
                  </div>
                  <div  class="col-md-4">
                  </div>
                  </div>
            </form>
      </div>
    </div>
  </section>
  <?php
}else{
  echo"Unknow Error Occured";
}
?>
