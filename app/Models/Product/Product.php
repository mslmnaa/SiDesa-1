<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderItem;
use App\Models\Order\Cart;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'images',
        'category_id',
        'type',
        'whatsapp_number',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    
    /**
     * Compress and encode image to base64
     */
    public static function compressImage($image, $quality = 60)
    {
        // Check if GD extension is available
        if (!extension_loaded('gd')) {
            // Fallback: Just encode original image to base64 without compression
            $imageData = file_get_contents($image->getPathname());
            $imageInfo = getimagesize($image->getPathname());
            $mimeType = $imageInfo['mime'];
            
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }

        // Get image info
        $imageInfo = getimagesize($image->getPathname());
        $mime = $imageInfo['mime'];
        
        // Create image resource based on type
        switch ($mime) {
            case 'image/jpeg':
                $imageResource = imagecreatefromjpeg($image->getPathname());
                break;
            case 'image/png':
                $imageResource = imagecreatefrompng($image->getPathname());
                break;
            case 'image/gif':
                $imageResource = imagecreatefromgif($image->getPathname());
                break;
            case 'image/webp':
                $imageResource = imagecreatefromwebp($image->getPathname());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }
        
        // Get original dimensions
        $originalWidth = imagesx($imageResource);
        $originalHeight = imagesy($imageResource);
        
        // Calculate new dimensions (max width: 600px for smaller database size)
        $maxWidth = 600;
        if ($originalWidth > $maxWidth) {
            $ratio = $maxWidth / $originalWidth;
            $newWidth = $maxWidth;
            $newHeight = intval($originalHeight * $ratio);
        } else {
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
        }
        
        // Create new image with new dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG/GIF
        if ($mime == 'image/png' || $mime == 'image/gif') {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Resize image
        imagecopyresampled($newImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        
        // Start output buffering
        ob_start();
        
        // Output compressed image
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($newImage, null, $quality);
                break;
            case 'image/png':
                imagepng($newImage, null, 8); // Compresi lebih ringan untuk database
                break;
            case 'image/gif':
                imagegif($newImage);
                break;
            case 'image/webp':
                imagewebp($newImage, null, $quality);
                break;
        }
        
        // Get image data
        $imageData = ob_get_contents();
        ob_end_clean();
        
        // Clean up memory
        imagedestroy($imageResource);
        imagedestroy($newImage);
        
        // Return base64 encoded image with data URI prefix
        return 'data:' . $mime . ';base64,' . base64_encode($imageData);
    }
    
    /**
     * Get image data URI for display
     */
    public function getImageDataUri($index = 0)
    {
        if (!$this->images || !isset($this->images[$index])) {
            return null;
        }
        
        // Return the base64 data URI directly (images are stored as base64)
        return $this->images[$index];
    }
    
    /**
     * Get all image data URIs
     */
    public function getAllImageDataUris()
    {
        if (!$this->images) {
            return [];
        }
        
        // Return all base64 data URIs directly
        return $this->images;
    }
}
