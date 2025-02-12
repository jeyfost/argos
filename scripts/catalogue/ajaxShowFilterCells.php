<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 29.01.2025
 * Time: 15:14
 */

session_start();
include("../connect.php");

$id = $mysqli->real_escape_string($_POST['id']);

switch($id) {
    case "handleTypeContainer":
        $tableName = "handles_types";
        $formName = "handlesTypesForm";
        $checkboxName = "handlesTypeCB";
        $checkboxID = "htcb";
        $cellName = "name";
        break;
    case "handleColorContainer":
        $tableName = "handles_colors";
        $formName = "handlesColorsForm";
        $checkboxName = "handlesColorCB";
        $checkboxID = "hccb";
        $cellName = "name";
        break;
    case "handleSizeContainer":
        $tableName = "handles_sizes";
        $formName = "handlesSizesForm";
        $checkboxName = "handlesSizeCB";
        $checkboxID = "hscb";
        $cellName = "handle_size";
        break;
    case "handleBrandContainer":
        $tableName = "handles_brands";
        $formName = "handlesBrandsForm";
        $checkboxName = "handlesBrandCB";
        $checkboxID = "hbcb";
        $cellName = "name";
        break;
    case "handleMaterialContainer":
        $tableName = "handles_materials";
        $formName = "handlesMaterialsForm";
        $checkboxName = "handlesMaterialCB";
        $checkboxID = "hmcb";
        $cellName = "name";
        break;
    default:
        break;
}

$filterCellsResult = $mysqli->query("SELECT * FROM ".$tableName." ORDER BY ".$cellName);

echo "<form id='".$formName."' class='filtersForm'>";

while($filterCells = $filterCellsResult->fetch_assoc()) {
    echo "<input type='checkbox' value='".$filterCells['id']."' name='".$checkboxName.$filterCells['id']."' id='".$checkboxID.$filterCells['id']."' style='cursor: pointer;' /><label for='".$checkboxName.$filterCells['id']."' style='cursor: pointer;' onclick='markCheckbox(\"".$checkboxID.$filterCells['id']."\")'> ".$filterCells[$cellName]."</label><br />";
}

echo "</form>";