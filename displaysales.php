<?php
include("header.php");
?>
  <main id="main">

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="text-center" data-aos="zoom-in">
			<br>
			<br>
			<br>
          <h3>Farmer's Market</h3>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
<?php
if(isset($_GET['category_id']))
{
?>
<li data-filter="*" class="filter-active"><?php echo $_GET['category']; ?></li>
<?php
}
else
{
?>
<li data-filter="*" class="filter-active">All items</li>
<?php
}
?>
            </ul>
          </div>
        </div>
		

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact" style="padding: 1px 0;">
      <div class="container">
	  
        <div class="row">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
<form method="get" action="" name="frmsalessearch" onSubmit="return validatesalessearch()">
<?php
if(isset($_GET['category_id']))
{
?>
<input type="hidden" name="category_id" id="category_id" value="<?php echo $_GET['category_id']; ?>" >
<input type="hidden" name="category" id="category" value="<?php echo $_GET['category']; ?>" >
<?php
}
?>
            <div class="row">
              <div class="col-lg-4">
                <div class="info w-100">
                  <h6>Select state:</h6>
<span id='loadstate'><select name="state"  autofocus class="search_categories form-control" onChange="loadcity(this.value)" ><option value="">Select State</option>
<?php
$sql2 = "SELECT * FROM state where status='Active' ";
$qsql2 =mysqli_query($con,$sql2);
while($rssql2 = mysqli_fetch_array($qsql2))
{
	if($_GET['state'] == $rssql2['state_id'])
	{
	echo "<option value='" . $rssql2['state_id'] . "' selected>" . $rssql2['state'] ."</option>";
	}
	else
	{
		echo "<option value='" . $rssql2['state_id'] . "' >" . $rssql2['state'] ."</option>";
	}
}
?>
</select></span>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="info w-100">
                  <h6>Select city:</h6>
<span id='loadcity'><select name="city"  autofocus class="search_categories form-control"><option value="">Select City</option><?php
$sql3 = "SELECT * FROM city where status='Active' AND state_id='$_GET[state]'";
$qsql3 =mysqli_query($con,$sql3);
while($rssql3 = mysqli_fetch_array($qsql3))
{
  if($rssql3['city_id'] == $_GET['city'] )
  {
  echo "<option value='$rssql3[city_id]' selected>$rssql3[city]</option>";
  }
  else
  {
  echo "<option value='$rssql3[city_id]'>$rssql3[city]</option>";
  }
}
?></select></span>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="info w-100">
        <input type="submit" name="submit" id="submit" value="Search" class="btn btn-info"> 
      <a href="displaysales.php">Clear Search</a>
                </div>
              </div>
            </div>
</form>
		 </div>
        </div>

      </div>
    </section><!-- End Contact Section -->

<hr>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
<?php
if(isset($_GET['submit']))
{
	$sql = "SELECT * FROM product INNER JOIN seller ON product.seller_id = seller.seller_id  WHERE product.status='Active' and product.quantity>1 AND seller.state_id='$_GET[state]' and seller.city_id='" . $_GET['city'] . "'";
	if(isset($_GET['category_id']))
	{
		$sql = $sql . " AND product.category_id='$_GET[category_id]'";
	}
  $qsql = mysqli_query($con,$sql);
  echo mysqli_error($con);
	 if(mysqli_num_rows($qsql)  == 0)
	{
		echo " <div class='col-lg-12 col-md-12 portfolio-item filter-app'><br><center><h2>No Items to display based on location given...</h2></center></br></div>";
	}
}
else
{
	$sql = "SELECT * FROM product WHERE status='Active' ";
	if(isset($_GET['category_id']))
	{
		$sql = $sql . " AND product.category_id='" . $_GET['category_id'] ."'";
	} 
	$sql = $sql . " and quantity>1";
  $qsql = mysqli_query($con,$sql);
}
  while($rs = mysqli_fetch_array($qsql))
  {
?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="imgproduct/<?php echo $rs['img_1']; ?>" class="img-fluid" alt="" style="width: 100%;height: 300px;">
              <div class="portfolio-info">
                <h4><?php echo $rs['title']; ?></h4>
                <p><strong>Quantity :</strong> <?php echo $rs['quantity']; ?> <?php echo $rs['quantity_type']; ?></p>
                <div class="portfolio-links">
                  <a href="displaysalesdetailed.php?productid=<?php echo $rs[0]; ?>" title="More Details" class="btn btn-info"><i class="bx bx-link"></i> View More</a>
                </div>
              </div>
            </div>
          </div>
<?php
}
?>

        </div>

      </div>
    </section><!-- End Portfolio Section -->

 
  </main><!-- End #main -->
  
<?php
include("footer.php");
?>
<script type="application/javascript">

function loadstate(id) {
    if (id == "") {
        document.getElementById("loadstate").innerHTML = "<select name='state'><option value=''>Select</option></select>";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("loadstate").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxstate.php?id="+id,true);
        xmlhttp.send();
    }
}
function loadcity(id) 
{
    if (id == "") 
	{
        document.getElementById("loadcity").innerHTML = "";
        return;
    } else
	 { 
        if (window.XMLHttpRequest)
		 {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } 
		else 
		{
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
		 {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
			{
                document.getElementById("loadcity").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxcity.php?id="+id,true);
        xmlhttp.send();
    }
}

function validatesalessearch()
{
	if(document.frmsalessearch.state.value == "")
	{
		alert("Kindly select the state to search..");
		document.frmsalessearch.state.focus();
		return false;
	}	
	else if(document.frmsalessearch.city.value == "")
	{
		alert("Kindly select the city to search..");
		document.frmsalessearch.city.focus();
		return false;
	}
	else
	{
		return true;
	}

}
</script>