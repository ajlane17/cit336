<?php

/*
 * Custom functions library
 */

// Validates email address
function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

// Check the password for a minimum of 8 characters, 
// at least one capital letter, at least one number,
// and at least one special character
function checkPassword($clientPassword) {
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])[[:print:]]{8,}$/';
    return preg_match($pattern, $clientPassword);
}

function buildNav($categories) {
    $navList = '<ul>';
    $navList .= "<li><a href='/acme/index.php' title='View the Acme home page'>Home</a></li>";
    foreach ($categories as $category) {
        $navList .= "<li><a href='/acme/products/index.php?action=category&categoryName=" . urlencode($category['categoryName']) . "' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

function buildProductsDisplay($products) {
    $pd = '<ul id="prod-display">';
    foreach ($products as $product) {
        $pd .= '<li>';
        $pd .= "<a href='/acme/products/index.php?action=productDetails&id=$product[invId]' title='View $product[invName] Details'><div class=imagePlaceholder><img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'></div></a>";
        $pd .= '<hr>';
        $pd .= "<a href='/acme/products/index.php?action=productDetails&id=$product[invId]' title='View $product[invName] Details'><h2>$product[invName]</h2></a>";
        $pd .= "<span>$product[invPrice]</span>";
        $pd .= '</li>';
    }
    $pd .= '</ul>';
    return $pd;
}

function buildProductDetailsDisplay($product) {
    $prodDetails = '<div id="prod-details">';
    $prodDetails .= "<div id='prodDetailsImage'><img src='$product[invImage]' alt='Image of $product[invName] on Acme.com'></div>";
    $prodDetails .= "<div id='prodDetailsText'>";
    $prodDetails .= "<p>$product[invDescription]</p>";
    $prodDetails .= "<br><p>A $product[invVendor] product</p>";
    $prodDetails .= "<p>Primary material: $product[invStyle]</p>";
    $prodDetails .= "<p>Product weight: $product[invWeight] lbs.</p>";
    $prodDetails .= "<p>Shipping size: $product[invSize] inches (w x l x h)</p>";
    $prodDetails .= "<p>Ships from: $product[invLocation]</p>";
    $prodDetails .= "<br><p>Number in stock: $product[invStock]</p>";
    $prodDetails .= "<br><p id=prodPrice>$$product[invPrice]</p>";
    $prodDetails .= "</div>";
    $prodDetails .= '</div>';
    return $prodDetails;
}

function buildThumbnailsDisplay($thumbnails, $product) {
    $td = '<hr>';
    $td .= '<h2>Additional Images</h2>';
    $td .= '<div id="thumbnailDisplay">';
    foreach ($thumbnails as $thumbnail) {
        $td .= '<div class="thumbnailPlaceholder">';
        $td .= "<img src='$thumbnail[imgPath]' alt='thumbnail: $thumbnail[imgName] for $product[invName], on Acme.com'>";
        $td .= '</div>';
    }
    $td .= '</div>';
    return $td;
}

function buildProdManagementList($products) {
    $prodList = '<table class="productList">';
    $prodList .= '<thead>';
    $prodList .= '<tr><th>Product Name</th><th>&nbsp;</th><th>&nbsp;</th></tr>';
    $prodList .= '</thead>';
    $prodList .= '<tbody>';
    foreach ($products as $product) {
        $prodList .= "<tr><td>$product[invName]</td>";
        $prodList .= "<td class='buttonColum'><a href='/acme/products?action=mod&id=$product[invId]' class='listButton' title='Click to modify'>Modify</a></td>";
        $prodList .= "<td class='buttonColum'><a href='/acme/products?action=del&id=$product[invId]' class='listButton' title='Click to delete'>Delete</a></td></tr>";
    }
    $prodList .= '</tbody></table>';
    return $prodList;
}

/* * ********************************
 *  Functions for working with images
 * ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
        $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the products select list
function buildProductsSelect($products) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
        $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir . makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the resizeImage function
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
}

// ends the if - else began on line 36
