<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();

	$category_id = implode(',', $_POST['category_id']);
	$attributeSQL = $admin->getAttributesByCategoryId($category_id);
	if($admin->num_rows($attributeSQL)>0) {
		$response = '<div class="card-header">
			<h4 class="card-title mb-0"> Product Filters</h4>
		</div>
		<div class="card-body">
			<div class="form-group row">';
				$i=1;
				while($attributes = $admin->fetch($attributeSQL)) {
					$attribute = $admin->getUniqueAttributeById($attributes['attribute_id']);
					$response .= '<div class="col-sm-3">
						<label>'.$attribute['attribute_name'].'</label>
						<select name="filter_value[]" id="filter_value" class="form-control">
							<option value="">Select '.$attribute['attribute_name'].'</option>';
							$attributeValueSql = $admin->getAttributeValues($attribute['id']);
							while($attributeValue = $admin->fetch($attributeValueSql)) {
								$response .= '<option value="'.$attributeValue['id'].'">'.$attributeValue['feature'].'</option>';
							}
						$response .= '</select>
						<input type="hidden" name="filter_name[]" value="'.$attribute['id'].'">
					</div>
					';
					if($i++%12==0) {
						$response .= '<div class="clearfix"></div>';
					}
				}
		$response .= '
			</div>
		</div>';
	} else {
		$response = '';
	}
	$ajaxResponse = array();
	$ajaxResponse['status'] = 1;
	$ajaxResponse['responseContent'] = $response;
	echo json_encode($ajaxResponse);
?>