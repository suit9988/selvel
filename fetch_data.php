<?php
	include_once 'include/functions.php';
	$functions = new Functions(); 
//fetch_data.php
$connects = new PDO("mysql:host=localhost;dbname=selvel", "root", "hJ8yW3cP0wV4aW8c");


if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM product WHERE product_status = '1'
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND product_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["size"]))
	{
		$price_filter = implode("','", $_POST["size"]);
		echo $query .= "
		 AND size IN('".$price_filter."')
		";
	}
	if(isset($_POST["price"]))
	{
		$price_filter = implode("','", $_POST["price"]);
		$query .= "
		 AND product_price IN('".$price_filter."')
		";
	}
	if(isset($_POST["brand"]))
	{
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= "
		 AND product_brand IN('".$brand_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		 AND product_ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		 AND product_storage IN('".$storage_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .='
			
			$getProductIdDetails = $functions->query("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."'");
					//$getProductIdDetails = ("SELECT * FROM ".PREFIX."product_subcategory_mapping WHERE category_id='".$catId."' AND subscategory_id='".$subCatId."'");
					while($rowProductIdList = $functions->fetch($getProductIdDetails))
					{
						$productDetails = $functions-> getUniqueProductById($rowProductIdList['product_id']);
						$getProductsizeDetails = $functions->fetch($functions->query("SELECT * FROM ".PREFIX."product_sizes WHERE product_id='".$rowProductIdList['product_id']."' ORDER BY id ASC LIMIT 1"));
						if($productDetails['active'])
						{ ?>

								

              <?php 	}
					}';
		}
			
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>