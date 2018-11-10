# Magento 2 - Add Roles to Gallery JSON

This repo serves as an example of how to add gallery roles to the Magento 2 product gallery JSON.

## Implementation

A [plugin (interceptor)](https://devdocs.magento.com/guides/v2.2/extension-dev-guide/plugins.html) is created for the class method [`Magento\Catalog\Block\Product\View\Gallery::getGalleryImagesJson()`](https://github.com/magento/magento2/blob/2.3-develop/app/code/Magento/Catalog/Block/Product/View/Gallery.php#L135). 

Note:
The image EAV attributes (`image`, `thumbnail`, etc..) must be loaded in the product models (or added to the select of a product collection) in order for the roles to be added properly to the JSON data. This should not be a problem on the product view page, as I believe all attributes that are visible on the frontend are loaded. 
