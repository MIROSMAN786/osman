<?php 
include("header.php");
if(isset($_GET['deleteid']))
{
	$sql = "DELETE FROM purchase_request WHERE purchase_request_id='$_GET[deleteid]'";
	if(!mysqli_query($con,$sql))
	{
		echo "<script>alert('Failed to delete record'); </script>";
	}
	else
	{
		echo "<script>alert('This record deleted successfully..'); </script>";
	}
}

if(isset($_POST['submit']))
{
	  $sqlpurchase_order = "SELECT * FROM purchase_order WHERE purchase_request_id='$_GET[purchaserequestid]' AND status='Pending'";
	  $qsqlpurchase_order = mysqli_query($con,$sqlpurchase_order);
	if(mysqli_num_rows($qsqlpurchase_order) >= 1)
	{	
		$sql = "UPDATE purchase_request SET status='Active' WHERE purchase_request_id='$_GET[purchaserequestid]'";
		$qsql = mysqli_query($con,$sql);
		
		$sqlupd="UPDATE `purchase_order` SET `purchase_amt`='$_POST[price]' WHERE purchase_request_id='$_GET[purchaserequestid]'";
	     if(!mysqli_query($con,$sqlupd))
		{
			echo "Error in mysqli query";
		}
		else
		{
			echo "<script>alert('Purchase order has been updated successfully...');</script>";
		}
	}
	else
	{
		$sql = "UPDATE purchase_request SET status='Active' WHERE purchase_request_id='$_GET[purchaserequestid]'";
		$qsql = mysqli_query($con,$sql);
		
		$sqlins="INSERT INTO `purchase_order`(`product_id`, `purchase_request_id`, `customer_id`, `seller_id`, `purchase_order_date`, `purchase_order_time`, `purchase_amt`, `quantity`, `status`) VALUES ('$_POST[product_id]','$_POST[purchase_request_id]','$_POST[customer_id]','$_SESSION[sellerid]','$_POST[request_date]','$_POST[request_time]','$_POST[price]','$_POST[quantity]','Pending')";
		if(!mysqli_query($con,$sqlins))
		{
			echo "Error in mysqli query";
		}
		else
		{
					echo "<script>alert('Your Purchase Order Sent Successfully...');</script>";	

$sqlproduct = "SELECT * FROM product WHERE product_id='$_POST[product_id]'";
$qsqlproduct = mysqli_query($con,$sqlproduct);
$rsproduct = mysqli_fetch_array($qsqlproduct);

$sqlseller = "SELECT * FROM seller WHERE seller_id='$rsproduct[seller_id]'";
$qsqlseller = mysqli_query($con,$sqlseller);
$rsseller = mysqli_fetch_array($qsqlseller);

$sqlcustomer = "SELECT * FROM customer WHERE customer_id='$_POST[customer_id]'";
$qscustomer = mysqli_query($con,$sqlcustomer);
$rscustomer = mysqli_fetch_array($qscustomer);
$msg = "Your order for $rsproduct[title] has been placed successfully with the bill amount  - Rs. $_POST[price] .. Kindly make the payment before $_POST[expdate].. Otherwise the order will be cancelled..";
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
include("smsapi.php");
if($smsstatus == "Enabled")
{
	$mobno=$rscustomer["mobile_no"];
	$msg= str_replace(" ","%20",$msg);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
	curl_setopt($ch,CURLOPT_URL,  "https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=" . $smsapi . "&senderid=" . $senderid ."&channel=2&DCS=0&flashsms=0&number=$mobno&text=$msg&route=21");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	$buffer = curl_exec($ch);
	if(empty ($buffer))
	{
		//echo " buffer is empty ";
	}
	else
	{
		//echo $buffer; 
	}
	curl_close($ch);
}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		}
	}
}
?>
  <main id="main">


    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in">
		<br><br>
          <h3>Purchase Request</h3>
        </div>

      </div>
    </section><!-- End Cta Section -->


    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="row">
		

          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            <div class="info mt-4 ">
			
		<center><h4>View Purchase Request Detail...</h4></center><hr>

							<table class="table table-striped table-bordered"  style="width:100%">
								<THEAD>
							  <tr>
						      <th><strong>Product</strong></th>
						      <th><strong>Quantity</strong></th>
						      <th><strong>Request Date</strong></th>
						      <th><strong>Expiry Date</strong></th>
						      <th><strong>Note</strong></th>
						      <th><strong>Status</strong></th>
						      </tr>
								</THEAD>
								<TBODY>
