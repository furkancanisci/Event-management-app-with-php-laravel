// /src/components/ProductList.jsx
import React from 'react';

const ProductList = ({ products }) => {
    return (
        <div>
            <h3>Products</h3>
            <ul>
                {products.map(product => (
                    <li key={product.id}>
                        {product.name} - ${product.price}
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default ProductList;