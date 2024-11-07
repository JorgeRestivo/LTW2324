<?php
    function print_search_filters(){
        $categories = ['Electronics', 'Books', 'Clothing']; // Replace with your categories
        $conditions = ['New', 'Used', 'Refurbished']; // Replace with your conditions
        $priceRange = range(1, 101); // Replace with your price range
    ?>

<form action="" method="get">
    <div>
        <label for="category">Category:</label>
        <select id="category" name="category">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category; ?>"><?= $category; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="price">Price:</label>
        <select id="price" name="price">
            <?php foreach ($priceRange as $price): ?>
                <option value="<?= $price; ?>"><?= $price; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="condition">Condition:</label>
        <select id="condition" name="condition">
            <?php foreach ($conditions as $condition): ?>
                <option value="<?= $condition; ?>"><?= $condition; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Filter">
    </div>
</form>
<?php } ?>