import React from 'react';

function TabSelector({ activeTab, onTabChange }) {
  return (
    <div className="flex gap-2">
      <button
        className={`px-4 py-2 rounded-full ${
          activeTab === 'active'
            ? 'bg-teal-100 text-teal-800'
            : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
        }`}
        onClick={() => onTabChange('active')}
      >
        Active Sale Orders
      </button>
      <button
        className={`px-4 py-2 rounded-full ${
          activeTab === 'completed'
            ? 'bg-teal-100 text-teal-800'
            : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
        }`}
        onClick={() => onTabChange('completed')}
      >
        Completed Sale Orders
      </button>
      <button
        className={`px-4 py-2 rounded-full ${
          activeTab === 'products'
            ? 'bg-teal-100 text-teal-800'
            : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
        }`}
        onClick={() => onTabChange('products')}
      >
        Show Products
      </button>
    </div>
  );
}

export default TabSelector;