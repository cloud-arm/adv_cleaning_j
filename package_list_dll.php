<?php
$id = $_GET['id'];
include 'config.php'; // Include your database connection
$result = select('product_list', '*', "product_id ='$id'");

echo '<div class="checkbox-container">'; // Container for checkboxes

for ($i = 0; $row = $result->fetch(); $i++) { 
    $product_id = $row['product_id'];
    ?>
    <div class="checkbox-item">
        <input type="checkbox" name="pro_<?php echo  $row['id']; ?>" id="checkbox_<?php echo $row['id']; ?>" value="1" class="product-checkbox" checked>
        <label for="checkbox_<?php echo $row['id']; ?>" class="product-label"><?php echo $row['name']; ?></label>
    </div>
    <?php 
}

echo '</div>';
?>

<!-- Add CSS for styling -->
<style>
    .checkbox-container {
        display: flex;
        flex-direction: column;
        margin: 20px;
        gap: 15px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .product-label {
        font-size: 16px;
        cursor: pointer;
        color: #333;
    }

    .product-label:hover {
        color: #007BFF;
    }
</style>
