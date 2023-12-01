<?php include_once("header.php")?>
<?php include "db_connection.php";?>
<div class = "contain md-5">
    <div class = "col-2">
    <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#edit">edit information</button>
    </div>
</div>


<div class="modal fade" id="edit">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">edit information</h4>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form method="POST" action="edit_personal_details.php">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="password">username</label>
              <input type="password" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="password">Address</label>
              <input type="password" class="form-control" name="address" id="address" placeholder="Address">
            </div>
            <div class="form-group">
              <label for="password">Phone number</label>
              <input type="password" class="form-control" name="phone_number" id="phone_number" placeholder="Phone number">
            </div>
            <button type="submit" class="btn btn-primary form-control">submit</button>
          </form>
        </div>

      </div>
    </div>
  </div> 