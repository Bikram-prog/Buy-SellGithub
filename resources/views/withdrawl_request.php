<?php require 'conn.php'; ?>
<?php include 'admin-header.php';?>

<!-- Sidebar Menu -->
<?php include 'admin-sidebar.php';?>


 <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<?php 

$sql = "SELECT t1.*,t2.*,t3.* FROM withdraw_seller t1 LEFT JOIN seller_bank_dtls t2 ON (t1.withdrw_sel_id=t2.bank_sel_id) LEFT JOIN seller_users t3 ON (t1.withdrw_sel_id=t3.s_id)"; 
$result = $mysqli->query($sql); 

?> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Withdrawl Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Withdrawl</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Seller Name</th>
                    <th>Company Name</th> 
                    <th>E-mail</th> 
                    <th>Withdrawl Amount</th> 
                    <th>Bank Name</th> 
                    <th>Account Holder Name</th> 
                    <th>Account Number</th> 
                    <th>Date & Time</th> 
                    <th>Status</th> 
                  </tr>
                  </thead>
                 <tbody>
                   <?php 
                      while($rows=$result->fetch_assoc()) 
                      { 
                    ?> 
                    <tr> 
                      <td><?php echo $rows['prod_title'];?></td> 
                      <td><?php echo $rows['prod_tags'];?></td> 
                      <td><?php echo $rows['prod_quantity'];?></td> 
                      <td><?php echo $rows['prod_reg_price'];?></td> 
                      <td><?php if ($rows['payment_amount'] != "") { ?>
                            <?php echo "Paid";?>
                        <?php } else { ?>
                          <?php echo "Unpaid";?>
                        <?php } ?>

                        </td> 
                      <td><?php echo $rows['created_at'];?></td> 
                    </tr> 
                    <?php 
                      } 
                    ?> 

                       
                 </tbody>
                  <tfoot>
                  <tr>
                    <th>Seller Name</th> 
                    <th>Withdrawl Amount</th> 
                    <th>Bank Name</th> 
                    <th>Account Holder Name</th> 
                    <th>Account Number</th> 
                    <th>Status</th> 

                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  

<?php include 'admin-footer.php';?>
