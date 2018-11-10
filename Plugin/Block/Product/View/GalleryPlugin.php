<?php

namespace LoganStellway\CatalogGalleryRoles\Plugin\Block\Product\View;

/**
 * Gallery block plugin
 */
class GalleryPlugin
{
    /**
     * Around get gallery images
     * Description: appends gallery data to images
     * 
     * @param  \Magento\Catalog\Block\Product\View\Gallery $galleryBlock
     * @param  callable                                    $proceed
     * @return string
     */
    public function aroundGetGalleryImagesJson(\Magento\Catalog\Block\Product\View\Gallery $galleryBlock, callable $proceed)
    {
        $product = $galleryBlock->getProduct();
        $galleryEntries = $product->getMediaGalleryEntries();

        if (!is_null($galleryEntries)) {
            $imagesItems = [];
            $entries = [];

            foreach ($galleryEntries as $entry) {
                if ($entry->getFile()) {
                    $entries[$entry->getFile()] = $entry->getTypes();
                }
            }

            foreach ($galleryBlock->getGalleryImages() as $image) {
                $imagesItems[] = [
                    'roles' => isset($entries[$image->getFile()]) ? $entries[$image->getFile()] : [],
                    'thumb' => $image->getData('small_image_url'),
                    'img' => $image->getData('medium_image_url'),
                    'full' => $image->getData('large_image_url'),
                    'caption' => ($image->getLabel() ?: $product->getName()),
                    'position' => $image->getPosition(),
                    'isMain' => $galleryBlock->isMainImage($image),
                    'type' => str_replace('external-', '', $image->getMediaType()),
                    'videoUrl' => $image->getVideoUrl(),
                ];
            }

            if (!empty($imagesItems)) {
                return json_encode($imagesItems);
            }

        }

        return $proceed();
    }
}
