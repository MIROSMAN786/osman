<?php
include("header.php");
if(!isset($_SESSION['adminid']))
{
	echo "<script>window.location='adminloginpanel.php'; </script>";
}
?>
  <main id="main">


    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in">
		<br><br>
          <h3>Dashboard</h3>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            <div class="info mt-4">
	<form method="post" action="" name="frmcstview">
	<table  class="table table-striped table-bordered" style="width:100%" class="datatable" >
  <tbody>
    <tr>
      <th width="263" scope="row">Number of Admin records</th>
      <td width="258">&nbsp;
      <?php
	  $sql = "SELECT * FROM admin WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
    </tr>
    <tr>
       <th scope="row">Number of Category records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM category WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
    <tr>
       <tr>
       <th scope="row">Number of Customer records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM customer WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Produce records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM produce WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Product records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM product WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>

       <tr>
       <th scope="row">Number of Purchase Order records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM purchase_order";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Purchase Order Bill records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM purchase_order_bill WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Purchase Request records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM purchase_request WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Seller records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM seller WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Worker records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM worker WHERE status='Active'";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
       <tr>
       <th scope="row">Number of Worker Request records</th>
      <td>&nbsp;
      <?php
	  $sql = "SELECT * FROM worker_request";
	  $qsql = mysqli_query($con,$sql);
	  echo mysqli_num_rows($qsql);
	  ?>
      </td>
      </tr>
  </tbody>
</table>
  </form>
            </div>
		  </div>
		  
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  
<?php
include("footer.php");
?>
<script>
$(document).ready( function () {
    $('#datatable').DataTable();
} );
</script>