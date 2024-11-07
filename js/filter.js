document.getElementById('filters').addEventListener('submit', function(e) {
    e.preventDefault();
    filterProducts();
});

function filterProducts() {
    const category = document.getElementById('category').value;
    const minPrice = document.getElementById('min-price').value;
    const maxPrice = document.getElementById('max-price').value;
    const condition = document.getElementById('condition').value;
    const products = document.getElementsByClassName('product-preview');

    document.getElementById('clear-form').classList.remove('hidden');

    Array.from(products).forEach(function(product) {
        const productCategory = product.getAttribute('category');
        const productPrice = parseFloat(product.getAttribute('price'));
        const productCondition = product.getAttribute('condition');
        if((category === 'all' || productCategory === category) &&
            (minPrice === '' || productPrice >= minPrice) &&
            (maxPrice === '' || productPrice <= maxPrice) &&
            (condition === 'all' || productCondition === condition)){
            product.classList.remove('hidden');
            }
        else {
            product.classList.add('hidden');
        }
    });
}


document.getElementById('clear-form').addEventListener('click', function() {
    const products = document.getElementsByClassName('product-preview');
    Array.from(products).forEach(function(product) {
        product.classList.remove('hidden');
    });
    this.classList.add('hidden');
});