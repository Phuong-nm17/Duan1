<?php
class ProductController extends BaseController
{
    private $productVariant;

    public function __construct()
    {
        parent::__construct();
        $this->productVariant = new ProductVariant($this->conn);
    }

    public function handle()
    {
        $action = $_GET['action'] ?? 'list';

        switch ($action) {
            case 'detail':
                $this->showDetail();
                break;
            case 'add_variant':
                $this->addVariant();
                break;
            case 'update_variant':
                $this->updateVariant();
                break;
            case 'delete_variant':
                $this->deleteVariant();
                break;
            case 'get_variant':
                $this->getVariant();
                break;
            case 'get_variant_info':
                $this->getVariantInfo();
                break;
            default:
                $this->showList();
        }
    }

    private function showDetail()
    {
        $productId = $_GET['id'] ?? 0;

        // Lấy thông tin sản phẩm
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if (!$product) {
            $this->redirect('/?act=404');
            return;
        }

        // Lấy các biến thể của sản phẩm
        $variants = $this->productVariant->getVariantsByProduct($productId);

        // Lấy danh sách màu sắc và kích thước
        $colors = $this->productVariant->getAllColors();
        $sizes = $this->productVariant->getAllSizes();

        $title = $product['name'];
        $content = '
        <div class="row">
            <div class="col-md-6">
                <img src="' . BASE_URL . '/uploads/products/' . htmlspecialchars($product['image']) . '" 
                     alt="' . htmlspecialchars($product['name']) . '" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1>' . htmlspecialchars($product['name']) . '</h1>
                <p class="text-muted">' . htmlspecialchars($product['description']) . '</p>
                
                <div class="variant-selector">
                    <div class="form-group">
                        <label>Màu sắc</label>
                        <select class="form-control" id="color-select">
                            <option value="">Chọn màu</option>
                            ' . $this->generateColorOptions($colors) . '
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Kích thước</label>
                        <select class="form-control" id="size-select">
                            <option value="">Chọn size</option>
                            ' . $this->generateSizeOptions($sizes) . '
                        </select>
                    </div>
                    
                    <div class="price-section">
                        <h3 class="price">Vui lòng chọn màu và size</h3>
                        <p class="stock text-muted"></p>
                    </div>
                    
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" class="form-control" id="quantity" min="1" value="1">
                    </div>
                    
                    <button class="btn btn-primary" id="add-to-cart" disabled>
                        Thêm vào giỏ hàng
                    </button>
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const colorSelect = document.getElementById("color-select");
            const sizeSelect = document.getElementById("size-select");
            const quantityInput = document.getElementById("quantity");
            const addToCartBtn = document.getElementById("add-to-cart");
            const priceSection = document.querySelector(".price");
            const stockSection = document.querySelector(".stock");
            
            let selectedColor = "";
            let selectedSize = "";
            
            colorSelect.addEventListener("change", function() {
                selectedColor = this.value;
                checkVariant();
            });
            
            sizeSelect.addEventListener("change", function() {
                selectedSize = this.value;
                checkVariant();
            });
            
            function checkVariant() {
                if (selectedColor && selectedSize) {
                    fetch(`' . BASE_URL . '/?act=product&action=get_variant_info&product_id=' . $productId . '&color_id=${selectedColor}&size_id=${selectedSize}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                priceSection.innerHTML = `<h3 class="price">${data.price.toLocaleString()}đ</h3>`;
                                stockSection.textContent = `Còn ${data.stock} sản phẩm`;
                                addToCartBtn.disabled = false;
                                
                                // Cập nhật số lượng tối đa
                                quantityInput.max = data.stock;
                                if (quantityInput.value > data.stock) {
                                    quantityInput.value = data.stock;
                                }
                            } else {
                                priceSection.innerHTML = "<h3 class=\"price\">Không có sản phẩm</h3>";
                                stockSection.textContent = "";
                                addToCartBtn.disabled = true;
                            }
                        });
                } else {
                    priceSection.innerHTML = "<h3 class=\"price\">Vui lòng chọn màu và size</h3>";
                    stockSection.textContent = "";
                    addToCartBtn.disabled = true;
                }
            }
            
            addToCartBtn.addEventListener("click", function() {
                if (selectedColor && selectedSize) {
                    const quantity = quantityInput.value;
                    // Thêm vào giỏ hàng
                    // TODO: Implement add to cart functionality
                }
            });
        });
        </script>
        ';

        $this->render('product_detail', [
            'title' => $title,
            'content' => $content
        ]);
    }

    private function getVariant()
    {
        $productId = $_GET['product_id'] ?? 0;
        $colorId = $_GET['color_id'] ?? 0;
        $sizeId = $_GET['size_id'] ?? 0;

        $variant = $this->productVariant->getVariantPriceAndStock($productId, $colorId, $sizeId);

        header('Content-Type: application/json');
        if ($variant) {
            echo json_encode([
                'success' => true,
                'price' => $variant['price'],
                'stock' => $variant['stock']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Variant not found'
            ]);
        }
        exit;
    }

    private function getVariantInfo()
    {
        $productId = $_GET['product_id'] ?? 0;
        $colorId = $_GET['color_id'] ?? 0;
        $sizeId = $_GET['size_id'] ?? 0;

        $variant = $this->productVariant->getVariantPriceAndStock($productId, $colorId, $sizeId);

        header('Content-Type: application/json');
        if ($variant) {
            echo json_encode([
                'success' => true,
                'price' => $variant['price'],
                'stock' => $variant['stock']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy biến thể'
            ]);
        }
        exit;
    }

    private function generateColorOptions($colors)
    {
        $html = '';
        foreach ($colors as $color) {
            $html .= sprintf(
                '<option value="%d" data-color="%s">%s</option>',
                $color['id'],
                $color['code'],
                $color['name']
            );
        }
        return $html;
    }

    private function generateSizeOptions($sizes)
    {
        $html = '';
        foreach ($sizes as $size) {
            $html .= sprintf(
                '<option value="%d">%s</option>',
                $size['id'],
                $size['name']
            );
        }
        return $html;
    }
}
