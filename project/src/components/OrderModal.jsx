import React, { useState } from 'react';

function OrderModal({ onClose, onSubmit }) {
  const [formData, setFormData] = useState({
    customerName: '',
    products: [
      { sku: 'SKU 227', weight: '234 Kg', sellingRate: '', quantity: '' }
    ]
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    const totalPrice = formData.products.reduce((sum, product) => 
      sum + (Number(product.sellingRate) * Number(product.quantity)), 0
    );
    
    onSubmit({
      customerName: formData.customerName,
      totalPrice,
      lastModified: new Date().toISOString(),
      completed: false
    });
    onClose();
  };

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div className="bg-white p-6 rounded-lg w-full max-w-2xl">
        <div className="flex justify-between items-center mb-4">
          <h2 className="text-xl font-semibold">Create Sale Order</h2>
          <button onClick={onClose} className="text-gray-500 hover:text-gray-700">×</button>
        </div>

        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label className="block mb-2">
              Customer Name
              <input
                type="text"
                className="w-full border rounded p-2 mt-1"
                value={formData.customerName}
                onChange={(e) => setFormData({
                  ...formData,
                  customerName: e.target.value
                })}
                required
              />
            </label>
          </div>

          {formData.products.map((product, index) => (
            <div key={index} className="mb-4 p-4 border rounded">
              <h3 className="mb-2">{index + 1}. {product.sku} ({product.weight})</h3>
              <div className="grid grid-cols-2 gap-4">
                <label className="block">
                  Selling Rate
                  <input
                    type="number"
                    className="w-full border rounded p-2 mt-1"
                    placeholder="Enter selling rate"
                    value={product.sellingRate}
                    onChange={(e) => {
                      const newProducts = [...formData.products];
                      newProducts[index].sellingRate = e.target.value;
                      setFormData({ ...formData, products: newProducts });
                    }}
                    required
                  />
                </label>
                <label className="block">
                  Total Items
                  <input
                    type="number"
                    className="w-full border rounded p-2 mt-1"
                    placeholder="Enter quantity"
                    value={product.quantity}
                    onChange={(e) => {
                      const newProducts = [...formData.products];
                      newProducts[index].quantity = e.target.value;
                      setFormData({ ...formData, products: newProducts });
                    }}
                    required
                  />
                </label>
              </div>
            </div>
          ))}

          <div className="flex justify-end gap-2 mt-4">
            <button
              type="button"
              onClick={onClose}
              className="px-4 py-2 text-gray-600 hover:text-gray-800"
            >
              Cancel
            </button>
            <button
              type="submit"
              className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}

export default OrderModal;