<?php
							  $sql = "SELECT * FROM `purchase_request` INNER JOIN product ON product.product_id=purchase_request.product_id  WHERE product.seller_id='$_SESSION[sellerid]' AND purchase_request.purchase_request_id='$_GET[purchaserequestid]'";
							  $qsql = mysqli_query($con,$sql);
							 $rs = mysqli_fetch_array($qsql);
								  
								  $sql1 = "SELECT * FROM product WHERE product_id='$rs[product_id]'";
								  $qsql1 = mysqli_query($con,$sql1);
								  $rs1 = mysqli_fetch_array($qsql1);
							  echo "
						    <tr>
						      <td>&nbsp;$rs1[title]</td>
						      <td>&nbsp;$rs[3]</td>
						      <td>&nbsp;$rs[request_date]</td>
						      <td>&nbsp;$rs[request_date_expire]</td>
						      <td>&nbsp;$rs[note]</td>
						      <td>&nbsp;$rs[7]</td>
					        </tr>";
							  ?>
								</TBODY>
						  </table>
						  <hr>
<h2>Sales Price</h2>
<?php
  $sqlpurchase_order = "SELECT * FROM purchase_order WHERE purchase_request_id='$_GET[purchaserequestid]'";
  $qsqlpurchase_order = mysqli_query($con,$sqlpurchase_order);
  $rspurchase_order = mysqli_fetch_array($qsqlpurchase_order);
?>
<form method="post" action="" name="frmpurchaseorderbill" onSubmit="return validatepurchaseorderbill()">
<input type="hidden" name="product_id" value="<?php echo $rs['product_id']; ?>" >
<input type="hidden" name="purchase_request_id" value="<?php echo $rs['purchase_request_id']; ?>" >
<input type="hidden" name="customer_id" value="<?php echo $rs['customer_id']; ?>" >
<input type="hidden" name="quantity" value="<?php echo $rs[3]; ?>" >
<input type="hidden" name="request_date" value="<?php echo date("Y-m-d"); ?>" >
<input type="hidden" name="request_time" value="<?php echo date("h:i:s"); ?>" >
<input type="hidden" name="expdate" value="<?php echo $rs['request_date_expire']; ?>">

<table class="table table-striped table-bordered"  style="width:100%">
 <tbody>
      
        <tr>
          <td>Quantity: (In <?php 
		 $sqlproduct = " SELECT * FROM  product where product_id='$rs[product_id]'";
		 $qsqlproduct = mysqli_query($con,$sqlproduct);
		 $rspro = mysqli_fetch_array($qsqlproduct);
		  echo $rspro['quantity_type']; 
		  ?>)</td>
          <td><input type="text" name="qty" id="qty" value="<?php echo $rs[3]; ?>" readonly class="form-control"></td>
        </tr>
        <tr>
          <td>Price:&nbsp;</td>
          <td><input type="text" name="price" id="price" value="<?php echo $rspurchase_order['purchase_amt']; ?>" class="form-control"></td>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
          <td><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success"></td>
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
<script type="application/javascript">
	function validatepurchaseorderbill()
	{
		var numericExpression = /^[0-9.]+$/; //Variable to validate only numbers
		 if(document.frmpurchaseorderbill.price.value == "")
		{
			alert("Kindly enter the price..");
			document.frmpurchaseorderbill.price.focus();
			return false;
		}			
		else if(!document.frmpurchaseorderbill.price.value.match(numericExpression))
		{
			alert("Kindly enter only numbers.");
			document.frmpurchaseorderbill.price.focus();
			return false;
		}
		else
		{
			return true;
		}
	}
	
function delconfirm()
{
	if(confirm("Are you sure you want to delete this record?") == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

	</script>